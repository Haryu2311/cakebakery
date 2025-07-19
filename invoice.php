<?php
session_start();
error_reporting(0);
include_once('includes/dbconnection.php');
if (strlen($_SESSION['fosuid'] == 0)) {
    header('location:logout.php');
} else {
?>
<script language="javascript" type="text/javascript">
function f2() {
    window.close();
}
function f3() {
    window.print(); 
}
</script>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Bánh ngọt - Hóa đơn</title>
</head>
<body>
<div style="margin-left:50px;">
<?php  
$oid = $_GET['oid'];
$userid = $_SESSION['fosuid'];

// Kiểm tra khách hàng thân thiết
$isLoyal = false;
$checkLoyal = mysqli_query($con, "SELECT IsLoyalCustomer FROM tbluser WHERE ID = '$userid'");
if ($checkLoyal && mysqli_num_rows($checkLoyal) > 0) {
    $loyal = mysqli_fetch_assoc($checkLoyal);
    if ($loyal['IsLoyalCustomer'] == 1) {
        $isLoyal = true;
    }
}

// Lấy thông tin đơn hàng
$query = mysqli_query($con, "
    SELECT tblorderaddresses.OrderTime, tblfood.Image, tblfood.ItemName, tblfood.Weight, tblorders.FoodQty, tblfood.ItemPrice, 
           tblorders.FoodId,tblorders.Price, tblorders.OrderNumber, tblorders.ItemQty 
    FROM tblorders 
    JOIN tblfood ON tblfood.ID = tblorders.FoodId 
    JOIN tblorderaddresses ON tblorderaddresses.Ordernumber = tblorders.OrderNumber 
    WHERE tblorders.OrderNumber = '$oid' AND tblorders.IsOrderPlaced = 1");

$num = mysqli_num_rows($query);
$cnt = 1;
$grandtotal = 0;
?>
<table border="1" cellpadding="10" style="border-collapse: collapse; width: 100%; text-align: center;">
    <tr align="center">
        <th colspan="8">Hóa đơn của #<?php echo $oid; ?></th> 
    </tr>
    <tr>
        <th colspan="4">Ngày tạo hóa đơn:</th>
        <td colspan="4"><?php echo $_GET['odate']; ?></td>
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
while ($row = mysqli_fetch_array($query)) {

    $unitPrice = $row['Price'];
    $total = $unitPrice * $row['ItemQty'];

    // Tính khối lượng
    $weightStr = trim($row['Weight']); 
    preg_match('/([\d\.]+)\s*(kg|gm)/i', $weightStr, $matches);
    $weightValue = isset($matches[1]) ? floatval($matches[1]) : 0;
    $weightUnit = isset($matches[2]) ? strtolower($matches[2]) : 'gm';
    $weightInGrams = ($weightUnit == 'kg') ? $weightValue * 1000 : $weightValue;
    $totalWeight = $weightInGrams * $row['ItemQty'];
?>
<tr>
    <td><?php echo $cnt; ?></td>
    <td><img src="admin/itemimages/<?php echo $row['Image']; ?>" width="60" height="40" alt=""></td> 
    <td><?php echo $row['ItemName']; ?></td>   
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
    <td><?php echo number_format($unitPrice, 0, ',', '.'); ?> VNĐ</td> 
    <td><?php echo $row['ItemQty']; ?></td> 
    <td><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</td>
</tr>
<?php 
    $grandtotal += $total;
    $cnt++;
} ?>
<tr>
    <th colspan="5" style="text-align: center;">Tổng cộng:</th>
    <th colspan="3"><?php echo number_format($grandtotal, 0, ',', '.'); ?> VNĐ</th>
</tr>
</table>

<p>
    <input name="Submit2" type="submit" class="txtbox4" value="Close" onClick="return f2();" style="cursor: pointer;" />
    <input name="Submit2" type="submit" class="txtbox4" value="Print" onClick="return f3();" style="cursor: pointer;" />
</p>
</div>
</body>
</html>
<?php } ?>
