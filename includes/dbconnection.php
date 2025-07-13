<?php
$con = mysqli_connect("localhost", "root", "", "cakebakery");
if (mysqli_connect_errno()) {
    echo "Connection Fail" . mysqli_connect_error();
    exit(); // nếu lỗi thì dừng luôn
}

// Thêm dòng này để set UTF-8
mysqli_set_charset($con, "utf8mb4");

?>