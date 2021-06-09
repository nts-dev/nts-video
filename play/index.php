<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


header("Access-Control-Allow-Origin: *");
//    header('Access-Control-Allow-Credentials: true');
//    header('Access-Control-Max-Age: 86400');    // cache for 1 day

include('../../auth.php');
include('../api/session/Commons.php');


$ROOT = WEBURL . \Boot::WWWROOT . "/nts-video-api/";
$id = $_GET['id'];


$bootstrap = App::getInstance();


$session = $bootstrap::startSessionIfNotAvailable(
    20196, '1kenan');

$mediaService = new MediaService($session);

$resultArray = $mediaService->findByHashing(trim($id));

//echo "<pre>";
//print_r($resultArray);
//exit;

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Player</title>
    <?php
    CSSPackage::BOOTSTRAP();
    ?>

    <style>
        html, body {
            height: 100%
        }

        .video {
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>


<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <video
                id="my-video"
                class="video-js video"
                controls
                preload="auto"
                poster="<?= $resultArray->thumbnailLink ?>"
                data-setup="{}">
            <source src="<?= $resultArray->videoLink_raw ?>" type="video/mp4">
            <source src="<?= $resultArray->webm ?>" type="video/webm">

        </video>
    </div>
</div>

</body>
</html>