<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['fosaid']==0)) {
   header('location:logout.php');
  } else{

if(isset($_POST['submit']))
  {
    
    $oid=$_GET['orderid'];
    $ressta=$_POST['status'];
    $remark=$_POST['restremark'];
 
    
    $query=mysqli_query($con,"insert into tblfoodtracking(OrderId,remark,status) value('$oid','$remark','$ressta')"); 
   $query=mysqli_query($con, "update   tblorderaddresses set OrderFinalStatus='$ressta' where Ordernumber='$oid'");
    if ($query) {
    $msg="Đơn hàng đã được cập nhật";
  }
  else
    {
      $msg="Something Went Wrong. Please try again";
    }

  
}
  

  ?>
<!DOCTYPE html>
<html>

<head>

    

    <title>Hệ thống bánh ngọt</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/plugins/steps/jquery.steps.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

    <?php include_once('includes/leftbar.php');?>

        <div id="page-wrapper" class="gray-bg">
             <?php include_once('includes/header.php');?>
        <div class="row border-bottom">
        
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Chi tiết đặt hàng #<?php echo $_GET['orderid'];?></h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="dashboard.php">Trang chủ</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a>Chi tiết đặt hàng</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Cập nhật</strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        
                        <div class="ibox-content">
                           <?php
 $oid=$_GET['orderid'];
$ret=mysqli_query($con,"select * from tblorderaddresses join tbluser on tbluser.ID=tblorderaddresses.UserId where tblorderaddresses.Ordernumber='$oid'");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>
<div class="row">
  <div class="col-6">
     <p style="font-size:16px; color:red; text-align: center"><?php if($msg){
    echo $msg;
  }  ?> </p>
<table border="1" class="table table-bordered mg-b-0">
 <tr align="center">
<td colspan="2" style="font-size:20px;color:blue">
Chi tiết người dùng</td></tr>

    <tr>
    <th>Số đơn hàng</th>
    <td><?php  echo $row['Ordernumber'];?></td>
  </tr>
  <tr>
    <th>Tên</th>
    <td><?php  echo $row['FirstName'];?></td>
  </tr>
  <tr>
    <th>Họ</th>
    <td><?php  echo $row['LastName'];?></td>
  </tr>
  <tr>
    <th>Email</th>
    <td><?php  echo $row['Email'];?></td>
  </tr>
  <tr>
    <th>Số điện thoại</th>
    <td><?php  echo $row['MobileNumber'];?></td>
  </tr>
  <tr>
    <th>Số nhà</th>
    <td><?php  echo $row['Flatnobuldngno'];?></td>
  </tr>
  <tr>
    <th>Tên đường</th>
    <td><?php  echo $row['StreetName'];?></td>
  </tr>
  <tr>
    <th>Khu vực</th>
    <td><?php  echo $row['Area'];?></td>
  </tr>
  <!-- <tr>
    <th>Cột mốc</th>
    <td><?php  echo $row['Landmark'];?></td>
  </tr> -->
  <tr>
    <th>Thành phố</th>
    <td><?php  echo $row['City'];?></td>
  </tr>
  <tr>
    <th>Ngày đặt hàng</th>
    <td><?php  echo $row['OrderTime'];?></td>
  </tr>
  <tr>
    <th>Trạng thái cuối cùng của đơn hàng</th>
    <td> <?php  
    $orserstatus=$row['OrderFinalStatus'];

if($row['OrderFinalStatus']=="Đơn hàng đã được xác nhận")
{
  echo "Đơn hàng đã được xác nhận";
}

if($row['OrderFinalStatus']=="Bánh đang được chuẩn bị")
{
  echo "Bánh đang được chuẩn bị";
}
if($row['OrderFinalStatus']=="Nhận bánh")
{
  echo "Nhận bánh";
}
if($row['OrderFinalStatus']=="Bánh được giao")
{
  echo "Bánh được giao";
}
if($row['OrderFinalStatus']=="")
{
  echo "Chờ nhà hàng phê duyệt";
}
if($row['OrderFinalStatus']=="Đơn hàng đã bị hủy")
{
  echo "Đơn hàng đã bị hủy";
}


     ;?></td>
  </tr>
</table>
     </div>
<div class="col-6" style="margin-top:2%">
  <?php  
$query=mysqli_query($con,"select tblfood.Image,tblfood.ItemName,tblfood.ItemDes,tblfood.ItemPrice,tblorders.ItemQty,tblorders.FoodId,tblorders.CashonDelivery from tblorders join tblfood on tblfood.ID=tblorders.FoodId where tblorders.IsOrderPlaced=1 and tblorders.OrderNumber='$oid'");
$num=mysqli_num_rows($query);
$cnt=1;?>
<table border="1" class="table table-bordered mg-b-0">
 <tr align="center">
<td colspan="6" style="font-size:20px;color:blue">Chi tiết đặt hàng</td></tr> 

<tr>
    <th>#</th>
    <th>Hình ảnh bánh</th>
    <th>Tên bánh</th>
    <th>Loại giao hàng</th>
    <th>Số lượng</th>
    <th>Giá</th>
</tr>

<?php  
$cnt = 1;
$grandtotal = 0;

while ($row1 = mysqli_fetch_array($query)) {
  $itemTotal = $row1['ItemPrice'] * $row1['ItemQty'];
  $grandtotal += $itemTotal;
?>

<tr>
  <td><?php echo $cnt; ?></td>
  <td><img src="itemimages/<?php echo $row1['Image']; ?>" width="60" height="40" alt="<?php echo $row1['ItemName']; ?>"></td>
  <td><?php echo $row1['ItemName']; ?></td>
<td>
  <?php 
    echo $row1['CashonDelivery'] == 0 ? 'Thanh toán khi nhận hàng (COD)' : 'Thanh toán online'; 
  ?>
</td>

  <td><?php echo $row1['ItemQty']; ?></td>
  <td><?php echo number_format($itemTotal, 0, ',', '.'); ?> VNĐ</td>
</tr>

<?php 
  $cnt++;
} 
?>

<tr>
  <th colspan="5" style="text-align:center">Tổng cộng</th>
  <td><?php echo number_format($grandtotal, 0, ',', '.'); ?> VNĐ</td>
</tr>
</table>



</div>


     </div>   
                            



                            <table class="table mb-0">

<?php

  if($orserstatus=="Đơn hàng đã được xác nhận" || $orserstatus=="Bánh đang được chuẩn bị" || $orserstatus=="Nhận bánh" || $orserstatus=="" ){ ?>


<form name="submit" method="post"> 
<tr>
    <th>Nhận xét về nhà hàng :</th>
    <td>
    <textarea name="restremark" placeholder="" rows="12" cols="14" class="form-control wd-450" required="true"></textarea></td>
  </tr>

  <tr>
    <th>Tình trạng đơn hàng:</th>
    <td>
   <select name="status" class="form-control wd-450" required="true" >
     <option value="Đơn hàng đã được xác nhận" selected="true">Đơn hàng đã được xác nhận</option>
          <option value="Đơn hàng đã bị hủy">Đơn hàng đã bị hủy</option>
     <option value="Bánh đang được chuẩn bị">Bánh đang được chuẩn bị</option>
     <option value="Nhận bánh">Nhận bánh</option>
     <option value="Bánh được giao">Bánh được giao</option>
   </select></td>
  </tr>
    <tr align="center">
    <td colspan="2"><button type="submit" name="submit" class="btn btn-primary">Cập nhật đơn hàng</button></td>
  </tr>
</form>
  <?php } ?>
 


</table>

<?php } ?>


