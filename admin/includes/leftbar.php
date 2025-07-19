    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <img alt="image" class="rounded-circle" src="img/user.png"/>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <?php
$admid=$_SESSION['fosaid'];
$ret=mysqli_query($con,"select AdminName from tbladmin where ID='$admid'");
$row=mysqli_fetch_array($ret);
$name=$row['AdminName'];

?>
                        
                            <span class="text-muted text-xs block"><?php echo $name; ?> <b class="caret"></b></span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a class="dropdown-item" href="adminprofile.php">Thông tin </a></li>
                            <li><a class="dropdown-item" href="changepassword.php">Đổi mật khẩu </a></li>
                            <li class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                    CBS
                    </div>
                </li>
                <li>
                    <a href="dashboard.php"><i class="fa fa-th-large"></i> <span class="nav-label">Quản trị </span> <span class="fa arrow"></span></a>
                                    </li>
                                    <li>
                    <a href="user-detail.php"><i class="fa fa-users"></i> <span class="nav-label">Quản lí tài khoản </span> <span class="fa arrow"></span></a>
                                    </li>
              
                <li>
                    <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Loại bánh </span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="add-cakecategory.php"> Loại bánh </a></li>
                        <li><a href="manage-cakecategory.php">Quản lí loại bánh</a></li>
                    
                       
                    </ul>
                </li>
 <li>
                    <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Quản lí bánh </span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="add-cake.php">Thêm bánh </a></li>
                        <li><a href="manage-cake.php">Sửa bánh </a></li>
                    </ul>
                </li> 
 <li>
                    <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Chính sách </span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="manage-policy.php">Quản lý chính sách </a></li>
                        <li><a href="add-policy.php">Thêm chính sách</a></li>
                    </ul>
                </li> 

        <li>
                    <a href="#"><i class="fa fa-list"></i> <span class="nav-label">Đơn hàng </span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                         <li><a href="notconfirmedyet.php">Đơn chưa xác nhận </a></li>
                        <li><a href="confirmed-order.php">Đơn đã xác nhận </a></li>
                        <li><a href="cakebeingprepared.php">Bánh đã được chuẩn bị </a></li>
                        <li><a href="cake-pickup.php">Bánh đã được lấy </a></li>
                        <li><a href="cake-delivered.php">Bánh đã được vận chuyển </a></li>
                        <li><a href="canclled-order.php">Hủy đơn hàng</a></li>
                         <li><a href="all-order.php">Tất cả đơn hàng </a></li>
                    
                       
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Quản lí trang </span><span class="fa arrow"></span></a>

                    <ul class="nav nav-second-level collapse">
                        <li><a href="aboutus.php">Thông tin </a></li>
                        <li><a href="contactus.php">Liên hệ</a></li>
                    
                       
                    </ul>
                </li>
            <li>
    <a href="manage-contact.php"><i class="fa fa-envelope"></i> <span class="nav-label">Quản lý liên hệ</span></a>
</li>

                <!-- <li>
                    <a href="#"><i class="fa fa-file"></i> <span class="nav-label">Enquiry</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                         <li><a href="readenq.php">Read Enquiry</a></li>
                        <li><a href="unreadenq.php">Unread Enquiry</a></li>
                        
                       
                    </ul>
                </li> -->
                   <li>
                    <a href="#"><i class="fa fa-file"></i> <span class="nav-label">Báo cáo </span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="requestcount-report-ds.php">Số lượng hóa đơn</a></li>
                       
                    </ul>
                </li>
                <li>
                    <a href="search.php"><i class="fa fa-th-large"></i> <span class="nav-label">Tìm kiếm </span> <span class="fa arrow"></span></a>
                                    </li>
                                    <li>
               
            </ul>

        </div>
    </nav>