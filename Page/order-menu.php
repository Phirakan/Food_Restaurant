<?php 

session_start(); 
require_once '../config/conn_db.php'; // Added semicolon    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>รายละเอียดร้านอาหาร</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <!-- CSS -->
    <link rel="stylesheet" href="../css/index.css" />
    <link rel="stylesheet" href="../css/order-menu.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbarcustom">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="../assets/logo.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-top" />
                <span class="textbrand">อร่อยใกล้เคียง</span>
            </a>

            <!-- Button Cart to Right side -->

            <ul class="navbar-nav menunavbar">
                <li class="nav-item">
                    <a href="cart.php" class="btn btn-cart" style="gap: 8px"><i
                            class="bi bi-basket-fill"></i>รายการสั่งอาหาร</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Navbar -->

    <!-- Content -->
    <div class="container-fluid contain-order-menu">
        
        <!-- Menu  code here-->
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card menu-card">
                    <img src="../assets/ผัดกระเพรา.jpg" class="card-img-top" alt="..." />
                    <div class="card-body">
                        <h5 class="card-title text-name-food">ผัดกระเพรา</h5>
                        <p class="card-text text-price">ราคา 40 บาท</p>
                        <div class="input-group mb-3">
                            <button class="btn btn-incress" type="button">+</button>
                            <input type="number" class="form-control text-center" value="1">
                            <button class="btn btn-decress" type="button">-</button>
                        </div>
                        <a href="#" class="btn btn-add">เพิ่ม</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card menu-card">
                    <img src="../assets/ผัดกระเพรา.jpg" class="card-img-top" alt="..." />
                    <div class="card-body">
                        <h5 class="card-title text-name-food">ผัดกระเพรา</h5>
                        <p class="card-text text-price">ราคา 40 บาท</p>
                        <div class="input-group mb-3">
                            <button class="btn btn-incress" type="button">+</button>
                            <input type="number" class="form-control text-center" value="1">
                            <button class="btn btn-decress" type="button">-</button>
                        </div>
                        <a href="#" class="btn btn-add">เพิ่ม</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card menu-card">
                    <img src="../assets/ผัดกระเพรา.jpg" class="card-img-top" alt="..." />
                    <div class="card-body">
                        <h5 class="card-title text-name-food">ผัดกระเพรา</h5>
                        <p class="card-text text-price">ราคา 40 บาท</p>
                        <div class="input-group mb-3">
                            <button class="btn btn-incress" type="button">+</button>
                            <input type="number" class="form-control text-center" value="1">
                            <button class="btn btn-decress" type="button">-</button>
                        </div>
                        <a href="#" class="btn btn-add">เพิ่ม</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card menu-card">
                  <img src="../assets/ผัดกระเพรา.jpg" class="card-img-top" alt="..." />
                  <div class="card-body">
                    <h5 class="card-title text-name-food">ผัดกระเพรา</h5>
                    <p class="card-text text-price">ราคา 40 บาท</p>
                    <div class="input-group mb-3">
                      <button class="btn btn-incress" type="button">+</button>
                      <input type="number" class="form-control text-center" value="1">
                      <button class="btn btn-decress" type="button">-</button>
                  </div>
                  <a href="#" class="btn btn-add">เพิ่ม</a>
                  </div>
                </div>
              </div>
        </div>
    </div>

    <script>
        const incrementBtn = document.querySelector('.btn-incress');
        const decrementBtn = document.querySelector('.btn-decress');
        const inputNumber = document.querySelector('input[type="number"]');

        incrementBtn.addEventListener('click', () => {
            inputNumber.value = parseInt(inputNumber.value) + 1;
        });

        decrementBtn.addEventListener('click', () => {
            if (parseInt(inputNumber.value) > 1) {
                inputNumber.value = parseInt(inputNumber.value) - 1;
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa"
        crossorigin="anonymous"></script>
</body>

</html>