<?php
session_start();
require_once '../../config/conn_db.php';


if (isset($_SESSION['username'])) {
    // get current date format Y-m-d
    $currentDate = date("Y-m-d");
    $sql = "SELECT ordermenu.order_name, ordermenu.quantity, ordermenu.price, tables.table_name, ordermenu.order_date 
           FROM ordermenu 
           INNER JOIN tables ON ordermenu.table_ID = tables.table_number 
           WHERE ordermenu.member_ID = {$_SESSION['store_id']} AND ordermenu.order_date = '{$currentDate}'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $orderData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    setlocale(LC_TIME, 'th_TH.utf8'); // Set the locale to Thai
    date_default_timezone_set('Asia/Bangkok'); // Set timezone to Asia/Bangkok
    
} else {
    header('Location: ../authentication/login.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
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
                <img src="../../assets/logo.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-top" />
                <span class="textbrand">อร่อยใกล้เคียง</span>
            </a>

            <!-- Add the hamburger menu button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
        <!-- <h3>อาหารที่สั่งของวันที่ <?php echo date("d/m/Y  H:i"); ?></h3>
       
        <p>โต๊ะ: <?php echo isset($_GET['tableNumber']) ? $_GET['tableNumber'] : 'ไม่ระบุ'; ?></p> -->

        <h4>สรุปคำสั่งซื้อรายการอาหารประจำวันที่ <?php echo date("d/m/Y"); ?></h4>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ชื่อเมนู</th>
                    <th scope="col">ราคา</th>
                    <th scope="col">จำนวน</th>
                    <th scope="col">ราคารวม</th>
                    <th scope="col">โต๊ะ</th>
                    <!-- <th scope="col"></th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $totalPrice = 0;
                $totalQuantity = 0;
                foreach ($orderData as $order) {
                    $totalPrice += $order['price'] * $order['quantity'];
                    $totalQuantity += $order['quantity'];
                ?>
                    <tr>
                        <td><?php echo $order['order_name']; ?></td>
                        <td><?php echo $order['price']; ?></td>
                        <td><?php echo $order['quantity']; ?></td>
                        <td><?php echo $order['price'] * $order['quantity']; ?></td>
                        <td><?php echo $order['table_name']; ?></td>
                    </tr>
                <?php
                }
                ?>


            </tbody>

        </table>

        <div class="col">
            <div class="rol" style="margin-left: 10px; display:flex; gap: 8px;">
                <p class="text-total-price">ทั้งหมด:
                    <?php echo $totalQuantity; ?> รายการ
                </p>
                <p class="text-total-price">ยอดรวมทั้งหมด:
                    <?php echo $totalPrice; ?> บาท
                </p>
            </div>
            <div class="rol" style="margin-left: 10px; display:flex; gap: 8px;">
                <a href="../order-menu.php?restaurant=<?php echo $_SESSION['store_id_customer'] ?>" class="btn btn-back-to-menu">กลับไปยังหน้าเมนู</a>
            </div>
        </div>

    </div>
    <!-- ... -->

    <script>
        function removeItem(foodname) {
            if (confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?')) {
                const xhr = new XMLHttpRequest();

                xhr.open('GET', `../../service/remove_item.php?foodname=${encodeURIComponent(foodname)}`, true);

                xhr.onreadystatechange = function() {
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