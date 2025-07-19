<?php
session_start();
require_once("./config.php");

// Kiểm tra session hợp lệ
if (!isset($_SESSION['orderid']) || !isset($_SESSION['money'])) {
    echo "Thiếu dữ liệu!";
    exit();
}

$orderid = $_SESSION['orderid'];
$amount = $_SESSION['money']; // ví dụ: 200000
$orderInfo = "Thanh toán đơn hàng #" . $orderid;
$orderType = "billpayment";
$amount_vnp = $amount * 100;
$locale = "vn";
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

$vnp_SecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
$vnp_Url = $vnp_Url . "?" . $query . 'vnp_SecureHash=' . $vnp_SecureHash;

// Redirect đến cổng thanh toán
header('Location: ' . $vnp_Url);
exit();
?>
