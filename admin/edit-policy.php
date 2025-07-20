<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (!isset($_SESSION['fosaid']) || strlen($_SESSION['fosaid']) == 0) {
    header('location:logout.php');
    exit();
}

if (!isset($_GET['editid'])) {
    echo "<script>alert('Không tìm thấy chính sách'); window.location='manage-policy.php';</script>";
    exit();
}

$policyId = intval($_GET['editid']);
$ret = mysqli_query($con, "SELECT * FROM tblpolicy WHERE id='$policyId'");
$row = mysqli_fetch_array($ret);

if (!$row) {
    echo "<script>alert('Không tồn tại chính sách này'); window.location='manage-policy.php';</script>";
    exit();
}

if (isset($_POST['update_policy'])) {
    $title = $_POST['pagetitle'];
    $slug = $_POST['pageslug'];
    $desc = $_POST['pagedes'];

    $query = mysqli_query($con, "UPDATE tblpolicy SET title='$title', slug='$slug', content='$desc' WHERE id='$policyId'");
    if ($query) {
        echo "<script>alert('Cập nhật thành công'); window.location='manage-policy.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi cập nhật');</script>";
    }
}

// Chuẩn bị dữ liệu hiển thị
$old_title = isset($_POST['pagetitle']) ? $_POST['pagetitle'] : $row['title'];
$old_slug = isset($_POST['pageslug']) ? $_POST['pageslug'] : $row['slug'];
$old_desc = isset($_POST['pagedes']) ? $_POST['pagedes'] : $row['content'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chỉnh sửa chính sách</title>
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
                <div class="col-lg-8 offset-lg-2">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Chỉnh sửa chính sách</h5>
                        </div>
                        <div class="ibox-content">
<form method="post">
    <div class="form-group">
        <label>Tiêu đề</label>
        <input type="text" name="pagetitle" class="form-control"
            value="<?php echo htmlspecialchars($old_title); ?>" required>
    </div>

    <div class="form-group">
        <label>Slug</label>
        <input type="text" name="pageslug" class="form-control"
            value="<?php echo htmlspecialchars($old_slug); ?>" required>
        <small class="form-text text-muted">Chỉ dùng chữ thường không dấu, gạch ngang (-), không khoảng trắng.</small>
    </div>

    <div class="form-group">
        <label>Nội dung</label>
        <textarea name="pagedes" class="form-control" rows="8" required><?php echo htmlspecialchars($old_desc); ?></textarea>
    </div>

    <button type="submit" name="update_policy" class="btn btn-success">Cập nhật</button>
    <a href="manage-policy.php" class="btn btn-secondary">Quay lại</a>
</form>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include_once('includes/footer.php'); ?>
    </div>
</div>

<!-- JS -->
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/inspinia.js"></script>

<script>
    $(document).ready(function () {
        $('#side-menu').metisMenu();
    });
</script>

</body>
</html>
