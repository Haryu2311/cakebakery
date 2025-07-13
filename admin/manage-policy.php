<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['fosaid']) == 0) {
  header('location:logout.php');
} else {
  // Xóa chính sách
  if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    $query = mysqli_query($con, "DELETE FROM tblpolicy WHERE id='$id'");
    if ($query) {
      echo "<script>alert('Chính sách đã được xóa');</script>";
      echo "<script>window.location.href='manage-policy.php'</script>";
    } else {
      echo "<script>alert('Thất bại. Vui lòng thử lại.');</script>";
    }
  }
?>
<!DOCTYPE html>
<html>

<head>
  <title>Quản trị | Quản lý chính sách</title>
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
            <div class="ibox">
              <div class="ibox-content">
                <p style="text-align: center; color: blue; font-size: 30px">Quản lý chính sách</p>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>STT</th>
                      <th>Tiêu đề</th>
                      <th>Slug</th>
                      <th>Nội dung</th>
                      <th>Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $ret = mysqli_query($con, "SELECT * FROM tblpolicy ORDER BY id ASC");
                    $cnt = 1;
                    while ($row = mysqli_fetch_array($ret)) {
                    ?>
                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['slug']); ?></td>
                        <td><?php echo mb_strimwidth(strip_tags($row['content']), 0, 50, '...'); ?></td>
                        <td>
                          <a href="edit-policy.php?editid=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                          <a href="manage-policy.php?del=<?php echo $row['id']; ?>" onclick="return confirm('Bạn chắc chắn muốn xóa?')" class="btn btn-danger btn-sm">Xóa</a>
                        </td>
                      </tr>
                    <?php $cnt++; } ?>
                  </tbody>
                </table>
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
  <script src="js/bootstrap.js"></script>
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
<?php } ?>
