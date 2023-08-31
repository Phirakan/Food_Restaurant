<?php

session_start();
require_once '../../config/conn_db.php';

if (isset($_POST['orderButton'])) {
    if (!empty($_SESSION['cart'])) {
        if (!empty($_SESSION['tableSelectOrder'])) {
            // my table ordermenu
            // order_ID (AUTO_INCREMENT) ,order_date (NOW(date only no time)), order_name (foodname), quantity, finish_order (currently not use), table_ID (FK), member_ID (FK) 
            // because order more one item and before page to save in session array so we need to loop to insert each item in session array to database
            $sql = "INSERT INTO ordermenu (order_date, order_name, quantity, table_ID, member_ID) VALUES (NOW(), :order_name, :quantity, :table_ID, :member_ID)";

            foreach ($_SESSION['cart'] as $item) {
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":order_name", $item['foodname']);
                $stmt->bindParam(":quantity", $item['quantity']);
                $stmt->bindParam(":table_ID", $_SESSION['tableSelectOrder']);
                $stmt->bindParam(":member_ID", $_SESSION['store_id_customer']);
                $stmt->execute();
            }

            $_SESSION['orderSuccess'] = "สั่งอาหารสำเร็จ";
            header("Location: ../../page/cart/complete-order.php");
        } else {
            $_SESSION['orderFail'] = "ไม่สามารถสั่งอาหารได้ โปรดเลือกโต๊ะ";
            // echo "session table empty";
            header("Location: ../../page/cart/cart.php");
        }
    } else {
        $_SESSION['orderFail'] = "ไม่สามารถสั่งอาหารได้ โปรดเลือกอาหาร";
        // echo "session cart empty";
        header("Location: ../../page/cart/cart.php");
    }
} else {
    $_SESSION['orderFail'] = "ไม่สามารถสั่งอาหารได้ Not submit";
    // echo "not submit";
    // header("Location: ../../page/cart/cart.php");
}
?>