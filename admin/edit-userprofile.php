<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['fosaid']==0)) {
  header('location:logout.php');
  } else{
if(isset($_POST['submit']))
  {
    $sid=$_GET['userid'];
    $fname=$_POST['firstname'];
    $lname=$_POST['lastname'];
$isloyal = isset($_POST['isloyal']) ? 1 : 0;

$query = mysqli_query($con, "UPDATE tbluser SET FirstName='$fname', LastName='$lname', IsLoyalCustomer='$isloyal' WHERE ID='$sid'");

    if ($query) {
    echo '<script>alert("Hồ sơ đã được cập nhật")</script>';
  }
  else
    {
       echo '<script>alert("Something Went Wrong. Please try again.")</script>';
    }
}

 ?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hệ thóng Bánh ngọt|| Chi tiết người dùng</title>

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
                <h2>Chi tiết người dùng</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="dashboard.php">Trang chủ</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a>Chi tiết người dùng</a>
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
$sid=$_GET['userid'];
$ret=mysqli_query($con,"select * from tbluser where ID='$sid'");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>

                            <form id="submit" action="#" class="wizard-big" method="post" name="submit">
                                    <fieldset>
                                          <div class="form-group row"><label class="col-sm-2 col-form-label">Tên:</label>
                                                <div class="col-sm-10"><input name='firstname' id="firstname" class="form-control white_bg" value="<?php  echo $row['FirstName'];?>">
     
       
   </div>
                                            </div>
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Họ:</label>
                                                <div class="col-sm-10"><input type="text" class="form-control" name="lastname" value="<?php  echo $row['LastName'];?>"></div>
                                            </div>
                                            
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Email:</label>
                                                <div class="col-sm-10">
                                                 <input type="email" class="form-control" name="email" readonly="true" value="<?php  echo $row['Email'];?>">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Số điện thoại:</label>
                                                <div class="col-sm-10"><input type="text" class="form-control" name="mobilenumber" readonly="true" value="<?php  echo $row['MobileNumber'];?>"></div>
                                            </div>
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Ngày đăng ký:</label>
                                                <div class="col-sm-10"><input type="text" class="form-control" name="price" readonly="true" value="<?php  echo $row['RegDate'];?>"></div>
                                            </div>
                                           <div class="form-group row">
    <label class="col-sm-2 col-form-label">Khách hàng thân thiết:</label>
    <div class="col-sm-10">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="isloyal" value="1"
                   <?php if ($row['IsLoyalCustomer'] == 1) echo 'checked'; ?>>
            <label class="form-check-label">Đánh dấu là khách hàng thân thiết</label>
        </div>
    </div>
</div>

                                        </fieldset>

                                </fieldset>
                                
                             <?php } ?>
                               
  
          <p style="text-align: center;"><button type="submit" name="submit" class="btn btn-primary">Cập nhật</button></p>
            
                                
                               
                            </form>
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