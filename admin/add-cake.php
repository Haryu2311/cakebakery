<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['fosaid']==0)) {
  header('location:logout.php');
  } else{

if(isset($_POST['submit']))
  {
    $faid=$_SESSION['fosaid'];
    $fcat=$_POST['foodcategory'];
    $itemname=$_POST['itemname'];
    $description=$_POST['description'];
    $quantity=$_POST['quantity'];
     $price = preg_replace('/\D/', '', $_POST['price']);
    $weight=$_POST['weight'];
    $itempic=$_FILES["itemimages"]["name"];
    $extension = substr($itempic,strlen($itempic)-4,strlen($itempic));
// allowed extensions
$allowed_extensions = array(".jpg","jpeg",".png",".gif");
// Validation for allowed extensions .in_array() function searches an array for a specific value.
if(!in_array($extension,$allowed_extensions))
{
echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
}
else
{
    $itempic=md5($itempic).$extension;
     move_uploaded_file($_FILES["itemimages"]["tmp_name"],"itemimages/".$itempic);
    $query=mysqli_query($con, "insert into tblfood(CategoryName,ItemName,ItemPrice,ItemDes,ItemQty,Weight,Image) value('$fcat','$itemname','$price','$description','$quantity','$weight','$itempic')");
    if ($query) {
   echo '<script>alert("Bánh đã được thêm thành công")</script>';
    echo "<script>window.location.href ='add-cake.php'</script>";
  }
  else
    {
     echo '<script>alert("Xảy ra lỗi! Vui lòng thử lại sau!!")</script>';
    }

  
}
}
  ?>
<!DOCTYPE html>
<html>

<head>
    <title>Hệ thống bánh ngọt|| Thêm bánh</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/plugins/steps/jquery.steps.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
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
                <h2>Mặt hàng bánh</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="dashboard.php">Trang chủ</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a>Tên mặt hàng</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Thêm</strong>
                    </li>
                </ol>
            </div>
        </div>
        
        <div class="wrapper wrapper-content animated fadeInRight">
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        
                        <div class="ibox-content">
                           

                            <form id="submit" action="#" class="wizard-big" method="post" name="submit" enctype="multipart/form-data">
                                    <fieldset>
                                          <div class="form-group row"><label class="col-sm-2 col-form-label">Loại bánh:</label>
                                                <div class="col-sm-10"><select name='foodcategory' id="foodcategory" class="form-control white_bg" required="true">
     
      <?php
      
      $query=mysqli_query($con,"select * from  tblcategory");
              while($row=mysqli_fetch_array($query))
              {
              ?>    
              <option value="<?php echo $row['CategoryName'];?>"><?php echo $row['CategoryName'];?></option>
                  <?php } ?>  
   </select></div>
                                            </div>
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Tên mặt hàng:</label>
                                                <div class="col-sm-10"><input type="text" class="form-control" name="itemname" required="true"></div>
                                            </div>
                                            
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Mô tả:</label>
                                                <div class="col-sm-10">
                                                 <textarea type="text" class="form-control" name="description" row="8" cols="12" required="true">
                                                 	</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Hình ảnh</label>
                                                <div class="col-sm-10"><input type="file" name="itemimages" required="true"></div>
                                            </div>
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Số lượng:</label>
                                                <div class="col-sm-10"><input type="text" class="form-control" name="quantity" required="true"></div>
                                            </div>
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Trọng lượng bánh:</label>
                                                <div class="col-sm-10"><select class="form-control white_bg" required="true" name="weight">
                                                    <option value="">Chọn trọng lượng</option>
                                                    <option value="500 gm">500 gm</option>
                                                    <option value="1 kg">1 kg</option>
                                                    <option value="1.5 kg">1.5 kg</option>
                                                    <option value="2 kg">2 kg</option>
                                                    <option value="2.5 kg">2.5 kg</option>
                                                    <option value="3 kg">3 kg</option>
                                                    <option value="3.5 kg">3.5 kg</option>
                                                    <option value="4 kg">4 kg</option>
                                                </select> </div>
                                            </div>
                                            <div class="form-group row">
  <label class="col-sm-2 col-form-label">Giá:</label>
  <div class="col-sm-10">
    <!-- Ô nhập có dấu chấm cho người dùng -->
    <input type="text" id="price_display" class="form-control" required>

    <!-- Ô ẩn gửi dữ liệu thật về PHP -->
    <input type="hidden" id="price_real" name="price">
  </div>
</div>
                                           
                                        </fieldset>

                                </fieldset>
                                
                                
                               
  
          <p style="text-align: center;"><button type="submit" name="submit" class="btn btn-primary">Xác nhận</button></p>
            
                                
                               
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
  const displayInput = document.getElementById('price_display');
  const realInput = document.getElementById('price_real');

  displayInput.addEventListener('input', function () {
    // Lấy chuỗi số (loại bỏ dấu chấm và ký tự không phải số)
    const raw = this.value.replace(/\D/g, '');

    // Gán vào input ẩn để gửi về PHP
    realInput.value = raw;

    // Hiển thị lại theo định dạng dấu chấm
    this.value = raw.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  });
</script>
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
<?php }  ?>