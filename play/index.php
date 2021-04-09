<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


    header("Access-Control-Allow-Origin: *");
//    header('Access-Control-Allow-Credentials: true');
//    header('Access-Control-Max-Age: 86400');    // cache for 1 day


$ROOT = "http://". $_SERVER['HTTP_HOST']. "/nts-programs/nts-video";
$id = $_GET['id'];

include('../api/session/Commons.php');


$bootstrap = App::getInstance();


$session = $bootstrap::startSessionIfNotAvailable(
    20196, '1kenan');

$mediaService = new MediaService($session);

$resultArray = $mediaService->findById($id);



?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Player</title>
<!--    <link href="../lib/video-js/video-js.css" rel="stylesheet">-->
<!--    <link href="../lib/videojs-share/video-share.css" rel="stylesheet">-->
    <link href="../lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<style>
    html, body {height: 100%}
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
            data-setup="{}">
        <source src="<?php echo $resultArray->videoLink_raw; ?>" type="video/mp4">

    </video>
</div>
</div>

</body>
</html>