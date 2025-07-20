<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
function formatPolicyText($text) {
    $lines = explode("\n", $text);
    $html = '';
    $inList = false;
    $bufferQuestion = null;

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '') {
            continue;
        }

        // Gạch đầu dòng
        if (preg_match('/^[-•*]\s+(.+)/', $line, $matches)) {
            if (!$inList) {
                $html .= '<ul>';
                $inList = true;
            }
            $html .= '<li>' . htmlspecialchars($matches[1]) . '</li>';
        }
        // Dòng là tiêu đề kiểu "5.1. Mục đích" hoặc là câu hỏi có dấu hỏi
        elseif (preg_match('/^\d+(\.\d+)*\.\s+.+/', $line) || preg_match('/^[^:]+[\?？]$/u', $line)) {
            if ($inList) {
                $html .= '</ul>';
                $inList = false;
            }
            if ($bufferQuestion !== null) {
                $html .= '<p>' . $bufferQuestion . '</p>';
            }
            $bufferQuestion = '<b>' . htmlspecialchars($line) . '</b>';
        }
        // Nội dung trả lời
        else {
            if ($bufferQuestion !== null) {
                $html .= '<p>' . $bufferQuestion . '</p>';
                $bufferQuestion = null;
            }
            if ($inList) {
                $html .= '</ul>';
                $inList = false;
            }
            $html .= '<p>' . htmlspecialchars($line) . '</p>';
        }
    }

    // Nếu còn câu hỏi chưa xử lý
    if ($bufferQuestion !== null) {
        $html .= '<p>' . $bufferQuestion . '</p>';
    }

    if ($inList) {
        $html .= '</ul>';
    }

    return $html;
}


?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chính sách cửa hàng bánh</title>

    <!-- Icon css link -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="vendors/linearicons/style.css" rel="stylesheet">
    <link href="vendors/flat-icon/flaticon.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Extra plugin css -->
    <link href="vendors/owl-carousel/owl.carousel.min.css" rel="stylesheet">
    <link href="vendors/magnifc-popup/magnific-popup.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">

    <style>
        .policy-container {
            background-color: #fff;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            margin-bottom: 60px;
        }

        .policy-container h1 {
            color: #d2691e;
            margin-top: 30px;
            font-weight: 300;
            padding-left: 15px;
        }

        .policy-container p {
            margin-bottom: 10px;
        }

        .policy-container em {
            display: block;
            margin-top: 30px;
            text-align: center;
            color: #888;
        }

        @media (max-width: 768px) {
            .policy-container {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>

<!-- Header -->
<?php include_once('includes/header.php'); ?>

<!-- Banner -->
<section class="banner_area">
    <div class="container">
        <div class="banner_text">
            <h3>Chính sách cửa hàng</h3>
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="policy.php">Chính sách</a></li>
            </ul>
        </div>
    </div>
</section>

<!-- Chính sách -->
<section class="our_bakery_area p_100">
    <div class="container">
        <div class="policy-container">
            <?php
            $query = mysqli_query($con, "
    SELECT * FROM tblpolicy 
    ORDER BY FIELD(slug, 'trich-nghi-dinh') DESC, id ASC
");

            while ($row = mysqli_fetch_array($query)) {
                echo '<h1 id="' . htmlspecialchars($row['slug']) . '" style="padding-top:120px; margin-top:-120px;">' . htmlspecialchars($row['title']) . '</h2>';
                echo '<div class="policy-content">' . formatPolicyText($row['content']) . '</div>';
                echo '<hr style="margin: 40px 0;">';
            }
            ?>
        </div>
    </div>
</section>




<!-- Footer -->
<?php include_once('includes/footer.php'); ?>

<!-- JS Scripts -->
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="vendors/owl-carousel/owl.carousel.min.js"></script>
<script src="vendors/magnifc-popup/jquery.magnific-popup.min.js"></script>
<script src="js/theme.js"></script>

</body>
</html>