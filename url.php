<?php
if (isset($_GET['short_url'])) {
    $url = file_get_contents('urls.json');
    $url = json_decode($url, true);
    if (isset($url[$_GET['short_url']])) {
        $url = "{$url[$_GET['short_url']]}";
        header("Location:{$url}");
    } else {
        header("Location: index.php");
    }
} else {
    die('ERROR: NO SE ENCUENTRAN LOS PARRAMETROS REQUERIDOS');
}

