<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
    
//include connection logic
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$ROOT_PATH = "";
define('ROOTPATH', dirname(__FILE__));
define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
define("SERVER_NAME", $_SERVER["SERVER_NAME"]);

if (SERVER_NAME === '192.168.1.2')
    $ROOT_PATH = LOCAL_PATH_ROOT . '/Training';
else
    $ROOT_PATH = LOCAL_PATH_ROOT;


include_once $ROOT_PATH.'/app/Stream/config/database.php';
include_once $ROOT_PATH . '/app/Stream/media.php';

$database = new Database();

$db = $database->getConnection();

$projects = new Media($db);

$projectsResult = $projects->courses_PHONE(1, 1, 20196);




//prepare data for contents

$data = '';
$meta = '';
$projectData = '';


$PROJECT = array();


$projectObj = new stdClass;
$projectObj->data = array();


$metaData = new stdClass;
$metaData->total = $projectsResult->rowCount();

$projectObj->meta = $metaData;

if ($projectsResult->rowCount() > 0) {
    while ($row = $projectsResult->fetch(PDO::FETCH_ASSOC)) {

        extract($row);
        $PROJECT[$id]['project_id'] = intval($id);
        $PROJECT[$id]['project_name'] = $project_name;
        $PROJECT[$id]['project_number'] = generateProjectId($id);

    }
}







foreach ($PROJECT as $PROJECTID => $project_item) {
    $projects = new stdClass;

    $projects->id = $project_item["project_id"];
    $projects->subject_title = $project_item["project_name"];
    $projects->subject_description = $project_item["project_number"];

    $projectObj->data[] = $projects;

}

//$projectObj->meta[] = $metaData;



echo json_encode($projectObj);



function generateProjectId($itemId) {
    if (strlen($itemId) == 1) {
        $projectId = "P00000" . $itemId . "";
    } else if (strlen($itemId) == 2) {
        $projectId = "P0000" . $itemId . "";
    } else if (strlen($itemId) == 3) {
        $projectId = "P000" . $itemId . "";
    } else if (strlen($itemId) == 4) {
        $projectId = "P00" . $itemId . "";
    } else if (strlen($itemId) == 5) {
        $projectId = "P0" . $itemId . "";
    } else {
        $projectId = $itemId;
    }

    return $projectId;
}

