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
    <link rel="stylesheet" href="../../css/register.css" />
  </head>
  <body>
    <!-- Content -->
    <div class="container-fluid register-box">
      <div class="register-container">
        <div class="register-left-box">
          <h2 class="text-center">สมัครสมาชิก</h2>
          <h2 class="text-center">สำหรับร้านค้า</h2>
        </div>
        <div class="register-right-box">
          <form action="../../service/member.php" method="post">
            <div class="mb-3">
              <label for="username" class="form-label">ชื่อผู้ใช้งาน</label>
              <input
                type="text"
                class="form-control"
                id="username"
                name="username"
                placeholder="กรอกชื่อผู้ใช้งาน"
              />
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">รหัสผ่าน</label>
              <input
                type="password"
                class="form-control"
                id="password"
                name="password"
                placeholder="กรอกรหัสผ่าน"
              />
            </div>
            <div class="mb-3">
              <label for="c_password" class="form-label">ยืนยันรหัสผ่านอีกครั้ง</label>
              <input
                type="password"
                class="form-control"
                id="c_password"
                name="c_password"
                placeholder="กรอกรหัสผ่านอีกครั้ง"
              />
            </div>
            <div class="mb-3">
              <label for="firstname" class="form-label">ชื่อ</label>
              <input
                type="text"
                class="form-control"
                id="firstname"
                name="firstname"
                placeholder="กรอกชื่อ"
              />
            </div>
            <div class="mb-3">
              <label for="lastname" class="form-label">นามสกุล</label>
              <input
                type="text"
                class="form-control"
                id="lastname"
                name="lastname"
                placeholder="กรอกนามสกุล"
              />
            </div>
            <div class="mb-3">
              <label for="phonenumber" class="form-label">เบอร์โทรศัพท์</label>
              <input
                type="text"
                class="form-control"
                id="phonenumber"
                name="phonenumber"
                placeholder="กรอกเบอร์โทรศัพท์"
              />
            <div class="text-center mt-4">
              <button type="submit" name="login" class="btn btn-login">สมัครเข้าใช้งาน</button>
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
