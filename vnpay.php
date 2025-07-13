<?php
session_start();
require_once("./config.php");

// Lấy thông tin từ session
$amount = isset($_SESSION['money']) ? $_SESSION['money'] : 0;
$orderid = $_SESSION['orderid']; // Được tạo ở checkout.php
$orderInfo = "Thanh toán đơn hàng #" . $orderid;
$orderType = "billpayment";
$amount_vnp = $amount * 100; // Đơn vị VNPAY yêu cầu là x100
$locale = "vn";
$bankCode = "";
$ipAddr = $_SERVER['REMOTE_ADDR'];

$inputData = array(
    "vnp_Version" => "2.1.0",
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $amount_vnp,
    "vnp_Command" => "pay",
    "vnp_CreateDate" => date('YmdHis'),
    "vnp_CurrCode" => "VND",
    "vnp_IpAddr" => $ipAddr,
    "vnp_Locale" => $locale,
    "vnp_OrderInfo" => $orderInfo,
    "vnp_OrderType" => $orderType,
    "vnp_ReturnUrl" => $vnp_Returnurl,
    "vnp_TxnRef" => $orderid
);

ksort($inputData);
$hashdata = "";
$query = "";
$i = 0;
foreach ($inputData as $key => $value) {
    if ($i == 1) $hashdata .= '&';
    $hashdata .= urlencode($key) . "=" . urlencode($value);
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
    $i = 1;
}

$vnp_Url = $vnp_Url . "?" . $query;
$vnp_SecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
$vnp_Url .= 'vnp_SecureHash=' . $vnp_SecureHash;

// Redirect sang trang thanh toán của VNPAY
header('Location: ' . $vnp_Url);
exit();
?>
