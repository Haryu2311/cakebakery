<?php
session_start();
error_reporting(0);
include_once('includes/dbconnection.php');
if (strlen($_SESSION['fosuid']==0)) {
  header('location:logout.php');
  } else{ 

//placing order

if(isset($_POST['cod']))
{
  $var=  $_POST['cod'];

if($var==0)
{
   
if(isset($_POST['placeorder'])){
    //getting address

    $fnaobno=$_POST['flatbldgnumber'];
    $street=$_POST['streename'];
    $area=$_POST['area'];
    $lndmark=$_POST['landmark'];
    $city=$_POST['city'];
    $cod=$_POST['cod'];
    $userid=$_SESSION['fosuid'];
//    echo $userd;
    
//     return ;
    $orderno= mt_rand(100000000, 999999999);
    $query="update tblorders set OrderNumber='$orderno',IsOrderPlaced='1',CashonDelivery='$cod' where UserId='$userid' and IsOrderPlaced is null;";
    $query.="insert into tblorderaddresses(UserId,Ordernumber,Flatnobuldngno,StreetName,Area,Landmark,City) values('$userid','$orderno','$fnaobno','$street','$area','$lndmark','$city');";
    
    $result = mysqli_multi_query($con, $query);
    if ($result) {
    
    echo '<script>alert("Bạn đã đặt đơn thành công số đơn hàng là "+"'.$orderno.'")</script>';
    echo "<script>window.location.href='my-order.php'</script>";
    
    }
    }    
}
else
{
    $_SESSION['flatbldgnumber']=$_POST['flatbldgnumber'];
    $_SESSION['streename']=$_POST['streename'];
    $_SESSION['area']=$_POST['area'];
    $_SESSION['landmark']=$_POST['landmark'];
    $_SESSION['city']=$_POST['city'];
    $_SESSION['cod']=$_POST['cod'];
    $_SESSION['orderid'] = substr(rand(0, 99999999), 0, 8);
 header("Location:http://localhost/cakebakerysystem/vnpay.php");

}

}
    ?>
<!DOCTYPE html>
<html lang="en">
    
<head>
        <title>Hệ thống bánh ngọt || Trang thanh toán</title>

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
        <link href="vendors/jquery-ui/jquery-ui.min.css" rel="stylesheet">
        <link href="vendors/nice-select/css/nice-select.css" rel="stylesheet">
        
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
        			<h3>Thanh toán</h3>
        			<ul>
        				<li><a href="index.php">Trang chủ</a></li>
        				<li><a href="checkout.php">Thanh toán</a></li>
        			</ul>
        		</div>
        	</div>
        </section>
        <!--================End Main Header Area =================-->
        
        <!--================Billing Details Area =================-->    
        <section class="billing_details_area p_100">
            <div class="container">

                <div class="row">
                	<div class="col-lg-7">
               	    	<div class="main_title">
               	    		<h2>Chi tiết thanh toán</h2>
               	    	</div>
                		<div class="billing_form_area">
                			<form class="billing_form row" action="" method="post" id="contactForm">
								<div class="form-group col-md-6">
								    <label for="first">Số nhà *</label>
									<input type="text" name="flatbldgnumber"  placeholder="Số nhà" class="form-control" required="true">
								</div>
								<div class="form-group col-md-6">
								    <label for="last">Phường/Xã *</label>
									<input type="text" name="streename" placeholder="Phường/Xã" class="form-control" required="true">
								</div>
								<div class="form-group col-md-12">
								    <label for="company">Quận/Huyện</label>
									<input type="text" name="area"  placeholder="Quận/Huyện" class="form-control" required="true">
								</div>
								<div class="form-group col-md-12">
								    <label for="address">Cụ thể (nếu có)</label>
									<input type="text" name="landmark" placeholder="Cụ thể" class="form-control">
									
								</div>
								<div class="form-group col-md-12">
								    <label for="city">Thành phố *</label>
									<input type="text" name="city" placeholder="Thành phố" class="form-control" equired="true">
								</div>
							
                		</div>
                	</div>
                	<div class="col-lg-5">
                		<div class="order_box_price">
                			<div class="main_title">
    <h2>Đơn hàng của bạn</h2>
</div>
<div class="payment_list">
    <div class="price_single_cost">

        <h5>Sản phẩm <span>Tổng cộng</span></h5>
        <?php 
        $userid = $_SESSION['fosuid'];
        $grandtotal = 0;
        $query = mysqli_query($con, "SELECT tblfood.Image, tblfood.ItemName, tblfood.ItemDes, tblfood.Weight, tblfood.ItemPrice, tblorders.ItemQty, tblorders.FoodId 
            FROM tblorders 
            JOIN tblfood ON tblfood.ID = tblorders.FoodId 
            WHERE tblorders.UserId = '$userid' AND tblorders.IsOrderPlaced IS NULL");

        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_array($query)) {
                $total = $row['ItemPrice'] * $row['ItemQty'];
                $grandtotal += $total;
        ?>
        <h5>
            <?php echo $row['ItemName']; ?> (x<?php echo $row['ItemQty']; ?>)
            <span><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</span>
        </h5>
        <?php 
            } 
        }
        ?>
        <h4>Tổng cộng <span><?php echo number_format($grandtotal, 0, ',', '.'); ?> VNĐ</span></h4>
        <h5>Vận chuyển và xử lý <span class="text_f">Miễn phí vận chuyển</span></h5>
        <h3>Tổng cộng <span><?php echo number_format($grandtotal, 0, ',', '.'); ?> VNĐ</span></h3>

        <?php $_SESSION['money'] = $grandtotal; ?>
    </div>

								<div id="accordion" class="accordion_area">
									<div class="card">
										<div class="card-header" id="headingOne">
											
                                            <h5 class="mb-0">
												<div class="form-group">
                                                    <label><strong>Phương thức thanh toán *</strong></label><br>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="cod" id="vnpay" value="1" checked>
                                                        <label class="form-check-label" for="vnpay">Thanh toán online (VNPAY)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="cod" id="cod" value="0">
                                                        <label class="form-check-label" for="cod">Thanh toán khi nhận hàng (COD)</label>
                                                    </div>
                                                </div>

											</h5>
										</div>
										
									</div>
								</div>
								<button type="submit" value="submit" name="placeorder" class="btn pest_btn">Đặt hàng</button></form>
							</div>
						</div>
                	</div>
                </div>
            </div>
        </section>
        <!-- Modal xác nhận VNPAY -->
