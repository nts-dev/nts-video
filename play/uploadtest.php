<?php
$file = $_GET['file'];
$filepath = "../uploads/".$file;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>NTS Training</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #vidtag {
            width: 100%;
            height: 100%;
        }
    </style>
</head>


<body>
    <video controls autoplay id="vidtag">
        <source src="<?php echo $filepath ?>" type="video/mp4">

    </video>
</body>

</html>