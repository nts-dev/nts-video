<?php

include('../auth.php');

$eid = filter_input(INPUT_GET, 'eid', FILTER_SANITIZE_NUMBER_INT);

$projectId = filter_input(INPUT_GET, 'projectId', FILTER_SANITIZE_NUMBER_INT);

//$session = unserialize($_SESSION['USER']);
//
//$userBO = $session->getBOUser();
//$userFlare = $session->getFlareUser();


?>
<!DOCTYPE html>
<html>
<head>
    <title>NTS Training</title>

    <?php
    CSSPackage::DHTMLX();
    CSSPackage::FONTAWESOME();
    CSSPackage::JQUERY();
    ?>


    <link rel="stylesheet" type="text/css" href="view/css/gridcustome.css">
    <link rel="stylesheet" type="text/css" href="view/css/custome.css">

    <?php

    JSPackage::DHTMLX();
    JSPackage::JQUERY();

    ?>


</head>
<body>
<div id="videoAppHomepage" style="width:100%;height:100%;"></div>

<script>

    const TRAINEE = { //TODO
        id: 20196,
        identifier: "1kenan"
    }
    //const ID = "<?//= $eid ?>//";
    //const identifier = "<?//= $identifier ?>//";
    //const TRAINEE = {id: ID, identifier: identifier,}

    const WWWROOT = "<?php echo WEBURL . \Boot::WWWROOT ?>";
    const baseURL = "<?php echo WEBURL . \Boot::WWWROOT . 'nts-video/' ?>";

</script>
<script src="view/js/HTTPfunctions.js"></script>
<script src="view/js/layout.js"></script>
<script src="view/js/subtitleAudioLayout.js"></script>
<script src="view/js/mediaPlayerLayout.js"></script>
<script src="view/js/helpers/audioTranslator.js"></script>
<script src="view/js/uploader_form.js"></script>
<script src="view/js/upload_section.js"></script>
<script src="view/js/filmScript.js"></script>

</body>

</html>

