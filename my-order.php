<?php
session_start();
error_reporting(0);
include_once('includes/dbconnection.php');
if (strlen($_SESSION['fosuid']==0)) {
  header('location:logout.php');
  } else{ 


 

    ?>
<!DOCTYPE html>
<html lang="en">
    
<head>
        
        <title>Hệ thống bánh ngọt|| Đơn hàng của tôi</title>

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
            <script language="javascript" type="text/javascript">
var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
 if(popUpWin)
{
if(!popUpWin.closed) popUpWin.close();
}
popUpWin = open(URLStr,'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+600+',height='+600+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
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
        			<h3>Đơn hàng của tôi</h3>
        			<ul>
        				<li><a href="index.php">Trang chủ</a></li>
        				<li><a href="my-order.php">Đơn hàng của tôi</a></li>
        			</ul>
        		</div>
        	</div>
        </section>
        <!--================End Main Header Area =================-->
        
        <!--================Cart Table Area =================-->
        <section class="cart_table_area p_100">
        	<div class="container">
				<div class="table-responsive">
                    <h4 style="color: palevioletred;text-align: center;">Chi tiết đơn hàng của bạn</h4>

					<table class="table" style="padding-top: 20px;">
						<thead>
							<tr>
                                <th>#</th>
                                <th>Mã đơn hàng</th>
								<th>Ngày và giờ đặt hàng</th>
								<th>Trạng thái đơn hàng</th>
								<th>Theo dõi đơn hàng</th>
								<th>Xem chi tiết</th>
								
						</thead>
						<tbody>
							
								<?php 

      
                    $userid= $_SESSION['fosuid'];
$query = mysqli_query($con, "
    SELECT * FROM tblorderaddresses 
    WHERE UserId='$userid' AND (OrderFinalStatus IS NULL OR OrderFinalStatus != 'Order Cancelled')");


$cnt=1;
              while($row=mysqli_fetch_array($query))
              { ?>
               <tr>
    <td><?php echo $cnt;?></td>
<td><?php echo $row['Ordernumber'];?></td>
<td><p><?php echo $row['OrderTime']?></p></td>  
<td><?php $status=$row['OrderFinalStatus'];
if($status==''){
 echo "Waiting for confirmation";   
} else{
echo $status;
}

                                                    ?>  </td>   
<td><li class="list-inline-item"><i class="fa fa-motorcycle"></i> 
<?php    

$link = "http"; 
$link .= "://"; 
$link .= $_SERVER['HTTP_HOST']; 
?>
 <a href="javascript:void(0);" onClick="popUpWindow('trackorder.php?oid=<?php echo htmlentities($row['Ordernumber']);?>');" title="Track order">Theo dõi đơn hàng</a></li></td>
<td><a href="order-detail.php?orderid=<?php echo $row['Ordernumber'];?>" class="btn theme-btn-dash">Xem chi tiết</a></td>       
</tr><?php $cnt=$cnt+1; } ?>
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