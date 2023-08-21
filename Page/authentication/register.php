<?php 
  session_start();
  require_once '../../config/conn_db.php';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Register Page</title>

    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <link href="../../css/register.css" rel="stylesheet" />
  </head>
  <body>
    <div class="login-box">
      <form action="../../service/register_db.php" method="post">
        <h2>สมัครสมาชิก</h2>
        <div class="user-box">
          <input type="text" name="username" required="" />
          <label for="username">Username</label>
        </div>
        <div class="user-box">
          <input type="password" name="password" required="" />
          <label for="password">Password</label>
        </div>
        <div class="user-box">
          <input type="password" name="c_password" required="" />
          <label for="password">confirm Password</label>
        </div>
        <div class="user-box">
          <input type="text" name="firstname" required="" />
          <label for="firstname">First Name</label>
        </div>
        <div class="user-box">
          <input type="text" name="lastname" required="" />
          <label for="lastname">Last Name</label>
        </div>
        <div class="user-box">
          <input type="phonenumber" name="phonenumber" required="" />
          <label for="tel">Phone Number</label>
        </div>
        <div
          class="col-12 login-btm login-button justify-content-center d-flex"
        >
          <button
            type="submit"
            name="register"
            class="btn btn-outline-primary"
          >
            Register
          </button>
        </div>
        <div
          class="col-12 login-btm login-button justify-content-center d-flex"
        >
          <button
            type="submit"
            name="login_user"
            class="btn btn-outline-danger"
          >
            Cancle
          </button>
        </div>
      </form>
    </div>
  </body>
</html>
