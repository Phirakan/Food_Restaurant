<?php
// โค้ดไฟล์ dbconnect.php ดูได้ที่ http://niik.in/que_2398_5642
// require_once("../dbconnect.php"); // กำหนด path ให้ถูกต้อง
 
// include composer autoload
require_once '../vendor/autoload.php';  // กำหนด path ให้ถูกต้อง

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
// use Endroid\QrCode\Writer\ValidationException;

$writer = new PngWriter();

// Create QR code
$qrCode = QrCode::create('https://www.youtube.com/watch?v=dQw4w9WgXcQ')
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
header('Content-Type: '.$result->getMimeType());
echo $result->getString();

// Save it to a file
$result->saveToFile('../assets/qrcode.png');


// Validate the result
// $writer->validateResult($result, 'Life is too short to be generating QR codes');

?>

