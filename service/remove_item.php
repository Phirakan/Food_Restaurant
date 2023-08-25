<?php
session_start();
if (isset($_GET['foodname'])) {
    $foodname = $_GET['foodname'];

    foreach ($_SESSION['cart'] as $index => $item) {
        if ($item['foodname'] == $foodname) {
            unset($_SESSION['cart'][$index]);
            echo 'Item removed!';
            return;
        }
    }
    echo 'Item not found!';
} else {
    echo 'Error!';
}
?>
