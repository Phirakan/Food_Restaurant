<?php 

    session_start();
    require_once '../config/conn_db.php'; // Added semicolon at the end

    if (isset($_POST['submit'])) {
        $foodname = $_POST['foodname'];
        $price = $_POST['price'];
        $img = $_FILES['img'];
        $storeid = $_SESSION['store_id'];

        $allow = array('jpg', 'jpeg', 'png');
        $extension = explode(".", $img['name']);
        $fileActExt = strtolower(end($extension));
        $fileNew = rand() . "." . $fileActExt;
        $filePath = "../upload/" . $fileNew;

        if  (in_array($fileActExt, $allow)){
            if ($img['size'] > 0 && $img['error'] == 0){
                if (move_uploaded_file($img['tmp_name'], $filePath)){
                   $sql = $conn->prepare("INSERT INTO food (foodname, price, img,member_ID) VALUES (:foodname, :price, :img,:storeid)");
                   $sql->bindParam(":foodname", $foodname);
                   $sql->bindParam(":price", $price);
                   $sql->bindParam(":img", $fileNew);
                   $sql->bindParam(":storeid", $storeid);
                   $sql->execute();

                   if ($sql) {
                    $_SEESION['success'] = "Add menu successfully";
                    header("location: ../Page/menu.php");
                   }else{
                    $_SEESION['error'] = "Something went wrong";
                    header("location: ../Page/menu.php");
                   }
                } 
                
            }
        }
    }

?>