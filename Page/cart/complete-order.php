<?php

session_start();
require_once '../../config/conn_db.php'; // Added semicolon at the end
// clear session cart and tableSelectOrder
unset($_SESSION['cart']);
unset($_SESSION['tableSelectOrder']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.png" type="image/x-icon" />
    <title>การสั่งซื้อเสร็จสิ้น</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <!-- CSS -->
    <link rel="stylesheet" href="../../css/index.css" />
    <link rel="stylesheet" href="../../css/complete-order.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbarcustom">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../index.php">
                <img src="../../assets/logo.png" alt="Logo" width="50" height="50"
                    class="d-inline-block align-text-top" />
                <span class="textbrand">อร่อยใกล้เคียง</span>
            </a>
            <!-- <ul class="navbar-nav menunavbar">
                <li class="nav-item">
                    <a href="cart/cart.php" class="btn btn-cart" style="gap: 8px"><i class="bi bi-basket-fill"></i>รายการสั่งอาหาร</a>
                </li>
            </ul> -->
        </div>
    </nav>

    <!-- Navbar -->

    <!-- Your modal code here -->

    <div class="container complete-order-box">
        <div class="confirmation-box">
            <div class="confirmation-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <h2 class="confirmation-title">ขอบคุณสำหรับคำสั่งซื้อของคุณ!</h2>
            <p class="confirmation-text">ร้านอาหารของเรากำลังทำอาหาร</p>
            <p class="confirmation-text">ขอให้ทานอาหารอร่อย!</p>
            <a href="../order-menu.php?restaurant=<?php echo $_SESSION['store_id_customer'] ?>"
                class="confirmation-link"><i class="fas fa-home"></i> กลับสู่หน้าหลัก</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    <script>
        // Your JavaScript code here
    </script>
</body>

</html>