<?php 

    session_start();
    require_once '../config/conn_db.php'; // Added semicolon at the end

    if (isset($_POST['submit'])) {
        $table_number = $_POST['table_number'];
        $img = $_FILES['img'];

        $allow = array('jpg', 'jpeg', 'png');
        $extension = explode(".", $img['name']);
        $fileActExt = strtolower(end($extension));
        $fileNew = rand() . "." . $fileActExt;
        $filePath = "../upload/" . $fileNew;

        if  (in_array($fileActExt, $allow)){
            if ($img['size'] > 0 && $img['error'] == 0){
                if (move_uploaded_file($img['tmp_name'], $filePath)){
                   $sql = $conn->prepare("INSERT INTO tables (table_number,  img) VALUES (:table_number,  :img)");
                   $sql->bindParam(":table_number", $table_number);
                   $sql->bindParam(":img", $fileNew);
                   $sql->execute();

                   if ($sql) {
                    $_SEESION['success'] = "Add menu successfully";
                    header("location: ../Page/qrcode_gen.php");
                   }else{
                    $_SEESION['error'] = "Something went wrong";
                    header("location: ../Page/qrcode_gen.php");
                   }
                } 
                
            }
        }
    }

?>