<div class="modal fade" id="vnpayConfirmModal" tabindex="-1" role="dialog" aria-labelledby="vnpayConfirmLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Xác nhận thanh toán VNPAY</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Bạn có chắc chắn muốn thanh toán qua VNPAY không? Bạn sẽ được chuyển đến trang thanh toán của VNPAY sau khi xác nhận.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
        <button type="submit" class="btn btn-primary" id="confirmVnpayBtn">Xác nhận</button>
      </div>
    </div>
  </div>
</div>

        <!--================End Billing Details Area =================-->   
        
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
        <script src="vendors/isotope/imagesloaded.pkgd.min.js"></script>
        <script src="vendors/isotope/isotope.pkgd.min.js"></script>
        <script src="vendors/datetime-picker/js/moment.min.js"></script>
        <script src="vendors/datetime-picker/js/bootstrap-datetimepicker.min.js"></script>
        <script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
        <script src="vendors/jquery-ui/jquery-ui.min.js"></script>
        <script src="vendors/lightbox/simpleLightbox.min.js"></script>
<script>
document.querySelector("form#contactForm").addEventListener("submit", function (e) {
    const cod = document.querySelector('input[name="cod"]:checked').value;

    // Nếu là VNPAY (giá trị == 1) thì chặn form lại và hiển thị modal
    if (cod === "1") {
        e.preventDefault(); // Ngăn submit mặc định
        $('#vnpayConfirmModal').modal('show'); // Hiển thị modal xác nhận
    }
});

// Khi bấm nút "Xác nhận" trong modal thì submit form thủ công
document.getElementById("confirmVnpayBtn").addEventListener("click", function () {
    document.getElementById("contactForm").submit();
});
</script>

        <script src="js/theme.js"></script>
    </body>

</html><?php }?>