<?php

use session\project\ProjectService;
use session\RequestType;

$action = $_GET['action'];
//$mode = ;
include('Commons.php');


$bootstrap = App::getInstance();


//$session = $bootstrap::startSessionIfNotAvailable(
//    filter_input(INPUT_GET, 'trainee', FILTER_SANITIZE_STRING),
//    filter_input(INPUT_GET, 'identifier', FILTER_SANITIZE_STRING)
//);

$service = new ProjectService();

switch ($action) {

    case RequestType::PROJECT_ALL:
        $result = $service->findAll();
        if(isset($_GET['mode']) && $_GET['mode'] === 'json')
        {
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: GET");

            $projectObj = new stdClass;
            $projectObj->data = array();
            foreach ($result as $project_item) {
                $projects = new stdClass;

                $projects->id = $project_item["id"];
                $projects->subject_title = $project_item["title"];
                $projects->subject_description = $project_item["id"];

                $projectObj->data[] = $projects;

            }
            echo json_encode($projectObj);
//            echo json_encode(array("data" => $result));
        }else{
            XML::projectGrid($result);
        }
//        var_dump?($result);
//
        break;

    case RequestType::PROJECT_COMBO:

        $resultArray = $service->findAll();
        XML::projectCombo($resultArray);
        break;
}