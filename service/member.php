<?php 

    session_start();
    require_once('../config/conn_db.php');

    if (isset($_POST['login'])) {

        // Vaariable
        $username = $_POST['username'];
        $password = $_POST['password'];

      
        if (empty($username)) {
            $_SESSION['error'] = 'กรุณากรอกชื่อผู้ใช้งาน';
            header("Location: ../Page/login.php");
        } else if (empty($password)) {
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            header("Location: ../Page/login.php");
        } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 8) {
            $_SESSION['error'] = "กรุณากรอกรหัสผ่าน 8-20 ตัวอักษร";
            header("Location: ../Page/login.php");
        } else {
            try {

                $check_data = $conn->prepare("SELECT * FROM member WHERE Username = :Username");
                $check_data->bindParam(':Username', $username);
                $check_data->execute();
                $row = $check_data->fetch(PDO::FETCH_ASSOC);

                if ($check_data->rowCount() > 0) {

                    if ($username == $row['Username']) {
                        if (password_verify($password, $row['Password'])) {
                            $_SESSION['User_ID'] = $row['User_ID'];
                            $_SESSION['Username'] = $row['Username'];
                            $_SESSION['success'] = 'เข้าสู่ระบบสำเร็จ';
                            header("Location: ../../page/course/index.php");
                        } else {
                            $_SESSION['error'] = 'รหัสผ่านผิด';
                            header("Location: ../Page/login.php");
                        }
                    } else {
                        $_SESSION['error'] = 'ไม่มีชื่อผู้ใช้งานนี้ในระบบ';
                        header("Location: ../Page/login.php");
                    }
                } else {
                    $_SESSION['error'] = "ไม่มีข้อมูลในระบบ";
                    header("Location: ../Page/login.php);
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
