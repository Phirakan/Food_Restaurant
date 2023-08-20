<?php 

    session_start();
    require_once '../config/conn_db.php'

    if (isset($POST['register'])) {
        $username =_POST['username'];
        $password =_POST['password'];
        $c_password =_POST['c_password'];
        $firstname =_POST['firstname'];
        $lastname =_POST['lastname'];
        $phonenumber =_POST['phonenumber'];
        
        if (empty($username)) {
        $_SESSION['error'] = 'please enter your username';
        header("location: register.php");
    } else if (empty($password)) {
        $_SESSION['error'] = 'please enter your password';
        header("location: register.php");
    } else if (str($_POST['password']) > 20 || strlen($_POST['password']) < 8 ) {
        $_SESSION['error'] = 'your password has been 8-20 word';
        header("location: register.php");
    } else if (empty(c_$password)) {
        $_SESSION['error'] = 'please confirm your password';
        header("location: register.php");
    } else if (empty($firstname)) {
        $_SESSION['error'] = 'please enter your firstname';
        header("location: register.php");
    } else if (empty($lastname)) {
        $_SESSION['error'] = 'please enter your lastname';
        header("location: register.php");
    } else if (empty($phonenumber)) {
        $_SESSION['error'] = 'please enter your phonenumber';
        header("location: register.php");
    } else if ($password != $c_password){
        $_SESSION['error'] = 'your password is not match';
        header("location: register.php");
    } else {
        try {

            $check_username = $conn->prepare("SELECT username FROM member WHERE Username  = :Username")
            $check_username->bindParam(":Username", $email);
            $check_username->execute->fetch(PDO::FETCH_ASSOC);

            if ($row['username'] ==$username) {
                $_SESSION['warning'] = "This username already exists in the system. <a href='login.php'>click here</a> to login"
                header("location: login.php");

            }

        } catch(PDOException $e) {
            echo $e->getMessage
        }
    }
}
   

   
?>