<?php
session_start();
include_once('includes/dbconnection.php');
$isLoyal = false;
if (isset($_SESSION['fosuid'])) {
    $userid = isset($_SESSION['fosuid']) ? $_SESSION['fosuid'] : null;

    $checkLoyal = mysqli_query($con, "SELECT IsLoyalCustomer FROM tbluser WHERE ID = '$userid'");
    if ($checkLoyal && mysqli_num_rows($checkLoyal) > 0) {
        $result = mysqli_fetch_assoc($checkLoyal);
        if ($result['IsLoyalCustomer'] == 1) {
            $isLoyal = true;
        }
    }
}

if (isset($_POST['submit']) && isset($_POST['foodid'])) {
    if (!isset($_SESSION['fosuid'])) {
        echo "<script>alert('Vui lòng đăng nhập để thêm vào giỏ hàng.'); window.location='login.php';</script>";
        exit();
    }

    $userid = isset($_SESSION['fosuid']) ? $_SESSION['fosuid'] : null;
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
        <title>Hệ thống bánh ngọt || Chi tiết bánh</title>

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
        <!-- WARNING: Respond.js doesn't work if you view the page via file:
        [if lt IE 9]>
        <script src="https:
        <script src="https:
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
        			<h3>Các loại bánh</h3>
        			<ul>
        				<li><a href="index.php">Trang chủ</a></li>
        				<li><a href="cake.php">Dịch vụ</a></li>
        			</ul>
        		</div>
        	</div>
        </section>
        <!--================End Main Header Area =================-->
        
        <!--================Blog Main Area =================-->
        <section class="our_cakes_area p_100">
        	<div class="container">
        		<div class="main_title">
        			<h2>Các loại bánh</h2>
        		</div>
        		<div class="cake_feature_row row">

					
                <?php

if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
    $page_no = $_GET['page_no']; 
} else {
    $page_no = 1; 
}

$total_records_per_page = 12; 
$offset = ($page_no - 1) * $total_records_per_page; 
$previous_page = $page_no - 1; 
$next_page = $page_no + 1;     
$adjacents = "2"; 


$result_count = mysqli_query($con, "SELECT COUNT(*) AS total_records FROM tblfood");
$total_records = mysqli_fetch_array($result_count); 
$total_records = $total_records['total_records'];   


$total_no_of_pages = ceil($total_records / $total_records_per_page);


$second_last = $total_no_of_pages - 1;


$ret = mysqli_query($con, "SELECT * FROM tblfood LIMIT $offset, $total_records_per_page");

$cnt = 1; 

while ($row = mysqli_fetch_array($ret)) {
    
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
echo "<h4><del>" . number_format($price, 0, ',', '.') . " VNĐ</del><br><span style='color:red;'>" . number_format($discountPrice, 0, ',', '.') . " VNĐ</span></h4>";
} else {
    echo "<h4>" . number_format($price, 0, ',', '.') . " VNĐ</h4>";
}
?>

								<h3><a href="cake-detail.php?fid=<?php echo $row['ID'];?>"><?php echo $row['ItemName'];?></a></h3>
								<?php if(!isset($_SESSION['fosuid']) || $_SESSION['fosuid']==""){?>
       								<a href="login.php" class="pest_btn">Thêm vào giỏ</a>
<?php } else {?>
    <form method="post"> 
    <input type="hidden" name="foodid" value="<?php echo $row['ID'];?>">   
<button type="submit" name="submit" class="pest_btn">Thêm vào giỏ</button>
  </form> 
<?php }?>
							</div>
						</div>
					</div><?php }?>
					
				
				</div>
            <ul class="pagination" style="padding-left: 20px;">
    
    <li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
    <a <?php if($page_no > 1){ echo "href='?page_no=$previous_page'"; } ?>>Phía Trước</a>
    </li>
       
    <?php 

if ($total_no_of_pages <= 10){       
    for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
        
        if ($counter == $page_no) {
            echo "<li class='active'><a>$counter</a></li>";  
        } else {
            
            echo "<li><a href='?page_no=$counter'>$counter</a></li>";
        }
    }
}

elseif($total_no_of_pages > 10){
    
    
    if($page_no <= 4) {         
        for ($counter = 1; $counter < 8; $counter++){  
            if ($counter == $page_no) {
                echo "<li class='active'><a>$counter</a></li>";  
            } else {
                echo "<li><a href='?page_no=$counter'>$counter</a></li>";
            }
        }
        
        echo "<li><a>...</a></li>";
        echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
        echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
    }

    
    elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {         
        
        echo "<li><a href='?page_no=1'>1</a></li>";
        echo "<li><a href='?page_no=2'>2</a></li>";
        echo "<li><a>...</a></li>"; 

        
        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {         
            if ($counter == $page_no) {
                echo "<li class='active'><a>$counter</a></li>";  
            } else {
                echo "<li><a href='?page_no=$counter'>$counter</a></li>";
            }                  
        }

        
        echo "<li><a>...</a></li>";
        echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
        echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";      
    }

    
    else {
        
        echo "<li><a href='?page_no=1'>1</a></li>";
        echo "<li><a href='?page_no=2'>2</a></li>";
        echo "<li><a>...</a></li>";

        
        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
            if ($counter == $page_no) {
                echo "<li class='active'><a>$counter</a></li>";  
            } else {
                echo "<li><a href='?page_no=$counter'>$counter</a></li>";
            }                   
        }
    }
}
?>

    
    <li <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
    <a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?>>Phía Sau</a>
    </li>
    <?php if($page_no < $total_no_of_pages){
        echo "<li><a href='?page_no=$total_no_of_pages'>Cuối &rsaquo;&rsaquo;</a></li>";
        } ?>
</ul>
        	</div>
        </section>
      
        
      >
        
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
        <script src="vendors/revolutionjs/extensions/revolution.extension.slideanims.min.js"></script>
        <script src="vendors/revolutio/n/js/extensions/revolution.extension.layeranimation.min.js"></script>
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