<?php

//-----------------------------------------------------Ecryp URL----------------------------------------------
function ecryption_ACTIONS($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'mediaserver';
    $secret_iv = 'mediasecret';

    // hash
    $key = hash('sha256', $secret_key);

    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

$file = ecryption_ACTIONS('decrypt', $_GET['v']);
//$sub_file = substr($file, 0, -3);

$SERVER = "https://" . $_SERVER['HTTP_HOST'];

$vid_url = $SERVER . "/uploads/" . $file;



$path_info = pathinfo($vid_url);


$name = $path_info['filename'];
//$vid_thumbnail = ($file === 'zoom_1.mp4') ?  'https://video.nts.nl/uploads/Thumbnail/zoom_1.mp4.jpg' : '';


$vid_thumbnail = $SERVER . "/uploads/sprite/" . $name . "/sprite.jpg";

$vtt_directory = "../uploads/subs/" . $name . "/";

$vid_sub = $SERVER . "/uploads/subs/" . $name . "/";


$sub_string = '';
if (is_dir($vtt_directory)) {
    $vtt_files = array();
    $i = 0;
    if ($handle = opendir($vtt_directory)) {
        while (($file = readdir($handle)) !== false) {
            if (!in_array($file, array('.', '..')) && !is_dir($vtt_directory . $file))
                $vtt_files[] = $vtt_directory . $file;
            $i++;
        }
    }


//    print_r($vtt_files);
}

//echo $sub_string;
//exit;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Training</title>

        <link href="../lib/video-js/skins/treso/video-js.css" rel="stylesheet" type="text/css" />
        <link href="../lib/video-js/plugins/videojs-audio-tracks.css" rel="stylesheet" type="text/css" />
        <style>
            .player_one-dimensions.vjs-fluid {
                padding-top: 53.25% !important;
            }

        </style>
    </head>


    <body>




        <div class="container" style="width:100% !important;">
            <h1></h1>

            <script type="text/javascript" src="../lib/video-js/video.min.js"></script>
            <script type="text/javascript" src="../lib/video-js/plugins/videojs-audio-tracks.js"></script>
            <script type="text/javascript" src="../lib/nuevo/nuevo.min.js"></script>

            <div class="media-parent" style="width:100% !important;">
                <div class="media-child">
                    <video 
                        id="player_one" 
                        class="video-js vjs-fluid vjs-default-skin" 
                        width="100%"
                        height="100%"
                        controls 
                        preload="auto" 
                        poster="images/poster.jpg">
                        <source src="<?= $vid_url ?>" default res="SD" label="SD" type="video/mp4">
                        <source src="<?= $vid_url ?>"  res="HD" label="HD" type="video/mp4">
                        
                        <!--<source src="https://video.nts.nl/uploads/audiomovie/f_179/f_179.mp4"  res="HD" label="HD" type="video/mp4">-->
                        <!--<track kind='subtitles' src='https://video.nts.nl/uploads/test.vtt' srclang='en' label='English' default/>-->
                        <?php
                        foreach ($vtt_files as $value) {
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
                                    $lang_abrv = 'da';
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

                </div>
            </div>

            <script>
                var player = videojs('player_one', {}, function() {
                    this.nuevoPlugin({
                        logotitle: 'Nuevo plugin for Videojs',
                        logo: 'images/logo.png',
                        logoposition: 'RT',
                        logourl: 'https://www.video.nts.nl',
                        slideImage: '<?= $vid_thumbnail ?>',
                        slideType: 'vertical', //optional
                        slideWidth: 192, //optional
                        slideHeight: 109  //optional
                    });
                });

                var track = new videojs.AudioTrack(
                    {
                    id: 'my-spanish-audio-track',
                    kind: 'translation',
                    label: 'Spanish',
                    language: 'es'
                },
                 {
                    id: 'my-french-audio-track',
                    kind: 'translation',
                    label: 'French',
                    language: 'fr'
                },
                 {
                    id: 'my-dutch-audio-track',
                    kind: 'translation',
                    label: 'Dutch',
                    language: 'du',
                    enabled: true
                }
                    );



                player.audioTracks().addTrack(track);

                // Get the current player's AudioTrackList object.
                var audioTrackList = player.audioTracks();
                
                console.log(audioTrackList)

// Listen to the "change" event.
                audioTrackList.addEventListener('change', function() {

                    // Log the currently enabled AudioTrack label.
                    for (var i = 0; i < audioTrackList.length; i++) {
                        var track = audioTrackList[i];

                        if (track.enabled) {
                            videojs.log(track.label);
                            return;
                        }
                    }
                });

            </script>


        </div>


    </body>
</html>