<?php
session_start();
error_reporting(0);
include_once('includes/dbconnection.php');

if (!isset($_GET['oid'])) {
    echo "<p style='color:red;'>Mã đơn hàng không hợp lệ.</p>";
    exit();
}

if (isset($_POST['submit'])) {
    $orderid = $_GET['oid'];
    $ressta = "Đơn hàng đã bị hủy";
    $remark = $_POST['restremark'];
    $canclbyuser = 1;

    // Ghi vào bảng theo dõi đơn hàng
    $insertTracking = mysqli_query($con, "INSERT INTO tblfoodtracking(OrderId, remark, status, StatusDate, OrderCanclledByUser) 
        VALUES ('$orderid', '$remark', '$ressta', NOW(), '$canclbyuser')");

    // Cập nhật trạng thái cuối cùng của đơn hàng
    $updateOrder = mysqli_query($con, "UPDATE tblorderaddresses SET OrderFinalStatus='$ressta' WHERE Ordernumber='$orderid'");

    if ($insertTracking && $updateOrder) {
        $msg = "Đơn hàng đã được hủy thành công.";
    } else {
        $msg = "Có lỗi xảy ra. Vui lòng thử lại.";
    }
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> Hủy đơn hàng</title>
</head>
<body>

<div style="margin-left:50px;">
<?php  
$orderid=$_GET['oid'];
$query=mysqli_query($con,"select Ordernumber,OrderFinalStatus from tblorderaddresses where Ordernumber='$orderid'");
$num=mysqli_num_rows($query);
$cnt=1;
?>

<table border="1"  cellpadding="10" style="border-collapse: collapse; border-spacing:0; width: 100%; text-align: center;">
  <tr align ="center">
   <th colspan="4" >Hủy đơn hàng #<?php echo  $orderid;?></th> 
  </tr>
  <tr>
<th>Mã đơn hàng </th>
<th>Tình trạng đơn hàng </th>
</tr>
<?php  
while ($row=mysqli_fetch_array($query)) {
  ?>
<tr> 
  <td><?php  echo $orderid;?></td> 
   <td><?php  $status=$row['OrderFinalStatus'];
if($status==""){
  echo "Đang chờ xác nhận";
} else { 
echo $status;
}
?></td> 
</tr>
<?php 
} ?>

</table>
     <?php if($status=="" || $status=="Order Accept") {?>
<form method="post">
      <table>
        <tr>
          <th>Lý do hủy </th>
<td>    <textarea name="restremark" placeholder="" rows="12" cols="50" class="form-control wd-450" required="true"></textarea></td>
        </tr>
<tr>
  <td colspan="2" align="center"><button type="submit" name="submit" class="btn btn-primary">Cập nhật đơn hàng</button></td>

</tr>
      </table>

</form>
    <?php } else { ?>
<?php if($status=='Đơn hàng đã bị hủy'){?>
<p style="color:red; font-size:20px;"> Đơn hàng đã hủy</p>
<?php } else { ?>
  <p style="color:red; font-size:20px;"> Bạn không thể hủy việc này. Đơn hàng đang được vận chuyển hoặc đã giao</p>

<?php }  } ?>
  
</div>

</body>
</html>

     