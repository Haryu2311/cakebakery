<?php
session_start();
error_reporting(0);
include_once('includes/dbconnection.php');
if (strlen($_SESSION['fosuid']==0)) {
  header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="vi">
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
    <script language="javascript" type="text/javascript">
    var popUpWin=0;
    function popUpWindow(URLStr, left, top, width, height) {
        if(popUpWin) {
            if(!popUpWin.closed) popUpWin.close();
        }
        popUpWin = open(URLStr,'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+600+',height='+600+',left='+left+', top='+top+',screenX='+left+',screenY='+top);
    }
    </script>
</head>
<body>
    <?php include_once('includes/header.php'); ?>
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

    <section class="cart_table_area p_100">
        <div class="container">
            <h4 style="color: palevioletred;text-align: center;">Chi tiết đơn hàng của bạn</h4>

            <ul class="nav nav-tabs mb-3" role="tablist">
    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#cho-xac-nhan" role="tab">Chờ xác nhận</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#da-xac-nhan" role="tab">Đã xác nhận</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#dang-giao" role="tab">Đang giao</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#da-giao" role="tab">Đã giao</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#da-huy" role="tab">Đã hủy</a></li>
</ul>

<div class="tab-content">

<?php
function renderOrderTable($con, $userid, $statusFilter, $title) {
    if (is_null($statusFilter)) {
        $query = mysqli_query($con, "SELECT * FROM tblorderaddresses WHERE UserId='$userid' AND (OrderFinalStatus IS NULL OR OrderFinalStatus='')");
    } else if (is_array($statusFilter)) {
        $inClause = "'" . implode("','", $statusFilter) . "'";
        $query = mysqli_query($con, "SELECT * FROM tblorderaddresses WHERE UserId='$userid' AND OrderFinalStatus IN ($inClause)");
    } else {
        $query = mysqli_query($con, "SELECT * FROM tblorderaddresses WHERE UserId='$userid' AND OrderFinalStatus='$statusFilter'");
    }

    echo '<div role="tabpanel" class="tab-pane fade'.($title == 'cho-xac-nhan' ? ' show active' : '').'" id="'.$title.'">';
    echo '<table class="table table-bordered">';
    echo '<thead><tr><th>#</th><th>Mã đơn hàng</th><th>Ngày đặt</th><th>Trạng thái</th><th>Theo dõi</th><th>Chi tiết</th></tr></thead><tbody>';

    $cnt = 1;
    while($row = mysqli_fetch_array($query)) {
        echo '<tr>';
        echo '<td>'.$cnt.'</td>';
        echo '<td>'.$row['Ordernumber'].'</td>';
        echo '<td>'.$row['OrderTime'].'</td>';
        echo '<td>'.($row['OrderFinalStatus'] == '' ? 'Chờ xác nhận' : $row['OrderFinalStatus']).'</td>';
        echo '<td><a href="javascript:void(0);" onClick="popUpWindow(\'trackorder.php?oid='.$row['Ordernumber'].'\');">Theo dõi</a></td>';
        echo '<td><a href="order-detail.php?orderid='.$row['Ordernumber'].'" class="btn btn-sm btn-outline-primary">Chi tiết</a></td>';
        echo '</tr>';
        $cnt++;
    }

    if ($cnt == 1) {
        echo '<tr><td colspan="6" style="text-align:center;">Không có đơn hàng</td></tr>';
    }

    echo '</tbody></table>';
    echo '</div>';
}

$userid = $_SESSION['fosuid'];

renderOrderTable($con, $userid, null, 'cho-xac-nhan');
renderOrderTable($con, $userid, ['Đơn hàng đã được xác nhận', 'Bánh đang được chuẩn bị'], 'da-xac-nhan');
renderOrderTable($con, $userid, 'Nhận bánh', 'dang-giao');
renderOrderTable($con, $userid, 'Bánh được giao', 'da-giao');
renderOrderTable($con, $userid, 'Đơn hàng đã bị hủy', 'da-huy');

?>

</div>

        </div>
    </section>

    <?php include_once('includes/footer.php'); ?>

    <!-- JS Scripts -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="vendors/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script src="vendors/revolution/js/jquery.themepunch.revolution.min.js"></script>
    <script src="vendors/revolution/js/extensions/revolution.extension.actions.min.js"></script>
    <script src="vendors/revolution/js/extensions/revolution.extension.video.min.js"></script>
    <script src="vendors/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
    <script src="vendors/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
    <script src="vendors/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
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
</html>
<?php } ?>
