<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');
$msg = "";
if (isset($_POST['submit'])) {
    $fname = mysqli_real_escape_string($con, $_POST['firstname']);
    $lname = mysqli_real_escape_string($con, $_POST['lastname']);
    $contno = mysqli_real_escape_string($con, $_POST['mobilenumber']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $repeatpassword = mysqli_real_escape_string($con, $_POST['repeatpassword']);


    if ($password != $repeatpassword) {
        $msg = "Mật khẩu và mật khẩu nhập lại không khớp.";
    } else {

        $ret = mysqli_query($con, "SELECT Email FROM tbluser WHERE Email='$email' OR MobileNumber='$contno'");
        if (mysqli_fetch_array($ret)) {
            $msg = "Email hoặc số điện thoại đã được đăng ký.";
        } else {

            $query = mysqli_query($con, "INSERT INTO tbluser(FirstName, LastName, MobileNumber, Email, Password) 
                VALUES('$fname', '$lname', '$contno', '$email', '$password')");

            if ($query) {
                $msg = "Đăng ký thành công!";
            } else {
                $msg = "Đã xảy ra lỗi. Vui lòng thử lại.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
        <title>Hệ thống bánh ngọt|| Đăng ký</title>

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
if(document.signup.password.value!=document.signup.repeatpassword.value)
{
alert('Password and Repeat Password field does not match');
document.signup.repeatpassword.focus(); //Đặt con trỏ chuột (focus) vào trường nhập lại mật khẩu để người dùng dễ dàng sửa lại.
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
        			<h3>Đăng ký</h3>
        			<ul>
        				<li><a href="index.php">Trang chủ</a></li>
        				<li><a href="registration.php">Đăng ký</a></li>
        			</ul>
        		</div>
        	</div>
        </section>
        <!--================End Main Header Area =================-->
        
        <!--================Contact Form Area =================-->
        <section class="contact_form_area p_100">
        	<div class="container">
        		<div class="main_title">
					<h2>Đăng ký!!</h2>
					<h5>Điền thông tin bên dưới.</h5>
				</div>
       			<div class="row">
       				<div class="col-lg-7">
                <p style="font-size:16px; color:red" align="center"> <?php if($msg){
    echo $msg;
  }  ?> </p>
       					<form class="row contact_us_form"action="" name="signup" method="post" onsubmit="return checkpass();">
							<div class="form-group col-md-6">
								<input type="text" class="form-control" name="firstname" required="true" placeholder="Tên" required="true">
							</div>
              <div class="form-group col-md-6">
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Họ" required="true">
              </div>
              <div class="form-group col-md-6">
                <input type="text" class="form-control" id="mobilenumber" name="mobilenumber" required="true" maxlength="10" pattern="[0-9]{10}" placeholder="Số điện thoại" required="true">
              </div>
							<div class="form-group col-md-6">
								<input type="email" class="form-control" id="email" name="email" placeholder="Địa chỉ email" required="true">
							</div>
							
              <div class="form-group col-md-6">
                <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required="true">
              </div>
              <div class="form-group col-md-6">
                  <input type="password" class="form-control" name="repeatpassword" required placeholder="Nhập lại mật khẩu">
              </div>
							<div class="form-group col-md-12 d-flex justify-content-between align-items-center">
              <!-- Nút Xác nhận -->
              <button type="submit" value="submit" name="submit" class="btn order_s_btn" style="width:48%;">Xác nhận ngay</button>

              <!-- Nút Đăng nhập -->
              <a href="login.php" class="btn order_s_btn" style="width:48%;">
                  <i class="ft-user"></i> Đăng nhập
              </a>
          </div>

          <!-- Thông báo nhỏ dưới nút -->
          <div class="form-group col-md-12 text-center">
              <strong>Thực hiện đăng nhập nếu đã có tài khoản!!!</strong>
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
       							<h5>Số điện thoại : <?php  echo $row['MobileNumber'];?></h5>
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
        
        <script src="js/theme.js"></script>
    </body>

</html>