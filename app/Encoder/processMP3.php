<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../../api/core.php';


//include database
include_once $ROOT_PATH . '/app/Stream/config/database.php';
//include object file
include_once $ROOT_PATH . '/app/Stream/media.php';

include_once $ROOT_PATH . '/app/Encoder/process.php';



$database = new Database();

$db = $database->getConnection();

$media = new Media($db);



$process = new Process();




//fetch file 
$id = 179;

$process->_file_dir = $ROOT_PATH . '/uploads/audiomovie/f_' . $id . '/';

$HLS_master_dir = $ROOT_PATH . '/media/f_' . $id . '/audio/';

$process->HLS_File_dir = $ROOT_PATH . '/media/f_' . $id . '/'; //manifest file


$result = $media->audioMovie_HLS_fun($id);


if ($result->rowCount() > 0) {

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $process->_file = 'audiomovie.mp3';

        $process->inputFile = $process->_file_dir . $languageID . '/' . $process->_file; //path to mp3 / 4 file

        if (file_exists($process->inputFile)) {

            $process->outputFile = $HLS_master_dir . $languageName . '/index.m3u8';

            echo $process->generateAudio(); // generate .m3u8 files
        } 
    }
    
//write manifest file
    if($process->generateMasterManifest($HLS_master_dir)) 
        echo json_encode(array("message" => "Action complete", "status" => "Success"));
    else 
        echo json_encode(array("message" => "Error occured", "status" => "Fail"));
}






