<?php 

    session_start();
    require_once '../config/conn_db.php';

    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $c_password = $_POST['c_password'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $phonenumber = $_POST['phonenumber'];
        $user_id = $_POST['User_ID'];

        if (empty($username)) {
            $_SESSION['error'] = 'please enter your username';
            header("location: ../Page/authentication/register.php");
        } else if (empty($password)) {
            $_SESSION['error'] = 'please enter your password';
            header("location: ../Page/authentication/register.php");
        } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 8) {
            $_SESSION['error'] = 'your password has been 8-20 word';
            header("location: ../Page/authentication/register.php");
        } else if (empty($c_password)) {
            $_SESSION['error'] = 'please confirm your password';
            header("location: ../Page/authentication/register.php");
        } else if (empty($firstname)) {
            $_SESSION['error'] = 'please enter your firstname';
            header("location: ../Page/authentication/register.php");
        } else if (empty($lastname)) {
            $_SESSION['error'] = 'please enter your lastname';
            header("location: ../Page/authentication/register.php");
        } else if (empty($phonenumber)) {
            $_SESSION['error'] = 'please enter your phonenumber';
            header("location: ../Page/authentication/register.php");
        } else if ($password != $c_password){
            $_SESSION['error'] = 'your password is not match';
            header("location: ../Page/authentication/register.php");
        } else {
            try {

                $check_email = $conn->prepare("SELECT User_ID FROM member WHERE User_ID = :User_ID");
                $check_email->bindParam(":username", $username);
                $check_email->execute();
                $row = $check_email->fetch(PDO::FETCH_ASSOC);

                if ($row['username'] == $username) {
                    $_SESSION['warning'] = "มี username นี้อยู่ในระบบแล้ว <a href='../Page/authentication/login.php'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
                    header("../Page/authentication/login.php");
                } else if (!isset($_SESSION['error'])) {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO member(firstname, lastname, username, password, phonenumber, User_ID) 
                                            VALUES(:firstname, :lastname, :username, :password, :phonenumber, :User_ID)");
                    $stmt->bindParam(":firstname", $firstname);
                    $stmt->bindParam(":lastname", $lastname);
                    $stmt->bindParam(":username", $username);
                    $stmt->bindParam(":phonenumber", $phonenumber);
                    $stmt->bindParam(":password", $passwordHash);
                    $stmt->bindParam(":User_ID", $user_id);
                    
                    $stmt->execute();
                    $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว! <a href='../Page/authentication/login.php' class='alert-link'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
                    header("location: ../Page/authentication/login.php");
                } else {
                    $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                    header("location: ../index.php");
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }


?>