<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['login'])) {
    $emailcon = $_POST['emailcont'];
    $password = $_POST['password'];

    // 1. Kiểm tra trong bảng admin
    $adminQuery = mysqli_query($con, "SELECT ID FROM tbladmin WHERE (Email='$emailcon' || MobileNumber='$emailcon') AND Password='$password'");
    $admin = mysqli_fetch_array($adminQuery);

    if ($admin) {
        $_SESSION['fosaid'] = $admin['ID']; // Lưu session admin
        header('location:admin/dashboard.php');
        exit();
    }

    // 2. Nếu không phải admin, kiểm tra user
    $userQuery = mysqli_query($con, "SELECT ID FROM tbluser WHERE (Email='$emailcon' || MobileNumber='$emailcon') AND Password='$password'");
    $user = mysqli_fetch_array($userQuery);

    if ($user) {
        $_SESSION['fosuid'] = $user['ID']; // Lưu session user
        header('location:index.php');
        exit();
    } else {
        $msg = "Thông tin đăng nhập không hợp lệ.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
        <title>Hệ thống bánh ngọt|| Đăng nhập</title>

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
   
    </head>
    <body>
        
        <!--================Main Header Area =================-->
		<?php include_once('includes/header.php');?>
        <!--================End Main Header Area =================-->
        
        <!--================End Main Header Area =================-->
        <section class="banner_area">
        	<div class="container">
        		<div class="banner_text">
        			<h3>Đăng nhập</h3>
        			<ul>
        				<li><a href="index.php">Trang chủ</a></li>
        				<li><a href="login.php">Đăng nhập</a></li>
        			</ul>
        		</div>
        	</div>
        </section>
        <!--================End Main Header Area =================-->
        
        <!--================Contact Form Area =================-->
        <section class="contact_form_area p_100">
        	<div class="container">
        		<div class="main_title">
					<h2>Đăng nhập!!</h2>
					<h5>Điền đầy đủ thông tin bên dưới .</h5>
				</div>
       			<div class="row">
       				<div class="col-lg-7">
          <?php
        if (isset($_GET['success']) && $_GET['success'] == '1') {
            echo '<p style="color: green; font-weight: bold; text-align: center;">Đăng ký thành công! Vui lòng đăng nhập để tiếp tục.</p>';
        }
        if (isset($msg)) {
            echo '<p style="color: red; text-align: center;">' . $msg . '</p>';
        }
        ?>
       					<form class="row contact_us_form"action="" name="login" method="post">
							<div class="form-group col-md-12">
								<input type="text" class="form-control" name="emailcont" required="true" placeholder="Email" required="true">
							</div>
             <!-- <h6 style="padding-left: 20px"><a href="forgot-password.php">Quên mật khẩu?</a></h6> -->
              <div class="form-group col-md-12" style="padding-top: 20px;">
                <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required="true">
              </div>
              
              <div class="form-group col-md-12 d-flex justify-content-between align-items-center">
              <!-- Nút Đăng nhập -->
              <button type="submit" value="submit" name="login" class="btn order_s_btn" style="width:48%;">Đăng nhập</button>

              <!-- Nút Đăng ký -->
              <a href="registration.php" class="btn order_s_btn" style="width:48%;">
                <i class="ft-user"></i> Đăng ký
              </a>
            </div>

            <!-- Thông điệp -->
            <div class="form-group col-md-12 text-center">
              <strong>Đăng ký nếu bạn chưa có tài khoản!!!!</strong>
            </div>

						</form>
            
       				</div>
       				<div class="col-lg-4 offset-md-1">
       					<div class="contact_details">
       						<?php

$ret=mysqli_query($con,"select * from tblpage where PageType='contactus' ");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>
       						<!-- <div class="contact_d_item">
       							<h3>Địa chỉ :</h3>
       							<p><?php  echo $row['PageDescription'];?></p>
       						</div>
       						<div class="contact_d_item">
       							<h5>Số điện thoại: <?php  echo $row['MobileNumber'];?></h5>
       							<h5>Email : <?php  echo $row['Email'];?></h5>
       						</div> -->
       						
       					</div>
       				</div><?php } ?>
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
        <script>
  if (window.location.search.includes("success=1")) {
    // Sau 3 giây, xóa ?success=1 khỏi URL
    setTimeout(() => {
      const url = new URL(window.location);
      url.searchParams.delete("success");
      window.history.replaceState({}, document.title, url.toString());
    }, 3000);
  }
</script>

        <script src="js/theme.js"></script>
    </body>

</html>