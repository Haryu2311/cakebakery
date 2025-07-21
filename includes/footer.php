<?php
include('includes/dbconnection.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(0);
if(isset($_POST['sub']))
  {
   
    $email=$_POST['email'];
 
     
    $query=mysqli_query($con, "insert into tblsubscriber(Email) value('$email')");
    if ($query) {
   echo "<script>alert('Your subscribe successfully!.');</script>";
echo "<script>window.location.href ='index.php'</script>";
  }
  else
    {
       echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }

  
}
$query = mysqli_query($con, "SELECT title, slug FROM tblpolicy ORDER BY id ASC");
  ?>
<!--================Newsletter Area =================-->
        <!--================End Newsletter Area =================-->
        <!--================Footer Area =================-->
        <iframe
  src="https://maps.google.com/maps?q=10.046319,105.768832&z=18&output=embed"
  width="100%"
  height="250"
  style="border:0; border-radius: 8px;"
  allowfullscreen=""
  loading="lazy"
  referrerpolicy="no-referrer-when-downgrade">
</iframe>

        <footer class="footer_area">
            <div class="footer_widgets">
                <div class="container">
                    <div class="row footer_wd_inner">
                        <div class="col">
                            <aside class="f_widget f_about_widget">
                                <img src="img/footer-logo.png" alt="">
<?php

$ret=mysqli_query($con,"select * from tblpage where PageType='aboutus' ");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>
                                <p><?php  echo $row['PageDescription'];?>.</p><?php } ?>
                                <!-- Ảnh Bộ Công Thương -->
                                <img src="img/bocongthuong.jpg" alt="Đã đăng ký BCT" style="width: 100%; max-width: 160px; margin-top: -50px; margin-bottom: -30px;">
                                <ul class="nav">
    <li><a href="#"><i class="fa fa-facebook" style="color: #3b5998;"></i></a></li>
    <li><a href="#"><i class="fa fa-linkedin" style="color: #0077b5;"></i></a></li>
    <li><a href="#"><i class="fa fa-twitter" style="color: #1da1f2;"></i></a></li>
    <li><a href="#"><i class="fa fa-google-plus" style="color: #db4437;"></i></a></li>
</ul>

                            </aside>
                        </div>
                        <div class="col">
                            <aside class="f_widget f_link_widget">
                                <div class="f_title">
                                    <h3>Liên kết nhanh</h3>
                                </div>
                                <ul class="list_style">
                                    <li><a href="index.php">Trang chủ</a></li>
                                    <li><a href="cake.php">Các loại bánh</a></li>
                                    <li><a href="about-us.php">Thông tin của chúng tôi</a></li>
                                    <li><a href="cake.php">Các loại bánh</a></li>
                                    <li><a href="about-us.php">Thông tin của chúng tôi</a></li>
                                    <li><a href="contact.php">Liên hệ với chúng tôi</a></li>
                                    <?php if (strlen($_SESSION['fosuid']==0)) {?>
                                <li><a href="registration.php">Đăng ký</a></li>
                                <li><a href="login.php">Đăng nhập</a></li>
                                <li><a href="cart.html">Theo dõi đơn hàng</a></li><?php } ?>
                                <?php if (strlen($_SESSION['fosuid']>0)) {?>
                                <li><a href="registration.php">Trang giỏ hàng</a></li>
                                <li><a href="login.php">Hóa đơn của tôi</a></li>
                                <?php } ?>
                                </ul>
                            </aside>
                        </div>
                        
                        <div class="col">
    <aside class="f_widget f_link_widget">
        <div class="f_title">
            <h3>Các chính sách</h3>
        </div>
<ul class="list_style">
    <?php
    $allPolicies = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $allPolicies[] = $row;
    }

    $limit = 6;
    foreach (array_slice($allPolicies, 0, $limit) as $row) {
    ?>
        <li><a href="policy.php#<?php echo htmlspecialchars($row['slug']); ?>">
            <?php echo htmlspecialchars($row['title']); ?>
        </a></li>
    <?php } ?>

    <div id="more-policies" style="display: none;">
        <?php foreach (array_slice($allPolicies, $limit) as $row) { ?>
            <li><a href="policy.php#<?php echo htmlspecialchars($row['slug']); ?>">
                <?php echo htmlspecialchars($row['title']); ?>
            </a></li>
        <?php } ?>
    </div>

    <?php if (count($allPolicies) > $limit) { ?>
        <li>
            <a href="javascript:void(0);" id="toggle-more-policies" style="font-weight: bold;">
                Xem thêm ↓
            </a>
        </li>
    <?php } ?>
</ul>


    </aside>
</div>
                        <div class="col">
                            <aside class="f_widget f_link_widget">
                                <div class="f_title">
                                    <h3>Thời gian làm việc</h3>
                                </div>
                                <ul class="list_style">
                                    <li><a href="#">Thứ 2. : 8 am - 8 pm</a></li>
                                    <li><a href="#">Thứ 7. : 9 am - 4 pm</a></li>
                                    <li><a href="#">Chủ nhật. : Đóng cửa</a></li>
                                </ul>
                            </aside>
                        </div>
                        <div class="col">
                            <aside class="f_widget f_contact_widget">
                                <div class="f_title">
                                    <h3>Thông tin liên hệ
                                    </h3>
                                </div>
                                <?php

$ret=mysqli_query($con,"select * from tblpage where PageType='contactus' ");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>
                                <h4>Số điện thoại : <?php  echo $row['MobileNumber'];?></h4>
                                <p>Địa chỉ : <br /><?php  echo $row['PageDescription'];?></p>
                                <h5>Email : <?php  echo $row['Email'];?>n</h5><?php } ?>
                            </aside>
                            
                        </div>
                    </div>
                </div>
                
            </div>
            
        </footer>
        
        <script>
document.addEventListener("DOMContentLoaded", function () {
    var toggleBtn = document.getElementById("toggle-more-policies");
    var morePolicies = document.getElementById("more-policies");
    var isExpanded = false;

    if (toggleBtn) {
        toggleBtn.addEventListener("click", function () {
            isExpanded = !isExpanded;
            if (isExpanded) {
                morePolicies.style.display = "block";
                toggleBtn.innerHTML = "Thu gọn ↑";
            } else {
                morePolicies.style.display = "none";
                toggleBtn.innerHTML = "Xem thêm ↓";
            }
        });
    }
});
</script>

        <!--================End Footer Area =================-->
    