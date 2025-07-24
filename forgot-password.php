<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
    $contactno = $_POST['contactno'];
    $email = $_POST['email'];
    $password = $_POST['newpassword'];

    $query = mysqli_query($con, "SELECT ID FROM tbluser WHERE Email='$email' AND MobileNumber='$contactno'");
    $ret = mysqli_num_rows($query);

    if ($ret > 0) {
        $_SESSION['contactno'] = $contactno;
        $_SESSION['email'] = $email;
        $query1 = mysqli_query($con, "UPDATE tbluser SET Password='$password' WHERE Email='$email' AND MobileNumber='$contactno'");

        if ($query1) {
echo "<script>alert('Thay đổi mật khẩu thành công!'); window.location.href='login.php';</script>";

        } else {
            echo "<script>alert('Cập nhật mật khẩu thất bại.');</script>";
        }
    } else {
        echo "<script>alert('Thông tin không hợp lệ. Vui lòng thử lại.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    
<head>
        <title>Hệ thống bánh ngọt|| Quên mật khẩu</title>

        <!-- Icon css link -->
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="vendors/linearicons/style.css" rel="stylesheet">
        <link href="vendors/flat-icon/flaticon.css" rel="stylesheet">
        <link href="vendors/stroke-icon/style.css" rel="stylesheet">
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Rev slider css -->
        <link href="vendors/revolution/css/settings.css" rel="stylesheet">
        <link href="vendors/revolution/css/layers.css" rel="stylesheet">
        <link href="vendors/revolution/css/navigation.css" rel="stylesheet">
        <link href="vendors/animate-css/animate.css" rel="stylesheet">
        
        <!-- Extra plugin css -->
        <link href="vendors/owl-carousel/owl.carousel.min.css" rel="stylesheet">
        <link href="vendors/magnifc-popup/magnific-popup.css" rel="stylesheet">
        
        <link href="css/style.css" rel="stylesheet">
        <link href="css/responsive.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
   <script type="text/javascript">
function checkpass()
{
if(document.changepassword.newpassword.value!=document.changepassword.confirmpassword.value)
{
alert('Trường Mật khẩu mới và Xác nhận mật khẩu không khớp');
document.changepassword.confirmpassword.focus();
return false;
}
return true;
} 

</script>
    </head>
    <body>
        
        <!--================Main Header Area =================-->
		<?php include_once('includes/header.php');?>
        <!--================End Main Header Area =================-->
        
        <!--================End Main Header Area =================-->
        <section class="banner_area">
        	<div class="container">
        		<div class="banner_text">
        			<h3>Đặt lại mật khẩu</h3>
        			<ul>
        				<li><a href="index.php">Trang chủ</a></li>
        				<li><a href="forgot-password.php">Quên mật khẩu</a></li>
        			</ul>
        		</div>
        	</div>
        </section>
        <!--================End Main Header Area =================-->
        
        <!--================Contact Form Area =================-->
        <section class="contact_form_area p_100">
  <div class="container">
    <div class="main_title text-center">
      <h2>Quên mật khẩu!!</h2>
      <h5>Vui lòng nhập email và số điện thoại khớp với tài khoản đã đăng nhập!</h5>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <form class="contact_us_form" action="" method="post" name="changepassword" onsubmit="return checkpass();">
          <div class="form-group mb-3">
            <input type="text" class="form-control" name="email" placeholder="Nhập email của bạn" required>
          </div>
          <div class="form-group mb-3">
            <input type="text" class="form-control" name="contactno" placeholder="Số liên lạc" required pattern="[0-9]+">
          </div>
          <div class="form-group mb-3">
            <input type="password" class="form-control" id="userpassword" name="newpassword" placeholder="Mật khẩu mới" required>
          </div>
          <div class="form-group mb-4">
            <input type="password" class="form-control" name="confirmpassword" placeholder="Xác nhận mật khẩu" required>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-4 mb-2">
                <a href="registration.php" class="btn order_s_btn w-100 text-center">
                  <i class="ft-user"></i> Đăng ký
                </a>
              </div>
              <div class="col-4 mb-2">
                <a href="login.php" class="btn order_s_btn w-100 text-center">
                  <i class="ft-user"></i> Đăng nhập
                </a>
              </div>
              <div class="col-4 mb-2">
                <button type="submit" name="submit" class="btn order_s_btn w-100">
                  Cài lại
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

        <!--================End Contact Form Area =================-->
        
        
       
       <?php include_once('includes/footer.php');?>
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery-3.2.1.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- Rev slider js -->
        <script src="vendors/revolution/js/jquery.themepunch.tools.min.js"></script>
        <script src="vendors/revolution/js/jquery.themepunch.revolution.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.actions.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.video.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
        <!-- Extra plugin js -->
        <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
        <script src="vendors/magnifc-popup/jquery.magnific-popup.min.js"></script>
        <script src="vendors/datetime-picker/js/moment.min.js"></script>
        <script src="vendors/datetime-picker/js/bootstrap-datetimepicker.min.js"></script>
        <script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
        <script src="vendors/jquery-ui/jquery-ui.min.js"></script>
        <script src="vendors/lightbox/simpleLightbox.min.js"></script>
        <!--gmaps Js-->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
        <script src="js/gmaps.min.js"></script>
        <script src="js/map-active.js"></script>
        
        <!-- contact js -->
        <script src="js/jquery.form.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/contact.js"></script>
        
        <script src="js/theme.js"></script>
    </body>

</html>