<?php
session_start();
require_once '../config/conn_db.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
}


if (isset($_POST['submit'])) {
    $tablenumber = $_POST['tablenumber'];
    $tablename = $_POST['tablename'];

    // Insert data into tables table
    $insertsql = "INSERT INTO tables (table_number, table_name, member_ID) VALUES (:table_number, :table_name, :member_ID)";
    $stmt = $conn->prepare($insertsql);
    $stmt->bindParam(":table_number", $tablenumber);
    $stmt->bindParam(":table_name", $tablename);
    $stmt->bindParam(":member_ID", $_SESSION['store_id']);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Table has been added successfully";
        header("Location: ../Page/table/table.php");
    } else {
        $_SESSION['error'] = "Failed to add table";
        header("Location: ../Page/table/table.php");
    }
}
?>
