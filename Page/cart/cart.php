<?php

session_start();
require_once '../../config/conn_db.php'; // Added semicolon at the end



if (isset($_GET['foodname']) && isset($_GET['price']) && isset($_GET['quantity'])) {
    $foodname = $_GET['foodname'];
    $price = $_GET['price'];
    $quantity = $_GET['quantity'];

    // Store the selected food item in the session or database as needed
    // You can use an array or other data structure to store multiple items in the cart

    $_SESSION['cart'][] = array(
        'foodname' => $foodname,
        'price' => $price,
        'quantity' => $quantity

    );
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.png" type="image/x-icon" />
    <title>ตะกร้ารายการสั่งอาหาร</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.0.5/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <!-- CSS -->
    <link rel="stylesheet" href="../../css/index.css" />
    <link rel="stylesheet" href="../../css/cart.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbarcustom">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
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
                        <a href="../service/logout.php" class="btn btn-order-atnav">ออกจากระบบ</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Navbar -->

    <!-- Your modal code here -->

    <div class="container mt-5 cart-box">
        <div class="row mb-2">
            <div class="col-md-6">
                <h3>รายการสั่งอาหาร</h3>
            </div>
            <div class="col-md-6 d-flex justify-content-end" style="gap: 16px; align-items: center;">
                <!-- Dropdown for choose table-->
                <select class="form-select selection-table-dropdown" aria-label="Default select example">
                    <option selected>กรุณาเลือกโต๊ะ</option>
                    <option value="1">โต๊ะ 1</option>
                    <option value="2">โต๊ะ 2</option>
                    <option value="3">โต๊ะ 3</option>
                </select>
                <button type="button" class="btn btn-add-menu" onclick="removeAllItems()">นำรายการออกทั้งหมด</button>
            </div>
        </div>

        <!-- ตาราง -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ลำดับ.</th>
                    <th scope="col">ชื่อเมนู</th>
                    <th scope="col">ราคา</th>
                    <th scope="col">จำนวน</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalPrice = 0; // Initialize total price
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    $cartItems = $_SESSION['cart'];
                    $count = 1;

                    foreach ($cartItems as $item) {
                        $itemName = $item['foodname'];
                        $itemPrice = $item['price'];
                        $itemQuantity = $item['quantity'];

                        $itemTotal = $itemPrice * $itemQuantity;
                        $totalPrice += $itemTotal;
                ?>
                        <tr>
                            <th scope="row"><?php echo $count; ?></th>
                            <td><?php echo $itemName; ?></td>
                            <td><?php echo $itemPrice; ?></td>
                            <td><?php echo $itemQuantity; ?></td>
                            <td>
                                <button class="btn btn-danger" onclick="removeItem('<?php echo $itemName; ?>')">ลบ</button>
                            </td>
                        </tr>
                <?php
                        $count++;
                    }
                }
                ?>
            </tbody>
        </table>

        <!-- Display the total price -->
        <div class="col" style="margin-left: 14px;">
            <p class="text-total-price">ราคารวมทั้งหมด: <?php echo $totalPrice; ?></p>
            <div class="row" style="gap:16px;">
                <a href="../order-menu.php" class="btn btn-back-to-ordermenu">กลับไปยังหน้าเมนู</a>
                <a  class="btn btn-send-ordermenu" id="orderButton" >สั่งอาหาร</a>
            </div>
        </div>

    </div>


    <script>
        function removeAllItems() {
            const xhr = new XMLHttpRequest();

            xhr.open('GET', `../../service/remove_all_items.php`, true);

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    location.reload(); // Reload the page to reflect the updated cart
                }
            };

            xhr.send();
        }
    </script>
    <script>
        function removeItem(itemName) {
            const xhr = new XMLHttpRequest();

            xhr.open('GET', `../../service/remove_item.php?foodname=${encodeURIComponent(itemName)}`, true);

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    location.reload(); // Reload the page to reflect the updated cart
                }
            };

            xhr.send();
        }
    </script>
    <script>
document.getElementById("orderButton").addEventListener("click", function() {
    alert("คำสั่งซื้อสำเร็จ!");
    
});
</script>
    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
   
</body>

</html>