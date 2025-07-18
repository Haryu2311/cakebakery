<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<header class="main_header_area">
    <div class="top_header_area row m0">
        <div class="container">
            <div class="float-left">
<?php
    $ret=mysqli_query($con,"select * from tblpage where PageType='contactus' ");
    $cnt=1;
    while ($row=mysqli_fetch_array($ret)) {
?>
                <a href="tell:+18004567890"><i class="fa fa-phone" aria-hidden="true"></i> + <?php  echo $row['MobileNumber'];?></a>
                <a href=""><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php  echo $row['Email'];?></a>
            </div><?php } ?>`
                <div class="float-right">
                    <ul class="h_search list_style">
<?php
$userid = isset($_SESSION['fosuid']) ? $_SESSION['fosuid'] : 0;
$ret1=mysqli_query($con,"select * from tblorders where IsOrderPlaced is null && UserId='$userid'");
$num=mysqli_num_rows($ret1);
?>
                    <li><a href="cart.php"><i class="lnr lnr-cart"><strong><?php echo $num;?></strong></i></a></li>
                    <li><a href="search-cake.php"><i class="fa fa-search"></i></a></li>
                    <!-- <li style="color: white;"><a href="admin/index.php">Quản trị </a></li> -->
                    </ul>
                </div>
            </div>
        </div>
            <div class="main_menu_area">
                <div class="container">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="navbar-brand" href="index.php">
                        <img src="img/logo.png" alt="">
                        <img src="img/logo3.png" alt="">
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="my_toggle_menu">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                    <li class="dropdown submenu <?php if ($currentPage == 'index.php') echo 'active'; ?>">
                                    <a class="dropdown-toggle"  href="index.php" role="button" aria-haspopup="true" aria-expanded="false">Trang chủ</a>                                  
                                </li>
                                <li class="<?php if ($currentPage == 'cake.php') echo 'active'; ?>">
                                    <a href="cake.php">Các loại bánh </a>
                                </li>
                                <li class="dropdown submenu <?php if ($currentPage == 'category-details.php') echo 'active'; ?>">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Loại bánh</a>
                                    <ul class="dropdown-menu">
<?php
$ret=mysqli_query($con,"select * from tblcategory");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {
?>
                                    <li><a href="category-details.php?catname=<?php  echo $row['CategoryName'];?>"><?php  echo $row['CategoryName'];?></a></li><?php }?>                                       
                                    </ul>
                                </li>
                                 <li class="<?php if ($currentPage == 'about-us.php') echo 'active'; ?>">
                                    <a href="about-us.php">Giới thiệu</a></li>        
                            </ul>
                            <ul class="navbar-nav justify-content-end">
                               <?php if (!isset($_SESSION['fosuid']) || strlen($_SESSION['fosuid']) == 0) { ?>
                                <li class="<?php if ($currentPage == 'registration.php') echo 'active'; ?>"><a href="registration.php">Đăng ký</a></li>
                                <li class="<?php if ($currentPage == 'login.php') echo 'active'; ?>"><a href="login.php">Đăng nhập</a></li>
                                <li class="<?php if ($currentPage == 'track-order.php') echo 'active'; ?>"><a href="track-order.php">Theo dõi đơn hàng</a></li>
                                <?php } ?>
                                <?php if (isset($_SESSION['fosuid']) && strlen($_SESSION['fosuid']) > 0) { ?>
                                <li class="dropdown submenu <?php if (in_array($currentPage, ['profile.php', 'change-password.php'])) echo 'active'; ?>">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Tài khoản</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="profile.php">Trang cá nhân</a></li>
                                        <li><a href="change-password.php">Đổi mật khẩu</a></li>
                                        <li><a href="logout.php">Đăng xuất</a></li>
                                    </ul>
                                </li>
                                <li class="<?php if ($currentPage == 'cart.php') echo 'active'; ?>"><a href="cart.php">Trang giỏ hàng</a></li>
                                <li class="<?php if ($currentPage == 'my-order.php') echo 'active'; ?>"><a href="my-order.php">Đơn hàng</a></li><?php } ?>
                                <li class="<?php if ($currentPage == 'contact.php') echo 'active'; ?>"><a href="contact.php">Liên hệ</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </header>