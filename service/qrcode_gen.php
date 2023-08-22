<?php

session_start();
require_once '../config/conn_db.php'; // Added semicolon at the end 

require_once '../include/qr-code/src/QrCode.php';
require_once '../include/qr-code/src/QrCodeInterface.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;
use Endroid\QrCode\Writer\SvgWriter;

$writer = new PngWriter();

// Create QR code
$qrCode = QrCode::create('Life is too short to be generating QR codes')
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
    ->setSize(300)
    ->setMargin(10)
    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
    ->setForegroundColor(new Color(0, 0, 0))
    ->setBackgroundColor(new Color(255, 255, 255));


// // Create generic label
// $label = Label::create('Label')
//     ->setTextColor(new Color(255, 0, 0));

$result = $writer->write($qrCode);
// // Directly output the QR code
// header('Content-Type: '.$result->getMimeType());
// echo $result->getString();
header('Content-Type: ' . $qrCode->getContentType());
echo $qrCode->writeString();
?>
// Save it to a file
$result->saveToFile(__DIR__.'/qrcode.png');



// // รับหมายเลขโต๊ะจากคิวรี่ในฐานข้อมูล
// $tableNumber = isset($_GET['table']) ? intval($_GET['table']) : 0;

// // URL ไปยัง order-menu.php พร้อมกับพารามิเตอร์หมายเลขโต๊ะ
// $targetUrl = 'http://example.com/order-menu.php?table=' . $tableNumber;

// $qrCode = new QrCode($targetUrl);
// $qrCode->setSize(300);

// header('Content-Type: image/png');
// $result = $writer->write($qrCode, $logo, $label);

?>
