<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$SERVER = "http://" . $_SERVER['HTTP_HOST'] ;

$id = $_GET['id'];


$subtitle_directory = "/uploads/subs/f_" . $id . "/";

$master_directory = "";



include_once '../app/Stream/config/database.php';

include_once '../app/Stream/media.php';

$database = new Database($host,$user,$pass,$db);


$db = $database->getConnection();

$media = new Media($db);

$resourceResult = $media->mediaResources_GET($id);

if ($resourceResult->rowCount() > 0) {
    while ($row = $resourceResult->fetch(PDO::FETCH_ASSOC)) {
        $type = getMediaType($row["media_type"]);
        $master_directory = "/mediaresources/".generateProjectId($row["project_id"])."/".$row["content_id"]."/". $type ."/". $row["media_id"] ."/";
    }
}

if(empty($master_directory)){
    echo "path empty";
    die();
}



$available_subtitle_files = array();

$subtitle_files_count = 0;


if (is_dir($subtitle_directory)) {
    $available_subtitle_files = glob($subtitle_directory . "*");
    $subtitle_files_count = count($available_subtitle_files);
}

$hsl_file = $SERVER . $master_directory. "hsl/master.m3u8";
$tile_dir = $SERVER . $master_directory. "sprint/index.jpg";

$odinary_file = $SERVER . $master_directory. "media.mp4";

// echo $odinary_file;

function getMediaType($type){
  $count = 0;
  $result = "";
  while($count < strlen($type) && isValid($type{$count}))
      $result .= $type{$count++};

  return $result;

}


function isValid($string)
{
    return ctype_alnum ($string);
}

function generateProjectId($itemId) {
    if (strlen($itemId) == 1) {
        $projectId = "P00000" . $itemId . "";
    } else if (strlen($itemId) == 2) {
        $projectId = "P0000" . $itemId . "";
    } else if (strlen($itemId) == 3) {
        $projectId = "P000" . $itemId . "";
    } else if (strlen($itemId) == 4) {
        $projectId = "P00" . $itemId . "";
    } else if (strlen($itemId) == 5) {
        $projectId = "P0" . $itemId . "";
    } else {
        $projectId = $itemId;
    }

    return $projectId;
}


// die();

?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title></title>
    <link href="//unpkg.com/video.js/dist/video-js.min.css" rel="stylesheet">
    <link href="/lib/videojs/videojs-vjsdownload.css" rel="stylesheet">
    <link href="/lib/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="/lib/bootstrap/dist/js/bootstrap.min.js"></script>
</head>

<body>

    <div>
        <video class="w-100" style="height: 100% !important" id="videojs-vjsdownload-player" class="video-js vjs-default-skin" poster="https://vjs.zencdn.net/v/oceans.png" controls>
            <source src="<?php echo $odinary_file; ?>" type='video/mp4'>
          </video>
            <script src="//unpkg.com/video.js@7.4.1/dist/video.min.js"></script>
            <script src="/lib/videojs/videojs-vjsdownload.min.js"></script>
            <script>
                var player = videojs(document.querySelector('.video-js'), {
                  plugins: {
                    vjsdownload:{
                      beforeElement: 'playbackRateMenuButton',
                      textControl: 'Download video',
                      name: 'downloadButton',
                      downloadURL: 'https://optional_downloadURL.mp4' //optional if you need a different download url than the source
                    }
                  }
                } , function() {
                  console.log('Callback video-js initiated');
                  this.on('downloadvideo', function(){
                  console.log('downloadvideo triggered');
                });
              });
            </script>
            <!-- <script>
              (function(window, videojs) {
                var player = window.player = videojs('videojs-vjsdownload-player');
                player.vjsdownload();
              }(window, window.videojs));
            </script> -->

    </div>
</body>
</html>
