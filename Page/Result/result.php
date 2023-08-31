<?php
session_start();
require_once '../../config/conn_db.php';


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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <!-- CSS -->
    <link rel="stylesheet" href="../../css/index.css" />
    <link rel="stylesheet" href="../../css/edit-menu.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        
        .container {
            margin-top: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
        }
        
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f2f2f2;
        }
        
        .text-end {
            text-align: end;
        }
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
                        <p class="text-username">ร้าน <?php echo $_SESSION['username']; ?></p>
                    </li>
                    <li class="nav-item">
                        <a href="page/order-menu.php" class="btn btn-order-atnav">ออกจากระบบ</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h3>อาหารที่สั่งของวันที่ <?php echo date("d/m/Y  H:i:s"); ?></h3>
       
        <p>โต๊ะ: <?php echo isset($_GET['tableNumber']) ? $_GET['tableNumber'] : 'ไม่ระบุ'; ?></p>
        
        <h4>รายการอาหารที่สั่ง</h4>
        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ลำดับ</th>
                        <th scope="col">ชื่อเมนู</th>
                        <th scope="col">ราคา</th>
                        <th scope="col">จำนวน</th>
                        <th scope="col">ราคารวม</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
    <?php
    $totalPrice = 0;
    $totalQuantity = 0; // Initialize total quantity
    foreach ($_SESSION['cart'] as $index => $item) :
        $itemTotal = $item['quantity'] * $item['price'];
        $totalPrice += $itemTotal;
        $totalQuantity += $item['quantity']; // Add to total quantity
    ?>
        <tr>
            <th scope="row"><?php echo $index + 1; ?></th>
            <td><?php echo $item['foodname']; ?></td>
            <td><?php echo $item['price']; ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td><?php echo $itemTotal; ?></td>
            <td>
                <button class="btn btn-danger" onclick="removeItem('<?php echo $item['foodname']; ?>')">ลบ</button>
            </td>
            
        </tr>
    <?php endforeach; ?>
    <tr>
        <th colspan="3" class="text-end">รวมทั้งหมด</th>
        <td><?php echo $totalQuantity; ?></td>
        <td><?php echo $totalPrice; ?></td>
    </tr>
</tbody>

            </table>
        <?php else : ?>
            <p>ไม่มีรายการอาหาร</p>
        <?php endif; ?>
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