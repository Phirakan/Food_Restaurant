<?php 

    session_start();
    require_once ('../../config/conn_db.php');



    if (isset($_POST['update'])) {
        $id = $_POST['ID'];
        $foodname = $_POST['foodname'];
        $price = $_POST['price'];
    
        $img = $_FILES['img'];
    
        $img2 = $_POST['img2'];
        $upload = $_FILES['img']['name'];
    
        if ($upload != '') {
            $allow = array('jpg', 'jpeg', 'png');
            $extension = explode('.', $img['name']);
            $fileActExt = strtolower(end($extension));
            $fileNew = rand() . "." . $fileActExt; // rand function create the rand number 
            $filePath = '../upload/' . $fileNew;
    
            if (in_array($fileActExt, $allow)) {
                if ($img['size'] > 0 && $img['error'] == 0) {
                    move_uploaded_file($img['tmp_name'], $filePath);
                }
            }
        } else {
            $fileNew = $img2;
        }
    
        $sql = $conn->prepare("UPDATE food SET foodname = :foodname, price = :price, quantity = :quantity, img = :img WHERE food_ID = :ID");
        $sql->bindParam(":foodname", $foodname);
        $sql->bindParam(":price", $price);
        $sql->bindParam(":img", $fileNew);
        $sql->bindParam(":quantity", $quantity);
        $sql->bindParam(":ID", $id);
        $sql->execute();
    
        if ($sql) {
            $_SESSION['success'] = "updated successfully";
            // echo "Update successfully";
            header("location: ../../page/menu.php");
        } else {
            $_SESSION['error'] = "Data has not been updated successfully";
            // echo "Data has not been updated successfully";
            header("location: ../../page/menu.php");
        }
    }



?>