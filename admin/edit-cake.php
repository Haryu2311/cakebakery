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
     $cid=$_GET['editid'];
    $fcat=$_POST['foodcategory'];
    $itemname=$_POST['itemname'];
    $description=$_POST['description'];
    $quantity=$_POST['quantity'];
    $price=$_POST['price'];
    $weight = $_POST['weight'];

   $itempic=$_FILES["itemimages"]["name"];
    $query = mysqli_query($con, "UPDATE tblfood 
    SET CategoryName='$fcat',
        ItemName='$itemname',
        ItemPrice='$price',
        ItemDes='$description',
        ItemQty='$quantity',
        Weight='$weight'
    WHERE ID='$cid'");

    if ($query) {
   

    
    echo '<script>alert("Bánh đã cập nhật thành công!")</script>';
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

    <title>Hệ thống bánh ngọt||Chỉnh sửa mục bánh</title>

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
                <h2>Chỉnh sửa bánh</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="dashboard.php">Trang chủ</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a>Tên mặt hàng</a>
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
 $cid=$_GET['editid'];
$ret=mysqli_query($con,"select * from tblfood where ID='$cid'");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>

                            <form id="submit" action="#" class="wizard-big" method="post" name="submit">
                                <p style="font-size:16px; color:red;"> <?php if($msg){
    echo $msg;
  }  ?> </p>
                                    <fieldset>
                                         
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Tên mặt hàng:</label>
                                                <div class="col-sm-10"><input type="text" class="form-control" name="itemname" value="<?php  echo $row['ItemName'];?>"></div>
                                            </div>
                                            
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Mô tả:</label>
                                                <div class="col-sm-10">
                                                 
                                                 <textarea type="text" class="form-control" name="description" row="8" cols="12" required="true">
                                                    <?php  echo $row['ItemDes'];?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Hình ảnh</label>
                                                <div class="col-sm-10"><img src="itemimages/<?php echo $row['Image'];?>" width="200" height="150" value="<?php  echo $row['Image'];?>"><a href="changeimage.php?editid=<?php echo $row['ID'];?>">Edit Image</a> </div>
                                            </div>

                                            <div class="form-group row">
    <label class="col-sm-2 col-form-label">Số lượng:</label>
    <div class="col-sm-10">
        <input type="number" class="form-control" name="quantity" min="1" required>
    </div>
</div>
                                            <div class="form-group row">
    <label class="col-sm-2 col-form-label">Giá:</label>
    <div class="col-sm-10">
        <!-- Hiển thị cho người dùng -->
        <input type="text" id="price_display" class="form-control" required>

        <!-- Input ẩn chứa giá trị thực để gửi về PHP -->
        <input type="hidden" id="price_real" name="price">
    </div>
</div>
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Khối lượng:</label>
                                                <div class="col-sm-10">
<input type="text" name="weight" class="form-control white_bg" 
    value="<?php echo $row['Weight']; ?>" 
    placeholder="VD: 500 gm hoặc 1.5 kg"
    pattern="^\d+(\.\d+)?\s*(kg|gm)$" 
    title="Chỉ được nhập như: 500 gm hoặc 1.5 kg"
    required>

                                                    </div>
                                            </div>
                                           <div class="form-group row"><label class="col-sm-2 col-form-label">Loại bánh:</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control white_bg" name='foodcategory' >
                  <option value="<?php  echo $row['CategoryName'];?>"><?php  echo $row['CategoryName'];?></option>
                  <?php
      
      $query=mysqli_query($con,"select * from  tblcategory");
              while($row=mysqli_fetch_array($query))
              {
              ?>
                  <option value="<?php  echo $row['CategoryName'];?>"><?php  echo $row['CategoryName'];?></option><?php } ?>
              </select>    
              
     
       
   </div>
                                            </div>
                                        </fieldset>

                                </fieldset>
                                
                             
                              <?php 
$cnt=$cnt+1;
}?> 
  
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
document.querySelector('input[name="weight"]').addEventListener('input', function (e) {
    // Loại bỏ các ký tự không phải số, dấu chấm, khoảng trắng, k/g/m
    this.value = this.value.replace(/[^0-9.kgmg\s]/gi, '');

    // Chặn ký tự "-" luôn
    this.value = this.value.replace(/-/g, '');
});
</script>


    <script>
// Xử lý giá: hiển thị có dấu chấm, gửi giá trị số thực
const displayInput = document.getElementById('price_display');
const realInput = document.getElementById('price_real');

displayInput.addEventListener('input', function () {
    // Loại bỏ mọi ký tự không phải số
    const raw = this.value.replace(/\D/g, '');

    // Gán vào input ẩn
    realInput.value = raw;

    // Hiển thị lại với dấu chấm phân tách hàng nghìn
    this.value = raw.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
});

// Chặn nhập ký tự lạ vào trường số lượng
document.querySelector('[name="quantity"]').addEventListener('keypress', function (e) {
    const char = String.fromCharCode(e.which);
    if (!/[0-9]/.test(char)) {
        e.preventDefault();
    }
});

// Lọc lại khi dán dữ liệu vào trường số lượng
document.querySelector('[name="quantity"]').addEventListener('input', function (e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
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