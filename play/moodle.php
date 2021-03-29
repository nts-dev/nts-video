


<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="https://vjs.zencdn.net/7.7.5/video-js.css" rel="stylesheet" />

        <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
        <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
    </head>

    <body>
    <video
            id="my-video"
            class="video-js"
            controls
            preload="auto"
            width="640"
            height="264"
            poster="MY_VIDEO_POSTER.jpg"
            data-setup="{}">
        <source src="https://video.nts.nl/uploads/f_122.mp4" type="video/mp4" />

    </video>

    <script src="https://vjs.zencdn.net/7.7.5/video.js"></script>
    <script>
        var myId = document.getElementsByClassName('video-js')[0].id;
        var myPlayer = videojs(myId);

        myPlayer.currentTime(10);

    </script>
    </body>
</html>