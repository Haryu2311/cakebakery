<?php
session_start();
require_once("./config.php");
include_once('includes/dbconnection.php');

// Lấy lại session
if (!isset($_SESSION['orderid']) || !isset($_SESSION['fosuid'])) {
    echo "<h3 style='color:red'>Phiên làm việc hết hạn!</h3>";
    exit;
}

$orderid = $_SESSION['orderid'];
$userid = $_SESSION['fosuid'];

// Xác thực chữ ký
$vnp_SecureHash = $_GET['vnp_SecureHash'];
unset($_GET['vnp_SecureHash']);
unset($_GET['vnp_SecureHashType']);
ksort($_GET);

$hashData = "";
foreach ($_GET as $key => $value) {
    $hashData .= urlencode($key) . "=" . urlencode($value) . "&";
}
$hashData = rtrim($hashData, "&");

$secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

if ($secureHash === $vnp_SecureHash) {
    if ($_GET['vnp_ResponseCode'] === '00') {
        // ✅ Cập nhật đơn hàng
        $update = mysqli_query($con, "UPDATE tblorders SET IsOrderPlaced=1, CashonDelivery=1 WHERE UserId='$userid' AND OrderNumber='$orderid'");

        // ✅ Thêm địa chỉ
        if ($update) {
            $fnaobno = $_SESSION['flatbldgnumber'];
            $street = $_SESSION['streename'];
            $area = $_SESSION['area'];
            $lndmark = $_SESSION['landmark'];
            $city = $_SESSION['city'];

            mysqli_query($con, "INSERT INTO tblorderaddresses(UserId, Ordernumber, Flatnobuldngno, StreetName, Area, Landmark, City) 
            VALUES('$userid', '$orderid', '$fnaobno', '$street', '$area', '$lndmark', '$city')");
        }

        echo "<h3 style='color:green'>Thanh toán thành công. Mã đơn hàng: <strong>$orderid</strong></h3>";
        unset($_SESSION['orderid']);
        echo "<script>setTimeout(() => window.location.href='my-order.php', 3000);</script>";
    } else {
        echo "<h3 style='color:red'>Thanh toán thất bại. Mã lỗi: " . $_GET['vnp_ResponseCode'] . "</h3>";
    }
} else {
    echo "<h3 style='color:red'>Xác thực không hợp lệ!</h3>";
}
?>
