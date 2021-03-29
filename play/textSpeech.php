<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once 'vendor/autoload.php';


use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;

putenv("GOOGLE_APPLICATION_CREDENTIALS=NTSTraining-8d07a326d200.json");

//$cloud = new ServiceBuilder();

//$client = new Google_Client();
//$client->useApplicationDefaultCredentials();

$textToSpeechClient = new TextToSpeechClient();

$input = new SynthesisInput();
$input->setText('Japan\'s national soccer team won against Colombia!');
$voice = new VoiceSelectionParams();
$voice->setLanguageCode('en-US');
$audioConfig = new AudioConfig();
$audioConfig->setAudioEncoding(AudioEncoding::MP3);
//
$resp = $textToSpeechClient->synthesizeSpeech($input, $voice, $audioConfig);
//file_put_contents('test.mp3', $resp->getAudioContent());