<?php
$id = $_GET['id'];
$command = "cd C:\Program Files\Mozilla Firefox && Firefox -foreground -new-window http://localhost/nts-programs/nts-video/play/player.php?id=$id";
shell_exec($command);

exit;

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


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Player</title>

    <?php
    CSSPackage::BOOTSTRAP();
    ?>
    <!--    <link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet" />-->

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

        <!--        <video-->
        <!--                id="my-video"-->
        <!--                class="video-js"-->
        <!--                controls-->
        <!--                preload="auto"-->
        <!--                width="640"-->
        <!--                height="264"-->
        <!--                poster="MY_VIDEO_POSTER.jpg"-->
        <!--                data-setup="{}"-->
        <!--        >-->
        <!--            <source src="--><?php //echo $resultArray->videoLink_raw; ?><!--" type="video/mp4" />-->
        <!--            <p class="vjs-no-js">-->
        <!--                To view this video please enable JavaScript, and consider upgrading to a-->
        <!--                web browser that-->
        <!--                <a href="https://videojs.com/html5-video-support/" target="_blank"-->
        <!--                >supports HTML5 video</a-->
        <!--                >-->
        <!--            </p>-->
        <!--        </video>-->


        <!--        <video-->
        <!--                id="my-video"-->
        <!--                class="video-js video"-->
        <!--                controls-->
        <!--                preload="auto"-->
        <!--                data-setup="{}">-->
        <!--            <source src="--><?php //echo $resultArray->videoLink_raw; ?><!--" type="video/mp4">-->
        <!---->
        <!--        </video>-->
    </div>
</div>
<!--<script src="https://vjs.zencdn.net/7.11.4/video.min.js"></script>-->
</body>
</html>