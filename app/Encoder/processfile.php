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


include_once '../../app/Stream/config/core.php';

//include database
include_once $ROOT_PATH . '/app/Stream/config/database.php';
//include object file
include_once $ROOT_PATH . '/app/Stream/media.php';

include_once $ROOT_PATH . '/app/Encoder/process.php';



$database = new Database();

$db = $database->getConnection();

$media = new Media($db);



$process = new Process();

$process->_file_dir = $ROOT_PATH . '/uploads/';


//fetch file 
//$id = 245;
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$result = $media->media_files_ALIES($id);


//$result = $media->media_file_ALL(); //all files

if ($result->rowCount() > 0) {

    $row = $result->fetch(PDO::FETCH_ASSOC);
//    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

    $process->_file = $row['Alias'];
    

    $process->inputFile = $process->_file_dir . $process->_file; //path to mp3 / 4 file


    if (file_exists($process->inputFile)) {

        $process->master_dir = $ROOT_PATH . '/media/';

        $process->createDirectory($process->master_dir); //create new media directory

        $process->extractFileNameAndCreateSubDirrectory(); //extract file name and create mini sub directories [file_, audio, video, subs]

        $process->outputFile = $process->HLS_File_dir . '/video/index.m3u8';

        $process->outputScaledFile = $process->HLS_File_dir . '/video/scaled.m3u8';

        $process->generateHls(); // generate .m3u8 files

        if($process->generateMasterManifest($process->HLS_File_dir . '/audio/')){
             echo json_encode(array("response" => false, "message" => 'Encoding complete'));
        }; //write manifest file
    } else {
//            continue;
    }
//    }
}