<?php  if($orserstatus!=""){
$ret=mysqli_query($con,"select tblfoodtracking.OrderCanclledByUser,tblfoodtracking.remark,tblfoodtracking.status as fstatus,tblfoodtracking.StatusDate from tblfoodtracking where tblfoodtracking.OrderId ='$oid'");
$cnt=1;

 $cancelledby=$row['OrderCanclledByUser'];
 ?>
<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
  <tr align="center">
   <th colspan="4" >Lịch sử theo dõi đơn hàng</th> 
  </tr>
  <tr>
    <th>#</th>
<th>Nhận xét</th>
<th>Trạng thái</th>
<th>Thời gian</th>
</tr>
<?php  
while ($row=mysqli_fetch_array($ret)) { 
  ?>
<tr>
  <td><?php echo $cnt;?></td>
 <td><?php  echo $row['remark'];?></td> 
  <td><?php  echo $row['fstatus'];
if($cancelledby==1){
echo "("."bởi người dùng".")";
} else {

echo "("."bởi nhà hàng".")";
}

  ?></td> 
   <td><?php  echo $row['StatusDate'];?></td> 
</tr>
<?php $cnt=$cnt+1;} ?>
</table>
<?php  }  
?>
                        </div>
                    </div>
                    </div>

                </div>
            </div>
        <?php include_once('includes/footer.php');?>

        </div>
        </div>



    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Steps -->
    <script src="js/plugins/steps/jquery.steps.min.js"></script>

    <!-- Jquery Validate -->
    <script src="js/plugins/validate/jquery.validate.min.js"></script>


    <script>
        $(document).ready(function(){
            $("#wizard").steps();
            $("#form").steps({
                bodyTag: "fieldset",
                onStepChanging: function (event, currentIndex, newIndex)
                {
                    // Always allow going backward even if the current step contains invalid fields!
                    if (currentIndex > newIndex)
                    {
                        return true;
                    }

                    // Forbid suppressing "Warning" step if the user is to young
                    if (newIndex === 3 && Number($("#age").val()) < 18)
                    {
                        return false;
                    }

                    var form = $(this);

                    // Clean up if user went backward before
                    if (currentIndex < newIndex)
                    {
                        // To remove error styles
                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                    }

                    // Disable validation on fields that are disabled or hidden.
                    form.validate().settings.ignore = ":disabled,:hidden";

                    // Start validation; Prevent going forward if false
                    return form.valid();
                },
                onStepChanged: function (event, currentIndex, priorIndex)
                {
                    // Suppress (skip) "Warning" step if the user is old enough.
                    if (currentIndex === 2 && Number($("#age").val()) >= 18)
                    {
                        $(this).steps("next");
                    }

                    // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                    if (currentIndex === 2 && priorIndex === 3)
                    {
                        $(this).steps("previous");
                    }
                },
                onFinishing: function (event, currentIndex)
                {
                    var form = $(this);

                    // Disable validation on fields that are disabled.
                    // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                    form.validate().settings.ignore = ":disabled";

                    // Start validation; Prevent form submission if false
                    return form.valid();
                },
                onFinished: function (event, currentIndex)
                {
                    var form = $(this);

                    // Submit form input
                    form.submit();
                }
            }).validate({
                        errorPlacement: function (error, element)
                        {
                            element.before(error);
                        },
                        rules: {
                            confirm: {
                                equalTo: "#password"
                            }
                        }
                    });
       });
    </script>

</body>

</html>
   <?php } ?>