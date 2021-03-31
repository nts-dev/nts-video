<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}


$id = $_GET['id'];

include('../api/session/Commons.php');


$bootstrap = App::getInstance();


$session = $bootstrap::startSessionIfNotAvailable(
    filter_input(INPUT_GET, 'trainee', FILTER_SANITIZE_STRING),
    filter_input(INPUT_GET, 'identifier', FILTER_SANITIZE_STRING)
);

$mediaService = new MediaService($session);

$resultArray = $mediaService->findById($id);



?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Player</title>
    <link href="../lib/video-js/video-js.css" rel="stylesheet">
    <link href="../lib/videojs-share/video-share.css" rel="stylesheet">
    <link href="../lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">


</head>

<body>
<!--<div class="container">-->
<div class="row">
    <video
            id="my-video"
            class="video-js"
            controls
            preload="auto"
            data-setup="{}">
        <source src="<?php echo $resultArray->videoLink_raw; ?> " type="video/mp4">

    </video>
</div>

    <script src="https://vjs.zencdn.net/7.11.4/video.min.js"></script>

</body>
</html>