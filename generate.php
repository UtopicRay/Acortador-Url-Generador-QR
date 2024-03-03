<?php
require 'vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\Writer\PngWriter;

function SavePng($x)
{
    $newURL = "192.168.173.139/url.php?short_url=$x";
    $result = Builder::create()
        ->writer(new PngWriter())
        ->writerOptions([])
        ->data($newURL)
        ->errorCorrectionLevel(ErrorCorrectionLevel::High)
        ->size(300)
        ->margin(10)
        ->labelText('NUEVA-URL')
        ->labelFont(new NotoSans(16))
        ->labelAlignment(LabelAlignment::Center)
        ->validateResult(false)
        ->build();

    $result->saveToFile(__DIR__ . '/qrcode.png');
}

function validateUrl($url)
{

//first we validate the url using a regex

    if (!preg_match('%^(?:(?:https?)://)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]-*)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]-*)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,}))\.?)(?::\d{2,5})?(?:[/?#]\S*)?$%uiS', $url)) {

        return false;
    }


//if the url is valid, we "curl it" and expect to get a 200 header response in order to validate it.

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
    curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body (faster)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // we follow redirections
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);


    if ($httpcode == "200") {
        return true;
    } else {
        return false;
    }


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
    return $random;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['short_url']) && empty($_POST['short_url'] == false)) {
        $url = $_POST['short_url'];
// Validate url
        if (validateUrl($url)) {
            $random = GenerarURL();
            SavePng($random);
            echo("<p>la nueva url es: <a href='/url.php?short_url=$random' target='_blank'>localhost/url.php?short_url=$random<a></p>
    <img src='qrcode.png' alt='QR-Generado'>");
        } else {
            echo("<h1>Esta URL no es valida</h1>");
        }
    }
}


