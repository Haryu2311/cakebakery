<?php
session_start();
error_reporting(0);
include_once('includes/dbconnection.php');
if (strlen($_SESSION['fosuid']==0)) {
  header('location:logout.php');
  } else{ 

 

    ?>
<script language="javascript" type="text/javascript">
function f2()
{
window.close();
}
function f3()
{
window.print(); 
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Bánh ngọt-Hóa đơn</title>
</head>
<body>

<div style="margin-left:50px;">

<?php  
$oid=$_GET['oid'];
$query = mysqli_query($con,"
SELECT tblorderaddresses.OrderTime, tblfood.Image, tblfood.ItemName, tblfood.Weight, tblorders.FoodQty, tblfood.ItemPrice, 
tblorders.FoodId, tblorders.OrderNumber, tblorders.ItemQty 
FROM tblorders 
JOIN tblfood ON tblfood.ID = tblorders.FoodId 
JOIN tblorderaddresses ON tblorderaddresses.Ordernumber = tblorders.OrderNumber 
WHERE tblorders.OrderNumber = '$oid' AND tblorders.IsOrderPlaced = 1");

$num=mysqli_num_rows($query);
$cnt=1;
?>

<table border="1"  cellpadding="10" style="border-collapse: collapse; border-spacing:0; width: 100%; text-align: center;">
  <tr align="center">
   <th colspan="8" >Hóa đơn của #<?php echo  $oid;?></th> 
  </tr>
  <tr>
    <th colspan="4">Ngày tạo hóa đơn:</th>
<td colspan="4">  </b> <?php echo $_GET['odate'];?></td>
  </tr>
  <tr>
     <th>#</th>
                                
                  <th>Ảnh</th>
  <th>Tên</th>
  <th>Khối lượng</th>
  <th>Số bánh</th>
  <th>Giá</th>
  <th>Số lượng</th>
  <th>Tổng</th>
</tr>
<?php  
$grandtotal = 0;
$cnt = 1;
while ($row = mysqli_fetch_array($query)) {
  $total = $row['ItemPrice'] * $row['ItemQty'];

  // Lấy và tách khối lượng
  $weightStr = trim($row['Weight']); // Ví dụ: "1.5 kg", "500 gm"
  preg_match('/([\d\.]+)\s*(kg|gm)/i', $weightStr, $matches);
  $weightValue = isset($matches[1]) ? floatval($matches[1]) : 0;
  $weightUnit = isset($matches[2]) ? strtolower($matches[2]) : 'gm';

  // Chuyển đổi về gram
  $weightInGrams = ($weightUnit == 'kg') ? $weightValue * 1000 : $weightValue;

  // Tổng khối lượng theo số lượng
  $totalWeight = $weightInGrams * $row['ItemQty'];
?>
<tr>
  <td><?php echo $cnt; ?></td>
  <td><img src="admin/itemimages/<?php echo $row['Image']; ?>" width="60" height="40" alt=""></td> 
  <td><?php echo $row['ItemName']; ?></td>   
  
  <!-- Khối lượng đã nhân với số lượng -->
<td>
  <?php 
    if ($totalWeight >= 1000) {
      echo rtrim(rtrim(number_format($totalWeight / 1000, 2, '.', ''), '0'), '.') . " kg";
    } else {
      echo number_format($totalWeight, 0) . " g";
    }
  ?>
</td>
<td><?php echo $row['FoodQty'] * $row['ItemQty']; ?> chiếc</td>

  <td><?php echo number_format($row['ItemPrice'], 0, ',', '.'); ?> VNĐ</td> 
  <td><?php echo $row['ItemQty']; ?></td> 
  <td><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</td>
</tr>
<?php 
$grandtotal += $total;
$cnt++;
} ?>


</table>
     
     <p >
      <input name="Submit2" type="submit" class="txtbox4" value="Close" onClick="return f2();" style="cursor: pointer;"  />   <input name="Submit2" type="submit" class="txtbox4" value="Print" onClick="return f3();" style="cursor: pointer;"  /></p>
</div>

</body>
</html>

  <?php } ?>   