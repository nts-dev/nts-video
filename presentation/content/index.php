<?php
include('../../../includes.php');


?>
<!DOCTYPE html>
<html>

<head>
    <title>NTS Videos</title>
    <!-- here -->
    <link rel="icon" href="">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">


    <?php


    CSSPackage::DHTMLX();
    CSSPackage::FONTAWESOME();

    ?>

    <link rel="stylesheet" type="text/css" href="view/css/gridcustome.css">
    <link rel="stylesheet" type="text/css" href="view/css/custome.css">

    <?php

    JSPackage::DHTMLX();
    JSPackage::JQUERY();
    ?>

</head>
<body>
<div id="streamHomepage" style="width:100%;height:100%;"></div>

<script>
    let PROJECT_ID;
    let projectFromProject =
        {
            id: -1, title: ""
        };
    const TRAINEE = { //TODO
        id: 20196,
        identifier: "1moche"
    }

    const WWWROOT = "<?php echo Boot::WWWROOT ?>";
    const baseURL = "<?php echo Boot::WWWROOT . 'nts-video/' ?>";
</script>

<script src="view/js/layout.js"></script>
<script src="view/js/subtitleAudioLayout.js"></script>
<script src="view/js/mediaPlayerLayout.js"></script>
<script src="view/js/helpers/audioTranslator.js"></script>
<script src="view/js/uploader_form.js"></script>
<script src="view/js/upload_section.js"></script>
<script src="view/js/filmScript.js"></script>

<script src="view/js/HTTPfunctions.js"></script>

</body>


</html>

