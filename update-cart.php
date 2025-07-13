<?php
session_start();
include('includes/dbconnection.php');

if (isset($_POST['order_id'])) {
    $orderId = intval($_POST['order_id']);
    $action = isset($_POST['increase']) ? 'increase' : 'decrease';

    $query = mysqli_query($con, "SELECT ItemQty FROM tblorders WHERE ID = '$orderId'");
    $row = mysqli_fetch_array($query);
    $currentQty = $row['ItemQty'];

    if ($action == 'increase') {
        $newQty = $currentQty + 1;
    } elseif ($action == 'decrease') {
        $newQty = max(1, $currentQty - 1); // Không cho nhỏ hơn 1
    }

    mysqli_query($con, "UPDATE tblorders SET ItemQty = '$newQty' WHERE ID = '$orderId'");
}

header("Location: cart.php");
exit();
?>
