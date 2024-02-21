<?php
require 'vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\Writer\PngWriter;

function SavePng()
{
    $short_url = $_POST["short_url"];
    $result = Builder::create()
        ->writer(new PngWriter())
        ->writerOptions([])
        ->data($short_url)
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

function GenerarURL()
{
    file_put_contents('urls.json', '');
    $urls = file_get_contents('urls.json');
    $urls = json_decode($urls, true);
    $random = substr(sha1(microtime()), 0, 9);
    if (!isset($urls[$random])) {
        $urls[$random] = $_POST['short_url'];
    }
    file_put_contents('urls.json', json_encode($urls));
    echo "<p>la nueva url es: <a href='/url.php?short_url=$random' target='_blank'>localhost/url.php?short_url=$random<a></p>";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['short_url']) && empty($_POST['short_url'] == false)) {
        $url = $_POST['short_url'];
        $url = filter_var($url, FILTER_SANITIZE_URL);
        // Validate url
        if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
            GenerarURL();
            SavePng();
            echo("<img src='qrcode.png' alt='QR-Generado'>");
        } else {
            echo("<h1>Esta URL no es valida</h1>");
        }
    }
}


