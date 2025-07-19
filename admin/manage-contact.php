<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['fosaid']) == 0) {
    header('location:logout.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Quản lý liên hệ khách hàng</title>
    <meta charset="UTF-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
<div id="wrapper">
    <?php include_once('includes/leftbar.php'); ?>
    <div id="page-wrapper" class="gray-bg">
        <?php include_once('includes/header.php'); ?>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Danh sách liên hệ khách hàng</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Họ tên</th>
                                            <th>Email</th>
                                            <th>Nội dung</th>
                                            <th>Ngày gửi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ret = mysqli_query($con, "SELECT * FROM tblcontact ORDER BY PostingDate DESC");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($ret)) {
                                            echo "<tr>
                                                <td>{$cnt}</td>
                                                <td>{$row['Name']}</td>
                                                <td>{$row['Email']}</td>
                                                <td>{$row['Message']}</td>
                                                <td>{$row['PostingDate']}</td>
                                            </tr>";
                                            $cnt++;
                                        }
                                        if ($cnt == 1) {
                                            echo '<tr><td colspan="5" class="text-center">Chưa có liên hệ nào</td></tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <a href="dashboard.php" class="btn btn-sm btn-secondary mt-2">← Quay lại bảng điều khiển</a>
                </div>
            </div>
        </div>

        <?php include_once('includes/footer.php'); ?>
    </div>
</div>

<!-- JS -->
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/inspinia.js"></script>

</body>
</html>
