<?php
session_start();
include_once('includes/dbconnection.php');
$isLoyal = false;
if (isset($_SESSION['fosuid'])) {
    $uid = $_SESSION['fosuid'];
    $rs = mysqli_query($con, "SELECT IsLoyalCustomer FROM tbluser WHERE ID = '$uid'");
    $user = mysqli_fetch_assoc($rs);
    if ($user && $user['IsLoyalCustomer'] == 1) {
        $isLoyal = true;
    }
}

if (isset($_POST['submit']) && isset($_POST['foodid'])) {
    $userid = $_SESSION['fosuid'];
    $foodid = intval($_POST['foodid']);

    // Lấy số lượng bánh gốc từ tblfood
    $foodDataQuery = mysqli_query($con, "SELECT ItemQty FROM tblfood WHERE ID = '$foodid'");
    $foodData = mysqli_fetch_assoc($foodDataQuery);
    $foodQty = intval($foodData['ItemQty']); // số lượng bánh được giao theo quy định

    // Kiểm tra xem món ăn đã có trong giỏ hàng chưa (chưa đặt hàng)
    $check = mysqli_query($con, "SELECT ID, ItemQty FROM tblorders WHERE UserId = '$userid' AND FoodId = '$foodid' AND IsOrderPlaced IS NULL");

    if (mysqli_num_rows($check) > 0) {
        $row = mysqli_fetch_assoc($check);
        $newQty = $row['ItemQty'] + 1;
        $orderId = $row['ID'];

        // Cập nhật lại ItemQty và FoodQty
        mysqli_query($con, "UPDATE tblorders SET ItemQty = '$newQty', FoodQty = '$foodQty' WHERE ID = '$orderId'");
    } else {
        // Chưa có trong giỏ, thêm mới
        mysqli_query($con, "INSERT INTO tblorders(UserId, FoodId, ItemQty, FoodQty, IsOrderPlaced) VALUES('$userid', '$foodid', 1, '$foodQty', NULL)");
    }

    echo "<script>alert('Đã thêm vào giỏ hàng!'); window.location='cart.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
        <title>Hệ thống bánh ngọt || Tìm bánh</title>

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
        			<h3>Tìm bánh</h3>
        			<ul>
        				<li><a href="index.php">Trang chủ</a></li>
        				<li><a href="search-cake.php">Tìm bánh</a></li>
        			</ul>
        		</div>
        	</div>
        </section>
        <!--================End Main Header Area =================-->
        
        <!--================Blog Main Area =================-->
        <section class="our_cakes_area p_100">
        	<div class="container">
        		<div class="main_title">
        			<h2>Tìm bánh</h2>
                    <form method="post">
     <div class="form-group col-md-12" style="padding-top: 20px;">
                <input type="text" class="form-control" id="searchkey" name="searchkey" placeholder="Search Cake by name" required="true">
              </div>
              
                            <div class="form-group col-md-12">
                                <button type="submit" value="Search" name="search" class="btn order_s_btn form-control">Tìm</button>
                            </div>
                            </form>
        		</div>

<?php if(isset($_POST['search'])){
    $searchkey=$_POST['searchkey'];
    ?>
    <h3 align="center">Kết quả tìm kiếm theo từ khóa "<?php echo $searchkey; ?>"</h3>
    <hr />
<div class="cake_feature_row row">				
<?php

$ret=mysqli_query($con,"select * from tblfood  where ItemName like '%$searchkey%'");
$num=mysqli_num_rows($ret);
if($num>0){
while ($row=mysqli_fetch_array($ret)) {

?>

					<div class="col-lg-3 col-md-4 col-6">
						<div class="cake_feature_item">
							 <div class="cake_img">
                                <a href="cake-detail.php?fid=<?php echo $row['ID']; ?>">
                                    <img src="admin/itemimages/<?php echo $row['Image'];?>" width="200" height="200">
                                </a>
                            </div>
							<div class="cake_text">
								                                    <?php
$price = $row['ItemPrice'];
if ($isLoyal) {
    $discountPrice = $price * 0.9; // giảm 10%
echo "<h3><del>" . number_format($price, 0, ',', '.') . " VNĐ</del><br><span style='color:red;'>" . number_format($discountPrice, 0, ',', '.') . " VNĐ</span></h3>";
} else {
    echo "<h3>" . number_format($price, 0, ',', '.') . " VNĐ</h3>";
}
?>
								<h3><a href="cake-detail.php?fid=<?php echo $row['ID'];?>"><?php echo $row['ItemName'];?></a></h3>
<?php if (!isset($_SESSION['fosuid']) || $_SESSION['fosuid'] == "") { ?>
       								<a href="login.php" class="pest_btn">Thêm vào giỏ hàng</a>
<?php } else {?>
    <form method="post"> 
    <input type="hidden" name="foodid" value="<?php echo $row['ID'];?>">   
<button type="submit" name="submit" class="pest_btn">Thêm vào giỏ hàng</button>
  </form> 
<?php }?>
							</div>
						</div>
					</div><?php } } else {?>
<div class="col-lg-12 col-md-4 col-6" align="center" style="font-size:26px; color:red;">
Không tìm thấy hồ sơ
</div>
                    <?php } ?>
				</div>
            <?php } ?>
          
        	</div>
        </section>
        <!--================End Blog Main Area =================-->
        
      
        
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
        
        <script src="js/theme.js"></script>
    </body>

</html>