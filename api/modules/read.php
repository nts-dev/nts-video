<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../core.php';
//include database
include_once $ROOT_PATH . '/app/Stream/config/database.php';
//include object file
include_once $ROOT_PATH . '/app/Stream/media.php';



$database = new Database();

$db = $database->getConnection();

$projects = new Media($db);

$projectsResult = $projects->courses_PHONE(1, 1, 20196);


$contentResult = $projects->content_all();

//set media urls
$url = "https://video.nts.nl/uploads/";
$internal_path = "../../uploads/";
$hls = "https://video.nts.nl/media/";

//prepare data for contents

$data = '';
$projectData = '';
$contentNum = $contentResult->rowCount();

$PROJECT = array();
$CONTENT = array();

$projectObj = new stdClass;
$projectObj->data = array();

$contents = new stdClass;
$contents->data = array();


if ($projectsResult->rowCount() > 0) {
    while ($row = $projectsResult->fetch(PDO::FETCH_ASSOC)) {

        extract($row);
        $PROJECT[$id]['project_id'] = $id;
        $PROJECT[$id]['project_name'] = $project_name;
        $PROJECT[$id]['project_number'] = generateProjectId($id);
        $PROJECT[$id]['content_items'] = array();
    }
}





if ($contentNum > 0) {
    while ($row = $contentResult->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $CONTENT[$project_id][$content_id]["content_id"] = $content_id;
        $CONTENT[$project_id][$content_id]["content_name"] = $content_name;
        $CONTENT[$project_id][$content_id]["content_description"] = $content_description;
        $CONTENT[$project_id][$content_id]["content_date_updated"] = $content_date_updated;
        $CONTENT[$project_id][$content_id]["project_id"] = $project_id;
        if (isset($media_id)) {
            $CONTENT[$project_id][$content_id]["media_items"][$media_id]["media_id"] = $media_id;
            $CONTENT[$project_id][$content_id]["media_items"][$media_id]["media_name"] = $media_name;
            $CONTENT[$project_id][$content_id]["media_items"][$media_id]["media_alias"] = $media_alias;
            $CONTENT[$project_id][$content_id]["media_items"][$media_id]["media_description"] = $description;
            $CONTENT[$project_id][$content_id]["media_items"][$media_id]["media_type"] = $media_type;
            $CONTENT[$project_id][$content_id]["media_items"][$media_id]["media_size"] = $media_size;
            $CONTENT[$project_id][$content_id]["media_items"][$media_id]["media_upload_date"] = $media_upload_date;
            $CONTENT[$project_id][$content_id]["media_items"][$media_id]["media_sort"] = $media_sort;
        }else 
            $CONTENT[$project_id][$content_id]["media_items"]= array();
    }
}


//make child of Projects
foreach ($PROJECT as $P_ID => $projectItem) {
    $projectId = $projectItem["project_id"];
    foreach ($CONTENT as $C_ID => $contentItem) {
        if ($projectId == $C_ID)
            $PROJECT[$P_ID]['content_items'] = $CONTENT[$C_ID];
    }
}

//echo '<pre>';
//print_r($CONTENT);
//
//exit;

foreach ($PROJECT as $PROJECTID => $project_item) {
    $projects = new stdClass;

    $projects->project_id = $project_item["project_id"];
    $projects->project_name = $project_item["project_name"];
    $projects->project_number = $project_item["project_number"];
    $projects->content_items = array();
    $projectObj->data[] = $projects;

    foreach ($project_item['content_items'] as $CONTENTID => $content_item) {

        $content = new stdClass;

        $content->content_id = $content_item['content_id'];
        $content->content_name = $content_item['content_name'];
        $content->content_description = $content_item['content_description'];
        $content->content_date_updated = $content_item['content_date_updated'];
        $content->project_id = $content_item['project_id'];
        $content->media_items = array();

        $projects->content_items[] = $content;

//        foreach ($content_item['media_items'] as $MEDIA => $child) {
//
//            $media_item = new stdClass;
//            $media_item->media_id = $child['media_id'];
//            $media_item->media_name = $child['media_name'];
//            $media_item->media_alias = $child['media_alias'];
//            $media_item->media_description = $child['media_description'];
//            $media_item->media_size = $child['media_size'];
//            $media_item->media_url = $url . $child['media_alias'];
//            $media_item->media_hls_url = $hls . 'f_' . $child['media_id'] . '/manifest.m3u';
//            $media_item->media_type = $child['media_type'];
//            $media_item->media_thumbnail = $url . 'thumbnails/' . getFileName($url . $child['media_alias']) . '/pic5.jpg ';
//
//            $content->media_items[] = $media_item;
//        }
    }
}








//foreach ($CONTENT as $CONTENTID => $content_item) {
//    $content = new stdClass;
//
//    $content->content_id = $content_item['content_id'];
//    $content->content_name = $content_item['content_name'];
//    $content->content_description = $content_item['content_description'];
//    $content->content_date_updated = $content_item['content_date_updated'];
//    $content->project_id = $content_item['project_id'];
//    $content->media_items = array();
//
//    $contents->data[] = $content;
//
//    foreach ($content_item['media_items'] as $MEDIA => $child) {
//
//        $media_item = new stdClass;
//        $media_item->media_id = $child['media_id'];
//        $media_item->media_name = $child['media_name'];
//        $media_item->media_alias = $child['media_alias'];
//        $media_item->media_description = $child['media_description'];
//        $media_item->media_size = $child['media_size'];
//        $media_item->media_url = $url . $child['media_alias'];
//        $media_item->media_hls_url = $hls . 'f_' . $child['media_id'] . '/manifest.m3u';
//        $media_item->media_type = $child['media_type'];
//        $media_item->media_thumbnail = $url . 'thumbnails/' . getFileName($url . $child['media_alias']) . '/pic5.jpg ';
//
//        $content->media_items[] = $media_item;
//    }
//}
//
//


echo json_encode($projectObj);

function getFileName($file) {
    $collection = 1;
    $path_info = pathinfo($file);
    $type = $path_info['extension'];
    $name = $path_info['filename'];

    return $name;
}
