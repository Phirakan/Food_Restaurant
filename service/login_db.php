<!-- <?php 
    // session_start();
    // require_once '../config/conn_db.php'; 

    // if (isset($_POST['login'])) {
    //     $username = $_POST['username'];
    //     $password = $_POST['password'];

    //     if (empty($username)) {
    //         $_SESSION['error'] = 'please enter your username';
    //     } else if (empty($password)) {
    //         $_SESSION['error'] = 'please enter your password';
    //     } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 8) {
    //         $_SESSION['error'] = 'your password has been 8-20 word';
    //     } else {
    //         try {
    //             $check_data = $conn->prepare("SELECT * FROM member WHERE username = :username");
    //             $check_data->bindParam(":username", $username);
    //             $check_data->execute();
    //             $row = $check_data->fetch(PDO::FETCH_ASSOC);

    //             if ($check_data->rowCount() > 0) {
    //                 if (password_verify($password, $row['password'])) {
    //                     $_SESSION['success'] = 'เข้าสู่ระบบสำเร็จ';
    //                     header("Location: ../index.php");
    //                     exit(); // Add exit here to stop further execution
    //                 } else {
    //                  // $_SESSION['error'] = 'รหัสผ่านผิด';
    //                 }
    //             } else {
    //                 $_SESSION['error'] = 'ไม่มีชื่อผู้ใช้งานนี้ในระบบ';
    //             }
    //         } catch(PDOException $e) {
    //             echo $e->getMessage();
    //         }
    //     }

    //     header("Location: ../Page/authentication/login.php"); // Redirect back to login page
    //     exit(); // Add exit here to stop further execution
    // }
?> -->
