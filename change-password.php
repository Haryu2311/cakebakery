<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['fosuid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $userid = $_SESSION['fosuid'];
    $cpassword = ($_POST['currentpassword']);
    $newpassword = ($_POST['newpassword']);
    $query = mysqli_query($con, "select ID from tbluser where ID='$userid' and Password='$cpassword'");
    $row = mysqli_fetch_array($query);
    if ($row > 0) {
      $ret = mysqli_query($con, "update tbluser set Password='$newpassword' where ID='$userid'");
      $msg = "Thay đổi mật khẩu thành công";
    } else {
      $msg = "Mật khẩu hiện tại của bạn không đúng.";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Hệ thống bánh ngọt|| Thay đổi mật khẩu</title>
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="vendors/linearicons/style.css" rel="stylesheet">
  <link href="vendors/flat-icon/flaticon.css" rel="stylesheet">
  <link href="vendors/stroke-icon/style.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="vendors/revolution/css/settings.css" rel="stylesheet">
  <link href="vendors/revolution/css/layers.css" rel="stylesheet">
  <link href="vendors/revolution/css/navigation.css" rel="stylesheet">
  <link href="vendors/animate-css/animate.css" rel="stylesheet">
  <link href="vendors/owl-carousel/owl.carousel.min.css" rel="stylesheet">
  <link href="vendors/magnifc-popup/magnific-popup.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <link href="css/responsive.css" rel="stylesheet">

  <script type="text/javascript">
    function checkpass() {
      if (document.changepassword.newpassword.value != document.changepassword.confirmpassword.value) {
        alert('Mật khẩu mới và xác nhận mật khẩu không khớp nhau.');
        document.changepassword.confirmpassword.focus();
        return false;
      }
      return true;
    }
  </script>
</head>
<body>
  <?php include_once('includes/header.php');?>

  <section class="banner_area">
    <div class="container">
      <div class="banner_text">
        <h3>Thay đổi mật khẩu</h3>
        <ul>
          <li><a href="index.php">Trang chủ</a></li>
          <li><a href="change-password.php">Thay đổi mật khẩu</a></li>
        </ul>
      </div>
    </div>
  </section>

  <section class="contact_form_area p_100">
    <div class="container">
      <div class="main_title text-center">
        <h2>Thay đổi mật khẩu</h2>
        <h5>Thay đổi mật khẩu của bạn!!!</h5>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <p style="font-size:16px; color:red; text-align:center;">
            <?php if ($msg) { echo $msg; } ?>
          </p>
          <form class="contact_us_form" action="" method="post" name="changepassword" onsubmit="return checkpass();">
            <div class="form-group">
              <label style="color: royalblue;">Mật khẩu hiện tại</label>
              <input type="password" class="form-control" name="currentpassword" required>
            </div>
            <div class="form-group">
              <label style="color: royalblue;">Mật khẩu mới</label>
              <input type="password" class="form-control" name="newpassword" required>
            </div>
            <div class="form-group">
              <label style="color: royalblue;">Xác nhận mật khẩu</label>
              <input type="password" class="form-control" name="confirmpassword" required>
            </div>
            <div class="form-group text-center">
              <button type="submit" name="submit" class="btn order_s_btn">Xác nhận</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Thông tin liên hệ nếu có -->
      <div class="row justify-content-center mt-5">
        <div class="col-lg-8">
          <?php
          $ret = mysqli_query($con, "select * from tblpage where PageType='contactus'");
          while ($row = mysqli_fetch_array($ret)) {
            // Hiển thị nội dung nếu cần
          }
          ?>
        </div>
      </div>
    </div>
  </section>

  <?php include_once('includes/footer.php');?>

  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="vendors/revolution/js/jquery.themepunch.tools.min.js"></script>
  <script src="vendors/revolution/js/jquery.themepunch.revolution.min.js"></script>
  <script src="vendors/revolution/js/extensions/revolution.extension.actions.min.js"></script>
  <script src="vendors/revolution/js/extensions/revolution.extension.video.min.js"></script>
  <script src="vendors/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
  <script src="vendors/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
  <script src="vendors/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
  <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
  <script src="vendors/magnifc-popup/jquery.magnific-popup.min.js"></script>
  <script src="vendors/datetime-picker/js/moment.min.js"></script>
  <script src="vendors/datetime-picker/js/bootstrap-datetimepicker.min.js"></script>
  <script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
  <script src="vendors/jquery-ui/jquery-ui.min.js"></script>
  <script src="vendors/lightbox/simpleLightbox.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
  <script src="js/gmaps.min.js"></script>
  <script src="js/map-active.js"></script>
  <script src="js/jquery.form.js"></script>
  <script src="js/jquery.validate.min.js"></script>
  <script src="js/contact.js"></script>
  <script src="js/theme.js"></script>
</body>
</html>

<?php } ?>
