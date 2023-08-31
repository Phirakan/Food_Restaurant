<?php
session_start();

if (isset($_GET['tableNumberSelect'])) {
    $_SESSION['tableSelectOrder'] = $_GET['tableNumberSelect'];
    // echo $_SESSION['tableSelectOrder'];
    header('Location: ../../page/cart/cart.php'); // Redirect back to your original page
}
?>
