<?php
session_start();
include_once('includes/dbconnection.php');

// Đảm bảo người dùng đã đăng nhập
if (strlen($_SESSION['fosuid']) == 0) {
    header('location:logout.php');
    exit();
}

$userid = $_SESSION['fosuid'];
$foodid = intval($_GET['foodid']); // ID sản phẩm gửi qua URL

// Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa (chưa đặt hàng)
$check = mysqli_query($con, "SELECT ID, ItemQty FROM tblorders WHERE UserId = '$userid' AND FoodId = '$foodid' AND IsOrderPlaced IS NULL");

if (mysqli_num_rows($check) > 0) {
    // Nếu sản phẩm đã có, tăng số lượng lên 1
    $row = mysqli_fetch_assoc($check);
    $newQty = $row['ItemQty'] + 1;
    $orderId = $row['ID'];

    mysqli_query($con, "UPDATE tblorders SET ItemQty = '$newQty' WHERE ID = '$orderId'");
} else {
    // Nếu sản phẩm chưa có, thêm mới với số lượng = 1
    mysqli_query($con, "INSERT INTO tblorders(UserId, FoodId, ItemQty, IsOrderPlaced) VALUES('$userid', '$foodid', 1, NULL)");
}

// Quay lại giỏ hàng
header("Location: cart.php");
exit();
?>