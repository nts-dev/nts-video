<?php

function ecryption_ACTIONS($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'mediaserver';
    $secret_iv = 'mediasecret';

    // hash
    $key = hash('sha256', $secret_key);

    $iv = substr(hash('sha256', $secret_iv), 0, 8);
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

$file = ecryption_ACTIONS('decrypt', $_GET['v']);
$sub_file = substr($file, 0, -3);
$subtitle = "https://video.nts.nl/uploads/" . $sub_file . "ttml";
$vid_url = "https://video.nts.nl/uploads/" . $file;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Training</title>

        <link href="../lib/video-js/skins/treso/video-js.css" rel="stylesheet" type="text/css" />
    </head>
    <style>
        .container{
            margin-right: 1% !important;
            /*padding: 1%;*/
        }
        #player_one{
            position: fixed;
        }
    </style>

    <body>



        <div class="container">
            <h1></h1>

            <script type="text/javascript" src="../lib/video-js/video.min.js"></script>
            <script type="text/javascript" src="../lib/nuevo/nuevo.min.js"></script>

            <div class="media-parent">
                <div class="media-child">
                    <video 
                        id="player_one" 
                        class="video-js vjs-fluid vjs-default-skin" 
                        controls 
                        preload="auto" 
                        poster="images/poster.jpg">
                        <source src="<?= $vid_url ?>" default res="SD" label="SD" type="video/mp4">
                        <source src="<?= $vid_url ?>"  res="HD" label="HD" type="video/mp4">
<!--                        <track kind='captions' src='https://dotsub.com/media/5d5f008c-b5d5-466f-bb83-2b3cfa997992/c/chi_hans/vtt' srclang='zh' label='Chinese'  />
                        <track kind='captions' src='http://video.nts.nl/uploads/test.vtt' srclang='en' label='English' default/>-->

                    </video>
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
                        slideImage: 'https://www.video.nts.nl/uploads/Thumbnail/Opnemen in OBS.jpeg',
                        slideType: 'vertical', //optional
                        slideWidth: 192, //optional
                        slideHeight: 108  //optional
                    });
                });
            </script>


        </div>


    </body>
</html>