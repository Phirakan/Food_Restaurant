<?php 
  session_start();
 

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- favico -->
    <link rel="icon" href="assets/logo.png" type="image/x-icon" />
    <title>อร่อยใกล้เคียง</title>

    <!-- Bootstrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9"
      crossorigin="anonymous"
    />
    <!-- CSS -->
    <link rel="stylesheet" href="css/index.css">


  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbarcustom">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.php">
            <img src="assets/logo.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-top" />
            <span class="textbrand">อร่อยใกล้เคียง</span>
          </a>
    
          <!-- Add the hamburger menu button -->
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
    
          <!-- Menu Right side -->
          <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav menunavbar">
              <li class="nav-item">
                <a href="/Page/order-menu.php" class="btn btn-order-atnav">สั่งอาหาร</a>
              </li>
              <li class="nav-item">
                <a href="page/authentication/" class="btn btn-store-atnav">ร้านค้า</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    
    <!-- Navbar -->

    <!-- Content -->
    <div class="container-fluid content-box">
        <div class="col-md-6 col-12 left-box">
          <div class="text-left">
            <h1 class="text-header">อร่อยใกล้เคียง </h1>
            <p class="text-description">แพลตฟอร์มสั่งอาหารออนไลน์ ที่จะช่วยให้คุณสามารถสั่งอาหารจากร้านค้าใกล้เคียง และรับประทานอาหารได้ที่บ้าน หรือที่ไหนก็ได้ อย่างง่ายดาย</p>
            <a href="Page/order-menu.php" class="btn btn-order">สั่งอาหาร</a>
          </div>
        </div>
        <div class="col-md-6 col-12 right-box">
          <div class="text-center">
            <img src="assets/food1x.png" alt="food" class="img-fluid img-food">
          </div>
        </div>
      
    </div>
    



    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
      integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
