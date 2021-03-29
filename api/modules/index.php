<?php

// Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



include_once '../core.php';
//include database
include_once $ROOT_PATH . '/nts-video/app/Stream/config/database.php';
//include object file
include_once $ROOT_PATH . '/nts-video/app/Stream/media.php';



$database = new Database();

$db = $database->getConnection();

$projects = new Media($db);

$projectsResult = $projects->courses_PHONE(1, 1, 20196);


$contentResult = $projects->content_all();



$data = '';
$contentNum = $contentResult->rowCount();


$CONTENT = array();

$contents = new stdClass;
$contents->data = array();





if ($contentNum > 0) {
    while ($row = $contentResult->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $CONTENT[$content_id]["id"] = $content_id;
        $CONTENT[$content_id]["title"] = $content_name;
        $CONTENT[$content_id]["description"] = $content_description;
        $CONTENT[$content_id]["subject_id"] = $project_id;
    }
}




foreach ($CONTENT as $CONTENTID => $content_item) {
    if (empty($content_item['id']) || empty($content_item['title']))
        continue;



    $content = new stdClass;

    $content->id = (int)$content_item['id'];
    $content->title = $content_item['title'];
    $content->description = $content_item['description'];
    $content->subject_id = (int)$content_item['subject_id'];


    $contents->data[] = $content;


}




echo json_encode($contents);


