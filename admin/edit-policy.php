<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['fosaid']) == 0) {
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chỉnh sửa chính sách</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <div class="container" style="max-width: 800px; margin-top: 50px;">
        <h2>Chỉnh sửa chính sách</h2>
        <form method="post">
            <div class="form-group">
                <label>Tiêu đề</label>
                <input type="text" name="pagetitle" class="form-control" value="<?php echo htmlspecialchars($row['title']); ?>" required>
            </div>
            <div class="form-group">
                <label>Slug</label>
                <input type="text" name="pageslug" class="form-control" value="<?php echo htmlspecialchars($row['slug']); ?>" required>
            </div>
            <div class="form-group">
                <label>Nội dung</label>
                <textarea name="pagedes" class="form-control" rows="8" required><?php echo htmlspecialchars($row['content']); ?></textarea>
            </div>
            <button type="submit" name="update_policy" class="btn btn-success">Cập nhật</button>
            <a href="manage-policy.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</body>
</html>
