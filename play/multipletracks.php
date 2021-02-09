<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Multiple Alternative Audio Tracks - Example</title>
    <link href="../lib/video-js/video-js.css" rel="stylesheet">
  </head>
  <body>
    <h1>Multiple Alternative Audio Tracks</h1>
    <p>Check the source of this page and the console for detailed information on this example</p>
    <video id="maat-player" claid="player_one" 
                        class="video-js vjs-fluid vjs-default-skin" 
                        width="100%"
                        height="100%"
                        controls 
                        preload="auto" 
                        poster="images/poster.jpg" >

      <source src="../uploads/index.m3u8" type="application/x-mpegURL">
    </video>
    <div id="audioTrackChoice">
      <select id="enabled-audio-track" name="enabled-audio-track">
      </select>
    </div>

    <script type="text/javascript" src="../lib/video-js/video.min.js"></script>
    <script type="text/javascript" src="../lib/video-js/plugins/videojs-audio-tracks.js"></script>
    <script type="text/javascript" src="../lib/nuevo/nuevo.min.js"></script>
   
    <script>
      (function(window, videojs) {
        var player = window.player = videojs('maat-player', {}, function() {
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
        var audioTrackSelect = document.getElementById("enabled-audio-track");
        // watch for a change on the select element
        // then change the enabled audio track
        // only one can be enabled at a time, but video.js will
        // handle that for us, all we need to do is enable the new
        // track
        audioTrackSelect.addEventListener('change', function() {
          var track = audioTrackList[this.selectedIndex];
          console.log('User switched to track ' + track.label);
          track.enabled = true;
        });
        // watch for changes that will be triggered by any change
        // to enabled on any audio track. Manually or through the
        // select element
        audioTrackList.on('change', function() {
          for (var i = 0; i < audioTrackList.length; i++) {
            var track = audioTrackList[i];
            if (track.enabled) {
              console.log('A new ' + track.label + ' has been enabled!');
            }
          }
        });
        // will be fired twice in this example
        audioTrackList.on('addtrack', function() {
          console.log('a track has been added to the audio track list');
        });
        // will not be fired at all unless you call
        // audioTrackList.removeTrack(trackObj)
        // we typically will not need to do this unless we have to load
        // another video for some reason
        audioTrackList.on('removetrack', function() {
          console.log('a track has been removed from the audio track list');
        });
        // getting all the possible audio tracks from the track list
        // get all of thier properties
        // add each track to the select on the page
        // this is all filled out by HLS when it parses the m3u8
        player.on('loadeddata', function() {
          console.log('There are ' + audioTrackList.length + ' audio tracks');
          for (var i = 0; i < audioTrackList.length; i++) {
            var track = audioTrackList[i];
            var option = document.createElement("option");
            option.text = track.label;
            if (track.enabled) {
              option.selected = true;
            }
            audioTrackSelect.add(option, i);
            console.log('Track ' + (i + 1));
            ['label', 'enabled', 'language', 'id', 'kind'].forEach(function(prop) {
              console.log("  " + prop + ": " + track[prop]);
            });
          }
        });
      }(window, window.videojs));
    </script>
  </body>
</html>