<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['fosaid']) == 0) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $slug = mysqli_real_escape_string($con, $_POST['slug']);
    $content = mysqli_real_escape_string($con, $_POST['content']);

    $query = mysqli_query($con, "INSERT INTO tblpolicy (title, slug, content) VALUES ('$title', '$slug', '$content')");
    if ($query) {
      echo "<script>alert('Thêm chính sách mới thành công');</script>";
      echo "<script>window.location.href='manage-policy.php'</script>";
    } else {
      echo "<script>alert('Có lỗi xảy ra. Vui lòng thử lại');</script>";
    }
  }
?>
<!DOCTYPE html>
<html>

<head>
  <title>Thêm chính sách mới</title>
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
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="ibox">
              <div class="ibox-title">
                <h5>Thêm chính sách mới</h5>
              </div>
              <div class="ibox-content">
                <form method="post">
                  <div class="form-group">
                    <label for="title">Tiêu đề</label>
                    <input type="text" name="title" class="form-control" required placeholder="Nhập tiêu đề chính sách">
                  </div>

                  <div class="form-group">
                    <label for="slug">Slug <small class="text-muted">(viết không dấu, cách nhau bằng dấu gạch ngang)</small></label>
                    <input type="text" name="slug" class="form-control" required placeholder="vd: chinh-sach-doi-tra">
                    <small class="form-text text-muted">Ví dụ: "chinh-sach-doi-tra", "hoan-tien-trong-7-ngay"</small>
                  </div>

                  <div class="form-group">
                    <label for="content">Nội dung</label>
                    <textarea name="content" rows="8" class="form-control" required placeholder="Nhập nội dung chính sách tại đây..."></textarea>
                  </div>

                  <button type="submit" name="submit" class="btn btn-primary">Thêm</button>
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
  <script src="js/bootstrap.js"></script>
  <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
  <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
  <script src="js/inspinia.js"></script>
  <script>
    $(document).ready(function () {
      $('#side-menu').metisMenu();
    });

    // Tự động tạo slug từ tiêu đề
    document.querySelector('input[name="title"]').addEventListener('input', function () {
      const title = this.value;
      const slug = title.toLowerCase()
        .normalize('NFD')                     // chuyển có dấu -> không dấu
        .replace(/[\u0300-\u036f]/g, '')      // xóa ký tự dấu
        .replace(/[^a-z0-9\s-]/g, '')         // chỉ cho chữ thường, số, dấu cách
        .trim()
        .replace(/\s+/g, '-');                // thay dấu cách bằng dấu gạch ngang
      document.querySelector('input[name="slug"]').value = slug;
    });
  </script>
</body>

</html>
<?php } ?>
