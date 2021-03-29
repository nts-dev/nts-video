<?php


include_once '../core.php';


$database = new Database();

$db = $database->getConnection();

$media = new Media($db);

// get posted data
$incomingData = json_decode(file_get_contents("php://input"));

$media->project_id = $incomingData->project_id;
$media->module_name = $incomingData->content_name;
$media->module_decription = $incomingData->content_description;

$result = $media->content_ADD_FROM_APP($incomingData->project_id);

if ($result) {
  
    http_response_code(201);
    echo '{"message":"Create success", "status":"Success"}';
    
} else {
    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo '{"message":"Unable to create content", "status": "Fail"}';
}