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


        if (empty($username)) {
            $_SESSION['error'] = "Username is required";    
            header("Location: ../index.php");
        } else if (empty($password)) {
            $_SESSION['error'] = "Password is required";    
            header("Location: ../index.php");
        }else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
            $_SESSION['error'] = "Password is required 5 to 20 characters";    
            header("Location: ../index.php");
        }else if (empty($c_password)) {
            $_SESSION['error'] = "plase confirm password";    
            header("Location: ../index.php");
        } else if ($password != $c_password) {
            $_SESSION['error'] = "The two passwords do not match";    
            header("Location: ../index.php");

        }else if (empty($phonenumber)) {
            $_SESSION['error'] = "phonenumber is required";    
            header("Location: ../index.php");
        } else {
            try {
                $check_username = $conn->prepare("SELECT username FROM member WHERE username = :username");
                $check_username->bindParam(":username", $username);
                $check_username->execute();
                $row = $check_username->fetch(PDO::FETCH_ASSOC);

                if ($row['username'] == $username) {
                    $_SEESION['warning'] = "Username already exists <a href='../index.php'>Login</a>";
                    header("Location: ../index.php");
                } else if (!isset($_SESION['error'])) {
                    $password_hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO member (username, password, firstname, lastname, phonenumber) VALUES (:username, :password, :firstname, :lastname, :phonenumber)");

                    $stmt->bindParam(":username", $username);
                    $stmt->bindParam(":password", $password_hash);
                    $stmt->bindParam(":firstname", $firstname);
                    $stmt->bindParam(":lastname", $lastname);
                    $stmt->bindParam(":phonenumber", $phonenumber);
                    $stmt->execute();
                    $_SEESION['success'] = "Register successfully <a href='../index.php'>Login</a>";
                    header("Location: ../index.php");
                } else {
                    $_SEESION['error'] = "Something went wrong";
                    header("Location: ../index.php");
                }

            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
?>