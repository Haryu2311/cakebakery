<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);
include_once('includes/dbconnection.php');
$userid = $_SESSION['fosuid'];
$isLoyal = false;
$checkLoyal = mysqli_query($con, "SELECT IsLoyalCustomer FROM tbluser WHERE ID = '$userid'");
if ($checkLoyal && mysqli_num_rows($checkLoyal) > 0) {
    $data = mysqli_fetch_assoc($checkLoyal);
    if ($data['IsLoyalCustomer'] == 1) {
        $isLoyal = true;
    }
}

if (strlen($_SESSION['fosuid']==0)) {
  header('location:logout.php');
  } else{ 
// Code for deleting product from cart
if(isset($_GET['delid']))
{
$rid=intval($_GET['delid']);
$query=mysqli_query($con,"delete from tblorders where ID='$rid'");
 echo "<script>alert('Dữ liệu đã được xóa!');</script>"; 
  echo "<script>window.location.href = 'cart.php'</script>";     


}

//placing order

if(isset($_POST['placeorder'])){
//getting address
$fnaobno=$_POST['flatbldgnumber'];
$street=$_POST['streename'];
$area=$_POST['area'];
$lndmark=$_POST['landmark'];
$city=$_POST['city'];
$userid=$_SESSION['fosuid'];
//genrating order number
$orderno= mt_rand(100000000, 999999999);
$query="update tblorders set OrderNumber='$orderno',IsOrderPlaced='1' where UserId='$userid' and IsOrderPlaced is null;";
$query.="insert into tblorderaddresses(UserId,Ordernumber,Flatnobuldngno,StreetName,Area,Landmark,City) values('$userid','$orderno','$fnaobno','$street','$area','$lndmark','$city');";

$result = mysqli_multi_query($con, $query);
if ($result) {

echo '<script>alert("Đơn hàng của bạn đã được đặt thành công. Mã đơn hàng là "+"'.$orderno.'")</script>';
echo "<script>window.location.href='my-order.php'</script>";

}
}    

    ?>
<!DOCTYPE html>
<html lang="en">
    
<head>
        
        <title>Hệ thống làm bánh ngọt|| Trang giỏ hàng</title>

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
        			<h3>Giỏ hàng</h3>
        			<ul>
        				<li><a href="index.php">Trang chủ</a></li>
        				<li><a href="cart.php">Giỏ hàng</a></li>
        			</ul>
        		</div>
        	</div>
        </section>
        <!--================End Main Header Area =================-->
        
        <!--================Cart Table Area =================-->
        <section class="cart_table_area p_100">
        	<div class="container">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Ảnh</th>
								<th scope="col">Tên sản phẩm</th>
                                <th scope="col">Số bánh</th>
								<th scope="col">Giá</th>
								<th scope="col">Khối lượng</th>
								<th scope="col">Số lượng</th>
								<th scope="col">Tổng</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?php 
$userid= $_SESSION['fosuid'];
$query=mysqli_query($con,"select tblfood.Image,tblfood.ItemName,tblorders.FoodQty,tblfood.ItemDes,tblfood.Weight,tblfood.ItemPrice,tblorders.ItemQty,tblorders.FoodId,tblorders.ID from tblorders join tblfood on tblfood.ID=tblorders.FoodId where tblorders.UserId='$userid' and tblorders.IsOrderPlaced is null");
$num=mysqli_num_rows($query);
if($num>0){
while ($row=mysqli_fetch_array($query)) {
 

?>
								<td>
									<img src="admin/itemimages/<?php echo $row['Image']?>" width="100" height="80" alt="<?php echo $row['ItemName']?>">
								</td>
								<td><?php echo $row['ItemName']?></td>
								<td><?php echo $row['FoodQty'] * $row['ItemQty']; ?> chiếc</td>
<td>
<?php
$price = $row['ItemPrice'];
$qty = $row['ItemQty'];
$total = $price * $qty;

if ($isLoyal) {
    $discountPrice = $price * 0.9;
    $discountTotal = $discountPrice * $qty;
    echo "<del>" . number_format($total, 0, ',', '.') . " VNĐ</del><br>";
    echo "<span style='color:red;'>" . number_format($discountTotal, 0, ',', '.') . " VNĐ</span>";
    $grandtotal += $discountTotal;
} else {
    echo number_format($total, 0, ',', '.') . " VNĐ";
    $grandtotal += $total;
}
?>
</td>

								<td>
    <?php
        // Chuyển weight dạng chuỗi sang số gram
        $weightString = $row['Weight']; // Ví dụ "1.5 kg", "500 gm"
        $weightGrams = 0;

        if (strpos($weightString, 'kg') !== false) {
            $value = floatval(str_replace(' kg', '', $weightString));
            $weightGrams = $value * 1000;
        } elseif (strpos($weightString, 'gm') !== false) {
            $value = floatval(str_replace(' gm', '', $weightString));
            $weightGrams = $value;
        }

        // Tính tổng khối lượng theo số lượng
        $totalGrams = $weightGrams * $row['ItemQty'];

        // Hiển thị khối lượng tổng sau khi nhân số lượng
        if ($totalGrams >= 1000) {
            echo rtrim(rtrim(number_format($totalGrams / 1000, 2, '.', ''), '0'), '.') . " kg";
        } else {
            echo number_format($totalGrams, 0) . " g";
        }
    ?>
</td>

								<form method="post" action="update-cart.php">
									<input type="hidden" name="order_id" value="<?php echo $row['ID']; ?>">
									<td>
										<div style="display: flex; align-items: center;">
											<button type="submit" name="decrease" class="qty-btn">-</button>
											<input type="text" name="quantity" value="<?php echo $row['ItemQty']; ?>" style="width: 40px; text-align: center;" readonly>
											<button type="submit" name="increase" class="qty-btn">+</button>
										</div>
									</td>
								</form>

								<td>
<?php
    if ($isLoyal) {
        echo number_format($discountTotal, 0, ',', '.') . " VNĐ";
    } else {
        echo number_format($total, 0, ',', '.') . " VNĐ";
    }
?>
</td>

								<td><a href="cart.php?delid=<?php echo $row['ID'];?>" onclick="return confirm('Bạn thật sự muốn xóa?');"><i class="fa fa-trash fa-delete" aria-hidden="true"></i></a></td>
							</tr><?php $cnt++; } }?>
							<tr>
								<td>
									
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>
									
								</td>
							</tr>
						</tbody>
					</table>
				</div>
       			<div class="row cart_total_inner">
        			<div class="col-lg-7"></div>
        			<div class="col-lg-5">
        				<div class="cart_total_text">
        					<div class="cart_head">
        						Giỏ hàng tổng
        					</div>
        					<div class="sub_total">
								<h5>Tổng tất cả <span><?php echo number_format($grandtotal, 0, ',', '.'); ?> VNĐ</span></h5>
							</div>
							<div class="total">
								<h4>Tổng <span><?php echo number_format($grandtotal, 0, ',', '.'); ?> VNĐ</span></h4>
							</div>
							<?php if ($num > 0 && $grandtotal > 0) { ?>
        					<div class="cart_footer">								
        						<a class="pest_btn" href="checkout.php">Tiến hành mua</a>
        					</div>
							<?php } else { ?>
								<div class="cart_footer">
									<a class="pest_btn" href="#" onclick="alert('Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm trước khi thanh toán!'); return false;">Tiến hành mua</a>
								</div>
							<?php } ?>
        				</div>
        			</div>
        		</div>
        	</div>
        </section>
        <!--================End Cart Table Area =================-->
        
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
        
        <script src="js/theme.js"></script>
    </body>

</html><?php } ?>