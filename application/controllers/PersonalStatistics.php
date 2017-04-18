<?php

class PersonalStatistics extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();

        if ( $this->session->nws_login != TRUE ) {
            redirect("Login/index");
        }
        $this->load->model('aram_model');
    }

    public function overview() {

        if ( $this->session->flashdata('msg') ) {
            $data['FLASH_MSG'] = $this->session->flashdata('msg');
        }

        //$this->SF->prh($_SESSION);
        //$personal_id = $this->RAH->getSummonerIdBySummonerName("");
        $data['title'] = "Personal Statistics GUI 0.2";

        $data['DataBaseData'] = $this->aram_model->getAllAramStatForUser($this->session->summonerid);

        //$this->SF->prh($data["DataBaseData"]);

        $this->load->view('/templates/header',$data);

        $this->load->view('/templates/start_content',$data);
        $this->load->view('/templates/normal_navbar',$data);

        if ( !$data["DataBaseData"] ) {
            $this->load->view('/personalstatistics/no_content',$data);
        } else {

            $mvc_data = $this->MWC(5);

            //$this->SF->prh($data['DataBaseData']);
            
          
            
            $totalMach = count($data['DataBaseData']);

            $winsAllFromDB = 0;
            $losesAllFromDB = 0;






            foreach ($data['DataBaseData'] as $key => $value) {
                if ($value["gameIsWin"]) {
                    $winsAllFromDB++;
                } else {
                    $losesAllFromDB++;
                }
            }



$winPercent_num = ($winsAllFromDB / $totalMach ) *100 ;

$winPercent = round( $winPercent_num , 1, PHP_ROUND_HALF_UP);

            

            $data["MVC_data"] = $mvc_data; // $mvc_data;



            $data["totalMach"]      = $totalMach;
            $data["winsAllFromDB"]  = $winsAllFromDB;
            $data["losesAllFromDB"] = $losesAllFromDB;
            $data["winPercent"]     = $winPercent;
            $this->load->view('/personalstatistics/content',$data);
        }
        $this->load->view('/templates/stop_content',$data);
        $this->load->view('/templates/footer',$data);
    }

    public function MWC($slice) {    /////////// Most Wins with Champions
        //////STATIC DATA ----> PLEASE REPLACE WITH FILTERED API SEARCH
        $champIds = array( 266,103,84,12,32,34,1,22,136,268,432,53,63,201,51,164,69,31,
            42,122,131,119,36,245,60,28,81,9,114,105,3,41,86,150,79,104,120,74,420,
            39,427,40,59,24,126,202,222,429,43,30,38,55,10,85,121,203,240,96,7,64,89,
            127,236,117,99,54,90,57,11,21,62,82,25,267,75,111,76,56,20,2,61,80,78,133,
            33,421,58,107,92,68,13,113,35,98,102,27,14,15,72,37,16,50,134,223,163,91,44,17,
            412,18,48,23,4,29,77,6,110,67,45,161,254,112,8,106,19,101,5,157,83,154,238,115,26,143 );
        sort($champIds);
        //$this->SF->prh($champIds);


        foreach ($champIds as $key => $value) {
            $final_data[$value] = array( "win" => 0,"lose" => 0,"championArray" => "" );
        }

        $mwc = $this->aram_model->get_Champ_wins_at_aram($this->session->summonerid);
        foreach ($mwc as $row) {

            $final_data[$row->champion]["championArray"] = $row->championArray;
            if ( $row->gameIsWin ) {
                $final_data[$row->champion]["win"] ++;
            } else {
                $final_data[$row->champion]["lose"] ++;
            }
        }
        //arsort($final_data)
        ///KDA calculation
        foreach ($final_data as $key => $value) {


            $wins  = $value["win"];
            $loses = $value["lose"];
            $total = $wins + $loses;

            $new_kda_line = (( 2500 + $total ));
            $kda_los      = ($loses * 10);
            $kda_pos      = ($wins * 10);

            $kda_calc = $new_kda_line - $kda_los + $kda_pos;

            //$kda = round( ($wins /  ($wins + $loses)) + (1000 * $wins) - (1000 * $loses) , 1);
            $kda_data["$kda_calc"]["$key"]        = $value;
            $kda_data["$kda_calc"]["$key"]["kda"] = $kda_calc;

            krsort($kda_data);
            //$this->SF->prh($kda_data);
        }

        $ordered_champs = array();
        /// filter the data return only the requested slices
        foreach ($kda_data as $key => $value) {
            foreach ($value as $sub_key => $sub_value) {
                $ordered_champs[$sub_key] = $sub_value;
            }
        }

        //$this->SF->prh($ordered_champs);
        $newArray = array_slice($ordered_champs,0,$slice,true);
        //this->SF->prh($newArray);
        return $newArray;
    }

}
