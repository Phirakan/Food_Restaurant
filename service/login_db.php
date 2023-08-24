<?php 

    session_start();
    require_once '../config/conn_db.php';


    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
       


        if (empty($username)) {
            $_SESSION['error'] = "Username is required";    
            header("Location: ../index.php");
        } else if (empty($password)) {
            $_SESSION['error'] = "Password is required";    
            header("Location: ../index.php");
        }else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
            $_SESSION['error'] = "Password is required 5 to 20 characters";    
            header("Location: ../index.php");
        } else {
            try {
                $check_data = $conn->prepare("SELECT * FROM member WHERE username = :username");
                $check_data->bindParam(":username", $username);
                $check_data->execute();
                $row = $check_data->fetch(PDO::FETCH_ASSOC);

                if ($check_data->rowCount() > 0) {

                    if ($username ==  $row['username'])  {
                        if (password_verify($password, $row['password'])){
                            header("Location: ../index.php");
                        }
                    } else {
                        $_SEESION['error'] = "Username or Password is incorrect";
                        header("Location: ../index.php");
                    }

                    

                } else {
                    $_SEESION['error'] = "No data found <a href='register.php'>Register</a>";
                    header("Location: ../index.php");
                }

            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
?>