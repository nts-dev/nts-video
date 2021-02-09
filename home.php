<?php
ini_set('display_errors', '0');

$eid = filter_input(INPUT_GET, 'eid', FILTER_SANITIZE_NUMBER_INT);

$projectId = filter_input(INPUT_GET, 'projectId', FILTER_SANITIZE_NUMBER_INT);
session_start();
if (!$eid) {
    $_SESSION['user_session'] = 0;
    $_SESSION['user_name'] = 'Guest';
    $_SESSION['user_br'] = 0;
}

$username = $_SESSION['user_name'];
if (!$eid) {
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>NTS Training</title>
    <!-- here -->
    <link rel="icon" href="">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">

    <!--  css  -->
    <link rel="stylesheet" type="text/css" href="lib/dhtmlxSuite5/codebase/dhtmlx.css">
    <link rel="stylesheet" type="text/css" href="lib/dhtmlxSuite5/skins/material/dhtmlx.css">
    <link rel="stylesheet" type="text/css" href="lib/dhtmlxSuite5/skins/web/dhtmlx.css">
    <link rel="stylesheet" type="text/css" href="lib/dhtmlxSuite5/skins/terrace/dhtmlx.css">

    <link rel="stylesheet" type="text/css" href="lib/dhtmlxSuite5/codebase/fonts/font_roboto/roboto.css"/>
    <link rel="stylesheet" type="text/css" href="lib/dhtmlxSuite5/codebase/fonts/font_awesome/css/fontawesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="lib/dhtmlxSuite5/codebase/fonts/font_awesome/css/fa-solid.min.css"/>


    <link rel="stylesheet" type="text/css" href="presentation/content/view/css/gridcustome.css">
    <link rel="stylesheet" type="text/css" href="presentation/content/view/css/custome.css">
    <script src="lib/dhtmlxSuite5/codebase/dhtmlx.js"></script>
    <!--  Jquery -->
    <link href="lib/jquery/jquery.css" rel="stylesheet" type="text/css"/>
    <script src="lib/jquery/jquery_v152.js"></script>
    <script src="lib/jquery/jquery-ui.min.js"></script>

    <style>

        html, body {
            width: 100%;
            height: 100%;
            margin: 0px;
            overflow: hidden;
        }

        .formbox {
            background-color: #ffffff;
            color: blue;
            font-family: Tahoma;
            font-size: 92%;
            padding-left: 10px;
            padding-top: 10px;
        }


        .dhxtree_dhx_skyblue .standartTreeRow, .dhxtree_dhx_skyblue .standartTreeRow_lor {
            font-family: "museo_sans500" !important;
            font-size: 11px !important;
        }

        .dhxtree_dhx_skyblue .selectedTreeRow_lor, .dhxtree_dhx_skyblue .selectedTreeRow {
            background-color: #b5deff !important;
            background-repeat: repeat-x;
            font-family: "museo_sans500" !important;
            font-size: 11px !important;
            overflow: hidden;
        }

        .dhxtree_dhx_skyblue span.selectedTreeRow_lor {
            background-color: rgb(225, 244, 255) !important;
            box-sizing: border-box;
            height: 13px;
            line-height: 12px;
            padding: 0 0 1px;
        }

        div.gridbox_dhx_web.gridbox table.obj.row20px tr.rowselected td {
            background-color: rgb(225, 244, 255) !important;
            border-right-color: #fff !important;
        }

        .dhxform_obj_dhx_terrace input.dhxform_textarea, .dhxform_obj_dhx_terrace textarea.dhxform_textarea {
            background-color: white;
            margin: 0;
            padding: 4px 2px !important;
            font-family: "museo_sans500" !important;
            font-size: 11px !important;
        }

        .dhxform_obj_dhx_terrace div.dhxform_item_label_left div.dhxform_control {
            float: left;
            margin-left: 3px;
            font-family: "museo_sans500" !important;
            font-size: 11px !important;
        }

        .dhxform_obj_dhx_terrace div.dhxform_label {
            color: black;
            white-space: normal;
            font-family: "museo_sans500" !important;
            font-size: 11px !important;
        }

        .dhxform_obj_dhx_terrace div.dhxform_label {
            color: black;
            font-family: "museo_sans500" !important;
            font-size: 11px !important;
            overflow: hidden;
            white-space: normal;
        }

        div.dhxcombo_dhx_terrace input.dhxcombo_input {
            font-family: "museo_sans500" !important;
            font-size: 11px !important;
        }

        div.dhxcombolist_dhx_terrace {
            font-family: "museo_sans500" !important;
            font-size: 11px !important;
        }

        div.dhx_toolbar_poly_dhx_terrace td {
            font-family: "museo_sans500" !important;
            font-size: 11px !important;
        }

        .dhxwins_vp_dhx_terrace div.dhxwin_active div.dhx_cell_wins div.dhx_cell_toolbar_def {
            padding: 6px;
            border-width: 1px;
        }

        .dhx_toolbar_dhx_terrace div.dhx_toolbar_btn div.dhxtoolbar_text {
            margin-left: 0;
            line-height: 18px;
        }

        .dhx_toolbar_dhx_terrace div.dhx_toolbar_btn i.fa {
            margin-top: 0;
            color: #0072BC;
        }
    </style>


</head>
<body>
<script>
    <?php if (isset($projectId) && !empty($projectId)) { ?>
    var projectId = "<?= $projectId ?>";
    <?php } else { ?>
    var projectId;
    <?php } ?>
    //        var projectId = "10402";
    var global_userID = "<?= $eid ?>";
    var username = "<b><?= $_SESSION['user_name'] ?></b>";
    var branchId = "<?= $_SESSION['user_br'] ?>";
    var languageId = '0';
</script>
<script src="presentation/projectTree/main_layout.js"></script>
</body>
</html>

