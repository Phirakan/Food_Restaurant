<?php

session_start();
require_once '../config/conn_db.php'; // Added semicolon  
// get value from url
// url : localhost:3000/page/order-menu.php?restaurant=1
if (isset($_GET['restaurant'])) {
    $restaurant_id = $_GET['restaurant'];
    $_SESSION['store_id_customer'] = $restaurant_id;
    $sql = "SELECT * FROM `food` WHERE `member_id` = $restaurant_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    header('Location: ../index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../assets/logo.png" type="image/x-icon" />
    <title>เมนูอาหาร</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <!-- CSS -->
    <link rel="stylesheet" href="../css/index.css" />
    <link rel="stylesheet" href="../css/order-menu.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbarcustom">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
                <img src="../assets/logo.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-top" />
                <span class="textbrand">อร่อยใกล้เคียง</span>
            </a>
            <ul class="navbar-nav menunavbar">
                <li class="nav-item">
                    <a href="cart/cart.php" class="btn btn-cart" style="gap: 8px"><i class="bi bi-basket-fill"></i>รายการสั่งอาหาร</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Navbar -->

    <!-- Content -->
    <div style="margin-left: 20px; margin-right: 20px">
        <div class="container-fluid order-menu-box">

            <div class="row row-cols-1 row-cols-md-4 g-4">
                <?php if (empty($result)) { ?>
                    <p class="text-center">No data</p>
                <?php } else { ?>
                    <?php
                    foreach ($result as $food) {
                    ?>
                        <div class="col">
                            <div class="card menu-card">
                                <img src="../upload/<?php echo $food['img']; ?>" class="card-img-top" alt="..." />
                                <div class="card-body">
                                    <h5 class="card-title text-name-food"><?php echo $food['foodname']; ?></h5>
                                    <p class="card-text text-price">ราคา <?php echo $food['price']; ?> บาท</p>

                                    <div class="input-group mb-3">
                                        <button class="btn btn-decress" type="button" onclick="decreaseQuantity(this)">-</button>
                                        <input type="number" class="form-control text-center" value="1">
                                        <button class="btn btn-incress" type="button" onclick="increaseQuantity(this)">+</button>

                                    </div>
                                    <a href="#" class="btn btn-add" onclick="addToCart('<?php echo $food['foodname']; ?>', <?php echo $food['price']; ?>, this)">เพิ่ม</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
</div>

</div>
<!-- ... -->

<script>
    function increaseQuantity(button) {
        const inputNumber = button.parentElement.querySelector('input[type="number"]');
        inputNumber.value = parseInt(inputNumber.value) + 1;
    }

    function decreaseQuantity(button) {
        const inputNumber = button.parentElement.querySelector('input[type="number"]');
        if (parseInt(inputNumber.value) > 1) {
            inputNumber.value = parseInt(inputNumber.value) - 1;
        }
    }
</script>

<script>
    function addToCart(foodName, price, btnElement) {
        const quantityInput = btnElement.closest('.card-body').querySelector('.form-control');
        const quantity = parseInt(quantityInput.value); // Get the quantity input value
        const totalPrice = price * quantity; // Calculate total price

        const xhr = new XMLHttpRequest();
        xhr.open('GET', `cart/cart.php?foodname=${encodeURIComponent(foodName)}&price=${price}&quantity=${quantity}&totalPrice=${totalPrice}`, true);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // Sweet alert
                Swal.fire({
                    icon: 'success',
                    title: 'เพิ่มรายการสำเร็จ',
                    showConfirmButton: false,
                    timer: 1500

                });
                // location.reload(); // Optional: Reload the page or show a confirmation message
                // reload after press ok button in sweet alert
                setTimeout(function() {
                    location.reload();
                }, 1800);
            }
        };
        xhr.send();
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
</body>

</html>