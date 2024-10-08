<?php 
  session_start();
  require_once '../../config/conn_db.php'; // Added semicolon

  if (isset($user)) {  
    $_SESSION['username'] = $user['username'];
    header('Location: ../page/menu.php');  
    exit;
}
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
    <link rel="stylesheet" href="../../css/index.css" />
    <link rel="stylesheet" href="../../css/login.css" />
  </head>
  <body>
    <!-- Content -->
    <div class="container-fluid login-box">
      <div class="login-container">
        <div class="login-left-box">
          <h2 class="text-center">ลงชื่อเข้าใช้</h2>
          <h2 class="text-center">สำหรับร้านค้า</h2>
        </div>
        <div class="login-right-box">

          <form action="../../service/member.php" method="post">
            <div class="mb-3">
              <!-- <label for="username" class="form-label text-username">ชื่อผู้ใช้งาน</label> -->
              <input
                type="text"
                class="form-control"
                id="username"
                name="username"
                placeholder="กรอกชื่อผู้ใช้งาน"
              />
            </div>
            <div class="mb-3">
              <!-- <label for="password" class="form-label">รหัสผ่าน</label> -->
              <input
                type="password"
                class="form-control"
                id="password"
                name="password"
                placeholder="กรอกรหัสผ่าน"
              />
            </div>
            <div class="text-center">
              <button type="submit" name="login" class="btn btn-login">ลงชื่อเข้าใช้</button>
            </div>
          </form>
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
