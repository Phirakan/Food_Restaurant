<?php
$servername = "66.45.227.43:3306";
$username = "relaxlik_foodrestaurant";
$password = "foodrestaurant"; //ไม่ได้ตั้งรหัสผ่านก็ลบ  yourpassword ออก

// Database name
$dbname = "relaxlik_food _restaurant";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // set the character set to utf8mb4
  $conn->exec("SET NAMES utf8mb4");
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
//Set ว/ด/ป เวลา ให้เป็นของประเทศไทย
    date_default_timezone_set('Asia/Bangkok');