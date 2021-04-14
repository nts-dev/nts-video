<?php

include('../includes.php');

$eid = filter_input(INPUT_GET, 'eid', FILTER_SANITIZE_NUMBER_INT);

$projectId = filter_input(INPUT_GET, 'projectId', FILTER_SANITIZE_NUMBER_INT);

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


    <link rel="stylesheet" type="text/css" href="presentation/content/view/css/gridcustome.css">
    <link rel="stylesheet" type="text/css" href="presentation/content/view/css/custome.css">

    <?php

    JSPackage::DHTMLX();

    ?>


</head>
<body>
<div id="videoAppHomepage" style="width:98%;height:100%; margin-left: 1%"></div>

<script>
    const PARENT_URL = "/api/session/";
    const TRAINEE = { //TODO
        id: 20196,
        identifier: "1moche"
    }

    let projectFromProject =
        {
            id: -1, title: ""
        };

    const WWWROOT = "<?php echo Boot::WWWROOT ?>";

</script>
<script src="presentation/projectTree/main_layout.js"></script>

</body>

</html>

