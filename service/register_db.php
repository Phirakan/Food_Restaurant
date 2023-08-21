<?php 

    session_start();
    require_once '../config/conn_db.php'; // Added semicolon at the end

    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $c_password = $_POST['c_password'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $phonenumber = $_POST['phonenumber'];
        
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
                $check_username = $conn->prepare("SELECT username FROM member WHERE username = :Username"); // Added semicolon
                $check_username->bindParam(":Username", $username);
                $check_username->execute();
                $row = $check_username->fetch(PDO::FETCH_ASSOC);

                if ($row['username'] == $username) {
                    $_SESSION['warning'] = "This username already exists in the system. <a href='../Page/authentication/login.php'>click here</a> to login";
                    header("location: ../Page/authentication/login.php");
                } else if (!isset($_SESSION['error'])) {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO member(username, password, firstname, lastname, phonenumber) VALUES (:username, :password, :firstname, :lastname, :phonenumber)");
                    $stmt->bindParam(":username", $username);
                    $stmt->bindParam(":password", $passwordHash);
                    $stmt->bindParam(":firstname", $firstname);
                    $stmt->bindParam(":lastname", $lastname);
                    $stmt->bindParam(":phonenumber", $phonenumber);
                    $stmt->execute(); // Fixed typo
                    $_SESSION['success'] = "Sign up successfully!!! <a href='../Page/authentication/login.php' class'alert-link'>click here</a> to login";
                    header("location:../index.php");
                } else {
                    $_SESSION['error'] = "Something went wrong."; 
                    header("location:../index.php");
                }
            } catch(PDOException $e) {
                echo $e->getMessage(); // Added parentheses
            }
        }
       
    }

?>
