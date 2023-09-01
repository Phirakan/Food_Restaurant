<?php
session_start();
require_once '../../config/conn_db.php';

if (isset($_POST['update'])) {
    $id = $_POST['ID'];
    $foodname = $_POST['foodname'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    
    $img = $_FILES['img'];
    $img2 = $_POST['img2'];
    
    // Check if a new image file has been uploaded
    if ($_FILES['img']['size'] > 0 && $_FILES['img']['error'] == 0) {
        $allow = array('jpg', 'jpeg', 'png');
        $extension = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION); // Get the file extension
        $fileNew = $_FILES['img']['name']; // Use the original file name
        $filePath = '../../upload/' . $fileNew;
        
        // Check if the uploaded file extension is allowed
        if (in_array(strtolower($extension), $allow)) {
            if (move_uploaded_file($_FILES['img']['tmp_name'], $filePath)) {
                // File uploaded successfully
            } else {
                $_SESSION['error'] = "Error uploading the file.";
                header("location: ../../page/menu.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Invalid file type. Please upload a JPG, JPEG, or PNG image.";
            header("location: ../../page/menu.php");
            exit();
        }
    } else {
        // If no new image uploaded, use the existing image path
        $fileNew = $img2;
    }

    // Update the food item in the database
    $sql = $conn->prepare("UPDATE food SET foodname = :foodname, price = :price, quantity = :quantity, img = :img WHERE food_ID = :ID");
    $sql->bindParam(":foodname", $foodname);
    $sql->bindParam(":price", $price);
    $sql->bindParam(":img", $fileNew);
    $sql->bindParam(":quantity", $quantity);
    $sql->bindParam(":ID", $id);
    $result = $sql->execute();
    
    if ($result) {
        $_SESSION['success'] = "Updated successfully";
        header("location: ../../page/menu.php");
    } else {
        $_SESSION['error'] = "Data has not been updated successfully";
        header("location: ../../page/menu.php");
    }
}
?>
