<?php
session_start();
require_once("./config.php");

$vnp_SecureHash = $_GET['vnp_SecureHash'];
unset($_GET['vnp_SecureHash']);
unset($_GET['vnp_SecureHashType']);
ksort($_GET);
$hashData = "";
$i = 0;
foreach ($_GET as $key => $value) {
    if ($i == 1) $hashData .= '&';
    $hashData .= urlencode($key) . "=" . urlencode($value);
    $i = 1;
}
$secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

// So sánh hash để kiểm tra tính toàn vẹn
if ($secureHash == $vnp_SecureHash) {
    if ($_GET['vnp_ResponseCode'] == '00') {
        // Thanh toán thành công
        $orderid = $_GET['vnp_TxnRef'];
        $userid = $_SESSION['fosuid'];

        // Lưu đơn hàng và địa chỉ vào DB
        include_once('includes/dbconnection.php');
        $orderno = $orderid;
        $cod = 1;
        $fnaobno = $_SESSION['flatbldgnumber'];
        $street = $_SESSION['streename'];
        $area = $_SESSION['area'];
        $lndmark = $_SESSION['landmark'];
        $city = $_SESSION['city'];

        $query = "UPDATE tblorders SET OrderNumber='$orderno',IsOrderPlaced='1',CashonDelivery='$cod' WHERE UserId='$userid' AND IsOrderPlaced IS NULL;";
        $query .= "INSERT INTO tblorderaddresses(UserId,Ordernumber,Flatnobuldngno,StreetName,Area,Landmark,City) VALUES('$userid','$orderno','$fnaobno','$street','$area','$lndmark','$city');";

        $result = mysqli_multi_query($con, $query);

        echo "<h3 style='color:green'>Thanh toán thành công. Mã đơn hàng: $orderno</h3>";
        echo "<script>setTimeout(() => window.location.href='my-order.php', 3000);</script>";
    } else {
        echo "<h3 style='color:red'>Thanh toán thất bại. Mã lỗi: " . $_GET['vnp_ResponseCode'] . "</h3>";
    }
} else {
    echo "<h3 style='color:red'>Xác thực không hợp lệ!</h3>";
}
?>
