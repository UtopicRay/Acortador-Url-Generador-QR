<?php
require 'vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\Writer\PngWriter;

function SavePng()
{
    $acortador = $_POST["acortador"];
    $urls = file_get_contents('urls.json');
    $urls = json_decode($urls);
    $random = substr(sha1(microtime()), 0, 9);
    if (!isset($urls[$random])) {
        $urls[$random] = $_POST['acortador'];
    }
    file_put_contents('urls.json', json_encode($urls));

    $result = Builder::create()
        ->writer(new PngWriter())
        ->writerOptions([])
        ->data($acortador)
        ->errorCorrectionLevel(ErrorCorrectionLevel::High)
        ->size(300)
        ->margin(10)
        ->labelText('URL-Acortada')
        ->labelFont(new NotoSans(20))
        ->labelAlignment(LabelAlignment::Center)
        ->validateResult(false)
        ->build();

    $result->saveToFile(__DIR__ . '/qrcode.png');
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['acortador']) == true && empty($_POST['acortador'] == false)) {
        $url = $_POST['acortador'];
        $url = filter_var($url, FILTER_SANITIZE_URL);
        // Validate url
        if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
            SavePng();
            echo("<img src='qrcode.png' alt='QR-Generado'>");
        } else {
            echo("<h1>Esta URL no es valida</h1>");
        }
    }
}


