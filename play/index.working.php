<!DOCTYPE html>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$SERVER = "https://" . $_SERVER['HTTP_HOST'] . "/";

$id = $_GET['id'];


//$id = 590;

$videoHsl_directory = "/mediaresources/projectAlias[P100909]/contentID/type[video::audio]/mediaId/hsl/master.m3u8";

$subtitle_directory = "/uploads/subs/f_" . $id . "/";

$master_directory = "";



include_once '../app/Stream/config/database.php';

include_once '../app/Stream/media.php';

$database = new Database();


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

//echo $hsl_file;

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



?>
<html>
<head>
    <meta charset="utf-8">
    <title>Player</title>
    <link href="/lib/video-js/video-js.css" rel="stylesheet">
</head>
<body>
<video id="maat-player" claid="player_one"
       class="video-js vjs-fluid vjs-default-skin"

       controls
       preload="auto"
       poster="images/poster.jpg" >

    <source src="<?=$hsl_file ?>" type="application/x-mpegURL">

    <?php
    //add subtitles
    foreach ($available_subtitle_files as $value) {
        $strng = substr($value, -5, 1);
        $lang = '';
        $lang_abrv = '';
        switch ($strng) {
            case 1:
                $lang = 'English';
                $lang_abrv = 'en';
                break;

            case 4:
                $lang = 'Dutch';
                $lang_abrv = 'nl';
                break;
            case 6:
                $lang = 'French';
                $lang_abrv = 'fr';
                break;
            case 9:
                $lang = 'Spanish';
                $lang_abrv = 'es';
                break;
            case 11:
                $lang = 'Malaysia';
                $lang_abrv = 'nrm';
                break;

            case 7:
                $lang = 'German';
                $lang_abrv = 'de';
                break;
            case 8:
                $lang = 'Swahili';
                $lang_abrv = 'sw';
                break;
        }
        ?>

        <track preload='auto' kind='captions' src='<?= $value ?>' srclang='<?= $lang_abrv ?>' label='<?= $lang ?>' <?= $strng == 1 ? 'default' : '' ?>>
        <?php
    }
    ?>
</video>


<script type="text/javascript" src="/lib/video-js/video.min.js"></script>
<script type="text/javascript" src="/lib/video-js/plugins/videojs-audio-tracks.js"></script>
<script type="text/javascript" src="/lib/nuevo/nuevo.min.js"></script>

<script>
    (function (window, videojs) {
        const player = window.player = videojs('maat-player', {}, function () {
            this.nuevoPlugin({

                logotitle: 'Nuevo plugin for Videojs',

                logo: 'images/logo.png',

                logoposition: 'RT',

                logourl: 'https://www.video.nts.nl',

                slideImage: '<?= $tile_dir ?>',

                slideType: 'vertical', //optional

                slideWidth: 192, //optional

                slideHeight: 109  //optional

            });
        });


        const audioTrackList = player.audioTracks();

        const textTrackList = player.textTracks()

        // watch for changes that will be triggered by any change
        // to enabled on any audio track. Manually or through the
        // select element
        audioTrackList.on('change', function () {
            for (var i = 0; i < audioTrackList.length; i++) {
                var track = audioTrackList[i];
                if (track.enabled) {
                    console.log('A new ' + track.language + ' has been enabled!');


                    for (j = 0; j < textTrackList.length; j++) {
                        var caption = textTrackList[j];
                        console.log('Text tracks ' + textTrackList[j].language);
                        if (caption.kind === 'captions' && caption.language === track.language) {
                            caption.mode = 'showing';
//                                    player.removeRemoteTextTrack(textTrackList[j])
                        } else
                            caption.mode = 'hidden';

                    }
                }
            }
        });


        textTrackList.on('change', function () {
            for (var i = 0; i < textTrackList.length; i++) {
                var caption = textTrackList[i];
                if (caption.mode === 'showing') {
                    console.log('Txt ' + caption.language + ' has been enabled!');

                    for (j = 0; j < audioTrackList.length; j++) {
                        var track = audioTrackList[j];

                        if (track.language === caption.language) {
                            track.enabled = true;
                        } else
                            track.enabled = false;

                    }
                }
            }
        });


        // will be fired twice in this example
        audioTrackList.on('addtrack', function () {
            console.log('a track has been added to the audio track list');
        });
        // will not be fired at all unless you call
        // audioTrackList.removeTrack(trackObj)
        // we typically will not need to do this unless we have to load
        // another video for some reason
        audioTrackList.on('removetrack', function () {
            console.log('a track has been removed from the audio track list');
        });
        // getting all the possible audio tracks from the track list
        // get all of thier properties
        // add each track to the select on the page
        // this is all filled out by HLS when it parses the m3u8
        player.on('loadeddata', function () {
            console.log('There are ' + audioTrackList.length + ' audio tracks');
            for (var i = 0; i < audioTrackList.length; i++) {
                var track = audioTrackList[i];
                var option = document.createElement("option");
                option.text = track.label;
                if (track.enabled) {
                    option.selected = true;
                }

                console.log('Track ' + (i + 1));
                ['label', 'enabled', 'language', 'id', 'kind'].forEach(function (prop) {
                    console.log("  " + prop + ": " + track[prop]);
                });
            }
        });
    }(window, window.videojs));
</script>
</body>
</html>