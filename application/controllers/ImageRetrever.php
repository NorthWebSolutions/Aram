<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImageRetrever
 *
 * @author mrgab
 */
class ImageRetrever extends CI_Controller {

    //put your code here


    protected $RequestMainType;
    protected $IR_FAIL;
    protected $path_to_images = "/assets/images/";

    //private $


    public function __construct() {
        parent::__construct();
        $this->load->helper('file');


//        echo APPPATH;
//        echo "<br>";
//
//        $this->checkDirExist($this->path_to_images."chamionicons");
//        $this->checkDirExist(img_champ_id);
//        $this->checkDirExist($this->path_to_images."chamionicons/name");
    }

    /* $param can be a single ID or multiple */

    public function index($param = false) {


        //$param = array("34");

        $param = array( 266,103,84,12,32,34,1,22,136,268,432,53,63,201,51,164,69,31,
            42,122,131,119,36,245,60,28,81,9,114,105,3,41,86,150,79,104,120,74,420,
            39,427,40,59,24,126,202,222,429,43,30,38,55,10,85,121,203,240,96,7,64,89,
            127,236,117,99,54,90,57,11,21,62,82,25,267,75,111,76,56,20,2,61,80,78,133,
            33,421,58,107,92,68,13,113,35,98,102,27,14,15,72,37,16,50,134,223,163,91,44,17,
            412,18,48,23,4,29,77,6,110,67,45,161,254,112,8,106,19,101,5,157,83,154,238,115,26,143 );
        //$param = array_slice($param,0,10);
        $this->checkParam($param);



        switch ($this->RequestMainType) {

            case "array_request":
                echo "RequestMainType equals array_request<br>";

                foreach ($param as $value) {
                    //$this->SF->prh($value);


                    if ( file_exists(img_champ_id . $value . ".png") ) {
                        echo "THE FILE IS EXIST<br>";
                    } else {

                        echo "/" . img_champ_id . $value . ".png";

                        $curlArray = array(
                            'staticParam' => "champData=image",
                            'url'         => "/api/lol/static-data/{region}/v1.2/champion/$value",
                            'base'        => "https://global.api.pvp.net/",
                            'server'      => "eune"
                        );



                        $url    = $this->AC->buildCurl_extended($curlArray);
                        $result = $this->AC->getCurl($url);

                        //$this->SF->prh($result);


                        $statSrcPart                    = "http://ddragon.leagueoflegends.com/cdn/7.3.1/img/champion/";
                        ///req data: URL, Alt, Class, data-params
                        $returnData[$value]["url"]      = $statSrcPart . $result["image"]["full"];
                        $returnData[$value]["filename"] = $result["image"]["full"];
                    }

                    //ksort($returnData);
                    //$this->SF->prh($returnData);
                }
                if ( isset($returnData) ) {

                    foreach ($returnData as $key => $value) {

                        ///$this->SF->prh($value);

                        $url_to_save  = $value["url"];
                        $def_filename = $value["filename"];



                        if ( file_exists(img_champ_id . $value . ".png") ) {
                            echo 'FILE-Exists: ' . $key . ".png<br>";
                        } else {
                            echo 'FILE-NOT-Exists: ' . $key . ".png<br>";

                            if ( !copy($url_to_save,img_champ_id . "$key.png") ) {
                                $errors = error_get_last();
                                echo "COPY ERROR: " . $errors['type'];
                                echo "<br />\n" . $errors['message'];
                            } else {
                                echo "File copied from remote!";
                            }
                        }



//                    if ( file_exists("/" . img_champ_name . $def_filename) ) {
//                        echo 'FILE-Exists: ' . $def_filename . "<br>";
//                    } else {
//                        echo 'FILE-NOT-Exists: ' . $def_filename . "<br>";
//                         if ( !copy($url_to_save,img_champ_name . "$def_filename") ) {
//                            $errors = error_get_last();
//                            echo "COPY ERROR: " . $errors['type'];
//                            echo "<br />\n" . $errors['message'];
//                        } else {
//                            echo "File copied from remote!";
//                        }
//                    }
                    }
                }


                break;
            case "numeric_request":
                echo "RequestMainType equals numeric_request \n";
                // in this case we got a champion id
                // we need to retrive champ data
                // check is the id exist as an image

                $fileExistsBool = $this->checkFileExist($param . ".png");



                break;
            case "string_request":
                echo "RequestMainType string_request";
                break;
        }
    }

    public function checkParam($param) {

        if ( is_array($param) ) {
            $this->RequestMainType = "array_request";
        } elseif ( is_numeric($param) ) {
            $this->RequestMainType = "numeric_request";
        } elseif ( is_string($param) ) {
            $this->RequestMainType = "string_request";
        } else {
            return FALSE;
        }
    }

    public function StoreImages($imagesList) {
        
    }

    public function checkDirExist($dirName) {

        /* NOT WORKING ON DATAGLLOBE */
//        if ( !is_dir($dirName) ) {
//            echo "directory not exist: ' $dirName '";
//            if ( !mkdir($dirName,755,true) ) {
//                die('Failed to create folders...');
//            } else {
//                echo "directory created";
//            }
//        }

        if ( !is_dir($dirName) ) {
            echo "directory not exist: ' $dirName ' \n ";
        }
    }

    public function checkFileExist($filename) {


        $dataExist = false;

        if ( file_exists($this->path_to_images . $filename) ) {
            
        }
    }

}
