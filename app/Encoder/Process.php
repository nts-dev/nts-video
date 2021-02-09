<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Process {

    public $master_dir;
    public $_file_dir; // dir to existing mp3 or mp4
    public $_file; //mp3 or mp4
    public $_id;
    public $inputFile;
    public $HLS_File_dir; //directory for new hls file
    public $outputFile;
    public $outputScaledFile; //640 scale
    private $manifestFile;

    function __construct() {

        $this->manifestFile = "manifest.m3u";
    }

    function createDirectory($dir) {
        if (!is_dir($dir))
            mkdir($dir, 0777, true);

        return true;
    }

    function generateHls() {
        $ffmpeg_path = 'C:\\ffmpeg\\bin\\ffmpeg ';

        $output = $this->outputFile;

        $scaled = $this->outputScaledFile;

        $input = $this->inputFile;

        $cmd640 = shell_exec(" $ffmpeg_path -i $input  -profile:v baseline -level 3.0 -s 640x360 -start_number 0 -hls_time 10 -hls_list_size 0 -f hls $scaled 2>&1");

        $cmdNormal = shell_exec(" $ffmpeg_path -i $input  -profile:v baseline -level 3.0  -start_number 0 -hls_time 10 -hls_list_size 0 -f hls $output 2>&1");

        if ($cmd640)
            return $cmd640;

        return false;
    }

    private function writeManifest($manifest) {
        if (is_dir($this->HLS_File_dir))
            $filename = "manifest.m3u";
        if (file_put_contents($this->HLS_File_dir . "/" . $filename, $manifest))
            return true;
        return false;
    }

    function generateMasterManifest($dir) {

        $filecount = 0;

        $directories = scandir($dir); // scan current directory if has sub dirs

        $manifest = '#EXTM3U' . "\r\n" . "\r\n";
//        $manifest .= '#EXT-X-MEDIA:TYPE=AUDIO,GROUP-ID="audio",LANGUAGE="eng",NAME="English",AUTOSELECT=YES,DEFAULT=YES' . "\r\n";

        foreach ($directories as $language_dir) {
            $code = "";

            if (ctype_alpha($language_dir)) {
                switch ($language_dir) {
                    case 'English':
                        $code = "eng";
                        break;
                    case 'French':
                        $code = "fr";
                        break;
                    case 'Dutch':
                        $code = "nl";
                        break;
                    case 'Spanish':
                        $code = "es";
                        break;
                    case 'German':
                        $code = "de";
                        break;
                    case 'Swahili':
                        $code = "sw";
                        break;
                }

                $files = glob($dir . $language_dir . "/*");

                if ($files) {
                    $filecount = count($files);
                    if ($filecount > 0)
                        $manifest .= '#EXT-X-MEDIA:TYPE=AUDIO,GROUP-ID="audio",LANGUAGE="' . $code . '",NAME="' . $language_dir . '", AUTOSELECT=YES, DEFAULT=NO,URI="audio/' . $language_dir . '/index.m3u8"' . "\r\n";
                }
            } // char is string     
        }

        $manifest .= '#EXT-X-STREAM-INF:BANDWIDTH=240000,RESOLUTION=416x234,CODECS="avc1.42e00a,mp4a.40.2", AUDIO="audio" ' . "\r\n";
        $manifest .= 'video/scaled.m3u8' . "\r\n" . "\r\n";

        $manifest .= '#EXT-X-STREAM-INF:BANDWIDTH=915905,RESOLUTION=960x540,CODECS="avc1.42e00a,mp4a.40.2", AUDIO="audio" ' . "\r\n";
        $manifest .= 'video/index.m3u8' . "\r\n";

        return $this->writeManifest($manifest);
    }

    function extractFileNameAndCreateSubDirrectory() {
        # code...
        $path_info = pathinfo($this->_file_dir . $this->_file);

        $type = $path_info['extension'];
        $name = $path_info['filename'];

        $file_dir = $this->master_dir . '/' . $name;

        $this->HLS_File_dir = $file_dir;

        if ($this->createDirectory($file_dir)) {
            //create sub dir to store video, audio and subtitle files
            $sub_dir_array = array("audio", "video", "sub");

            $lang_dir_array = array("English", "French", "Dutch", "Spanish", "German", "Swahili");

            if (is_dir($file_dir)) {
                foreach ($sub_dir_array as $dir) {
                    $sub_dir = $file_dir . '/' . $dir;
                    if ($this->createDirectory($sub_dir)) {
                        if ($dir == "audio") {
                            foreach ($lang_dir_array as $lang) {
                                $this->createDirectory($sub_dir . '/' . $lang);
                            }
                        }
                    }
                }
            }
        }
    }

    function extensionType() {
        $path_info = pathinfo($this->_file_dir . $this->_file);
        return $path_info['extension'];
    }

    function generateAudio() {
        $ffmpeg_path = 'C:\\ffmpeg\\bin\\ffmpeg ';

        $output = $this->outputFile;

        $input = $this->inputFile;

        $cmd = shell_exec("  $ffmpeg_path -i $input -c:v libx264 -c:a aac -strict -2 -f hls -hls_list_size 0 $output 2>$1");


        if ($cmd)
            return $cmd;

        return false;
    }

}
