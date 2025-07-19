<?php
include('includes/dbconnection.php');
session_start();
$vnp_Amount = $_GET['vnp_Amount'];
$vnp_BankCode = $_GET['vnp_BankCode'];
$vnp_BankTranNo = $_GET['vnp_BankTranNo'];
$vnp_CardType = $_GET['vnp_CardType'];
$vnp_OrderInfo = $_GET['vnp_OrderInfo'];
$vnp_PayDate = $_GET['vnp_PayDate'];
$vnp_ResponseCode = $_GET['vnp_ResponseCode'];
$vnp_TmnCode = $_GET['vnp_TmnCode'];
$vnp_TransactionNo = $_GET['vnp_TransactionNo'];
$vnp_TransactionStatus = $_GET['vnp_TransactionStatus'];
$vnp_TxnRef = $_GET['vnp_TxnRef'];
$vnp_SecureHash = $_GET['vnp_SecureHash'];

$fnaobno=$_SESSION['flatbldgnumber'];
    $street=$_SESSION['streename'];
    $area=$_SESSION['area'];
    $lndmark=$_SESSION['landmark'];
    $city=$_SESSION['city'];
    $cod=$_SESSION['cod'];
    $userid=$_SESSION['fosuid']; 

$orderno = $_SESSION['orderid'];
    $query="update tblorders set OrderNumber='$orderno',IsOrderPlaced='1',CashonDelivery='$cod' where UserId='$userid' and IsOrderPlaced is null;";
echo $orderno ;
    $query.="insert into tblorderaddresses(UserId,Ordernumber,Flatnobuldngno,StreetName,Area,Landmark,City) values('$userid','$orderno','$fnaobno','$street','$area','$lndmark','$city');";
    $query.="insert into tblvnpay(id,orderid,amout) values(NULL, '$orderno', '$vnp_Amount');";
    $result = mysqli_multi_query($con, $query);
//    $rs = mysqli_query($con, "insert into tblvnpay (id,orderid,amout) values(NULL, '$orderno', '$vnp_Amount')");

//     echo "Amount: $vnp_Amount <br>";
// echo "Bank Code: $vnp_BankCode <br>";
// echo "Bank Transaction No: $vnp_BankTranNo <br>";
// echo "Card Type: $vnp_CardType <br>";
// echo "Order Info: $vnp_OrderInfo <br>";
// echo "Pay Date: $vnp_PayDate <br>";
// echo "Response Code: $vnp_ResponseCode <br>";
// echo "Tmn Code: $vnp_TmnCode <br>";
// echo "Transaction No: $vnp_TransactionNo <br>";
// echo "Transaction Status: $vnp_TransactionStatus <br>";
// echo "Txn Ref: $vnp_TxnRef <br>";
// echo "Secure Hash: $vnp_SecureHash <br>";


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <script>
        window.onload = function() {
            let orderNo = "<?php echo $orderno; ?>";
            alert("Bạn đã thanh toán online thành công!\nMã số đơn hàng của bạn là: " + orderNo);
            window.location.href = "my-order.php";
        }
    </script>
</body>
</html>