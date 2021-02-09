<?php
//$file = $_GET['v'];
//$sub_file = substr($file, 0, -3);

function ecryption_ACTIONS($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'mediaserver';
    $secret_iv = 'mediasecret';

    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
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

$subtitle = "http://video.nts.nl:1935/vod/" . $sub_file . "ttml";

$vid_url = "http://video.nts.nl:1935/vod/" . $file . "/manifest.mpd";
//$vid_url = "http://83.98.243.184:1935/vod/170216A_090_MotherandSon_1080p.mp4/manifest.mpd";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>NTS Training</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
        <!-- Bitmovin Player -->
        <script type="text/javascript" src="https://bitmovin-a.akamaihd.net/bitmovin-player/stable/7.6/bitmovinplayer.js"></script>
        <!--<script type="text/javascript" src="../lib/bitmovin.js"></script>-->

        <script>


        </script>
        <style>
            .bmpui-ui-skin-modern .bmpui-ui-watermark {
                background-image: none !important;
            }
        </style>
    </head>

    <body>
        <div id="player" style="width: 96%; height: 96%; margin-top: 0; margin-left: 2%"></div>

        <script type="text/javascript">
            var conf = {
                "key": "e6c18d97-f092-4352-bd39-983e22ac6d4c",
                "playback": {
                    autoplay: true
                },
                "source": {
                    dash: '<?= $vid_url ?>'
                },
                cast: {
                    enable: true
                }

            };
            var player = bitmovin.player('player');

            player.setup(conf).then(
                    function(value) {
                        var enSubtitle = {
                            id: "sub1",
                            url: "<?= $subtitle ?>",
                            kind: "subtitle"

                        };
                        player.addSubtitle(enSubtitle);
                        // Success
                        console.log('Successfully created bitmovin player instance');
                    },
                    function(reason) {
                        // Error!
                        console.log('Error while creating bitmovin player instance');
                    }
            );

        </script>
    </body>
</html>