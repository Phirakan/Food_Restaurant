<?php

session_start();
require_once('../config/conn_db.php');
if (isset($user)) {  
    $_SESSION['username'] = $user['username'];
    header('Location: ../menu.php');  
    exit;
}

if (isset($_POST['login'])) {


    // Vaariable
    $username = $_POST['username'];
    $password = $_POST['password'];


    if (empty($username)) {
        $_SESSION['error'] = 'กรุณากรอกชื่อผู้ใช้งาน';
        header("Location: ../Page/authentication/login.php");
    } else if (empty($password)) {
        $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
        header("Location: ../Page/authentication/login.php");
    } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 8) {
        $_SESSION['error'] = "กรุณากรอกรหัสผ่าน 8-20 ตัวอักษร";
        header("Location: ../Page/authentication/login.php");
    } else {
        try {

            $check_data = $conn->prepare("SELECT * FROM member WHERE username = :username");
            $check_data->bindParam(':username', $username);
            $check_data->execute();
            $row = $check_data->fetch(PDO::FETCH_ASSOC);

            if ($check_data->rowCount() > 0) {
                if ($username == $row['username']) {
                    if (password_verify($password, $row['password'])) {
                       
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['success'] = 'เข้าสู่ระบบสำเร็จ';
                        header("Location: ../index.php");
                    } else {
                        $_SESSION['error'] = 'รหัสผ่านผิด';
                        header("Location: ../Page/authentication/login.php");
                    }
                } else {
                    $_SESSION['error'] = 'ไม่มีชื่อผู้ใช้งานนี้ในระบบ';
                    header("Location: ../Page/authentication/login.php");
                }
            } else {
                $_SESSION['error'] = "ไม่มีข้อมูลในระบบ";
                header("Location: .../Page/authentication/login.php");
            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }


        // End of Else
    }



}


?>