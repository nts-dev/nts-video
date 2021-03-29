<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Player</title>
        <link href="../lib/video-js/video-js.css" rel="stylesheet">
    </head>
    <body>
        <video id="maat-player" claid="player_one" 
               class="video-js vjs-fluid vjs-default-skin" 
               width="70%"
               height="70%"
               controls 
               preload="auto" 
               poster="images/poster.jpg" >

            <source src="../media/f_274/manifest.m3u" type="application/x-mpegURL">
            <track preload='auto' kind='captions' src='../uploads/subs/f_274/caption1.vtt' srclang='eng' label='English' default />
            <track preload='auto' kind='captions' src='../uploads/subs/f_274/caption4.vtt' srclang='nl' label='Dutch' />
        </video>


        <script type="text/javascript" src="../lib/video-js/video.min.js"></script>
        <script type="text/javascript" src="../lib/video-js/plugins/videojs-audio-tracks.js"></script>
        <script type="text/javascript" src="../lib/nuevo/nuevo.min.js"></script>

        <script>
            (function (window, videojs) {
                var player = window.player = videojs('maat-player', {}, function () {
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


                var audioTrackList = player.audioTracks();

                var textTrackList = player.textTracks()

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

                                if ( track.language === caption.language) {
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