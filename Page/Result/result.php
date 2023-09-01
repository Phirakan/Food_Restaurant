<?php
session_start();
require_once '../../config/conn_db.php';

$selectedTableNumber = isset($_GET['table_Number']) ? $_GET['table_Number'] : '';

if (isset($_POST['submitOrder'])) {
    // Get the total price and other data from the form
    $totalPrice = $_POST['totalPrice'];
    // You can get other menu items, quantities, etc. using similar method

    // Store the data in session or pass it to Result.php using a query parameter
    $_SESSION['orderData'] = array(
        'totalPrice' => $totalPrice,
        // Include other data here
    );

    // Redirect to Result.php
    header("Location: Result.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <!-- CSS -->
    <link rel="stylesheet" href="../../css/index.css" />
    <link rel="stylesheet" href="../../css/edit-menu.css" />
    <link rel="stylesheet" href="../../css/result.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link rel="icon" href="../../assets/logo.png" type="image/x-icon" />
    <title>สรุปคำสั่งซื้อ</title>
    <style>

    </style>
</head>

<body>
    <!-- Your navigation bar and other UI elements here -->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbarcustom">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../index.php">
                <img src="../../assets/logo.png" alt="Logo" width="50" height="50"
                    class="d-inline-block align-text-top" />
                <span class="textbrand">อร่อยใกล้เคียง</span>
            </a>

            <!-- Add the hamburger menu button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Right side -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav menunavbar">
                    <li class="nav-item username-layout">
                        <p class="text-username">ร้าน
                            <?php echo $_SESSION['username']; ?>
                        </p>
                    </li>
                    <li class="nav-item">
                        <a href="../../service/logout.php" class="btn btn-order-atnav">ออกจากระบบ</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h3>อาหารที่สั่งของวันที่ <?php echo date("d/m/Y "); ?></h3>
       
       

        <h4>สรุปคำสั่งซื้อรายการอาหาร</h4>
        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
            <table class="table">
    <thead>
        <tr>
            <th scope="col">ชื่อเมนู</th>
            <th scope="col">ราคา</th>
            <th scope="col">จำนวน</th>
            <th scope="col">ราคารวม</th>
            <th scope="col">โต๊ะ</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totalPrice = 0;
        $totalQuantity = 0; // Initialize total quantity
        foreach ($_SESSION['cart'] as $index => $item):
            $itemTotal = $item['quantity'] * $item['price'];
            $totalPrice += $itemTotal;
            $totalQuantity += $item['quantity']; // Add to total quantity
            ?>
            <tr>
                <!-- <th scope="row"><?php echo $index + 1; ?></th> -->
                <td>
                    <?php echo $item['foodname']; ?>
                </td>
                <td>
                    <?php echo $item['price']; ?>
                </td>
                <td>
                    <?php echo $item['quantity']; ?>
                </td>
                <td>
                    <?php echo $itemTotal; ?>
                </td>
                <td>
                    <?php echo $selectedTableNumber; // แสดงหมายเลขโต๊ะที่เลือก ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

        <?php else: ?>
            <p>ไม่มีรายการอาหาร</p>
        <?php endif; ?>
        <!-- Display the total price -->
        <!-- <div class="rol" style="margin-left: 10px; display:flex; gap: 8px;">
            <p class="text-total-price">ทั้งหมด:
                <?php echo $totalQuantity; ?> รายการ
            </p>
            <p class="text-total-price">ยอดรวมทั้งหมด:
                <?php echo $totalPrice; ?> บาท
            </p>
        </div> -->

    </div>
    <!-- ... -->

    <script>
        function removeItem(foodname) {
            if (confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?')) {
                const xhr = new XMLHttpRequest();

                xhr.open('GET', `../../service/remove_item.php?foodname=${encodeURIComponent(foodname)}`, true);

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                        location.reload(); // Reload the page to reflect the updated cart
                    }
                };

                xhr.send();
            }
        }
    </script>

</body>

</html>