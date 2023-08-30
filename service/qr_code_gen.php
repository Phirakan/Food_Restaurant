<?php
// โค้ดไฟล์ dbconnect.php ดูได้ที่ http://niik.in/que_2398_5642
// require_once("../dbconnect.php"); // กำหนด path ให้ถูกต้อง
 
// include composer autoload
session_start();
require_once '../vendor/autoload.php';  // กำหนด path ให้ถูกต้อง
require_once '../config/conn_db.php'; // กำหนด path ให้ถูกต้อง

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
// use Endroid\QrCode\Writer\ValidationException;

// get data from database table
$sql = "SELECT * FROM `qrcode` WHERE member_ID = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $_SESSION['store_id']);
$stmt->execute();
$resultQR = $stmt->fetch(PDO::FETCH_ASSOC);

$writer = new PngWriter();

// get url for localhost
$url = $_SERVER['HTTP_HOST'];
$urlcombine = $url . "/order-menu.php?restaurant=" . $_SESSION['store_id'];

// Create QR code
$qrCode = QrCode::create($urlcombine)
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
    ->setSize(300)
    ->setMargin(10)
    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
    ->setForegroundColor(new Color(0, 0, 0))
    ->setBackgroundColor(new Color(255, 255, 255));

// Create generic logo
$logo = Logo::create('../assets/logo.png')
    ->setResizeToWidth(50)
    ->setPunchoutBackground(true)
;

// Create generic label supporting UTF-8 to replace the default label
// $label = Label::create('อร่อยใกล้เคียง')
//     ->setTextColor(new Color(255, 0, 0));

$result = $writer->write($qrCode, $logo, null);

// Directly output the QR code
// header('Content-Type: '.$result->getMimeType());
// echo $result->getString();

$filename = $_SESSION['username'].'.png';



// Save it to a file
$result->saveToFile('../upload/qrcode/'.$filename);


// Validate the result
// $writer->validateResult($result, 'Life is too short to be generating QR codes');
// and to insert into database table and update filename of QR code and if exist data to update data in database table using pdo
if(empty($resultQR)){
    // insert data to database table
    $sql = "INSERT INTO `qrcode`(`qrcode_img`,`member_ID` ) VALUES (:filename,:id )";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':filename', $filename);
    $stmt->bindParam(':id', $_SESSION['store_id']);
    $stmt->execute();
    // redirect to page
    header("Location: ../../../page/menu.php");
}else{
    // update data to database table
    $sql = "UPDATE `qrcode` SET `qrcode_img`=:filename WHERE member_ID = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':filename', $filename);
    $stmt->bindParam(':id', $_SESSION['store_id']);
    $stmt->execute();
    header("Location: ../../../page/menu.php");

}

?>

