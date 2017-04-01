<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProtoTypiser
 *
 * @author mrgab
 */
class ProtoTypiser extends CI_Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
       
        
       // if($this->session->nws_login != TRUE){            redirect("Login/index");}

        
    }
    
    public function index() {
        
        
        $tmp_ch_id = "143";
//          /api/lol/static-data/{region}/v1.2/champion/{id}
//          https://global.api.pvp.net/api/lol/static-data/eune/v1.2/champion/143?champData=image&api_key=RGAPI-c3556f5c-4cf3-40c8-981d-2815626365f6

        

            
            
            
            $data['title']                 = "PROTOTYPISER";
            


            $data["sr"] = $this->SR->returnChampImg("$tmp_ch_id");
            $this->load->view('/templates/header',$data);

            $this->load->view('/templates/start_content',$data);
            $this->load->view('/templates/normal_navbar',$data);

            ///CONTENT
            $this->load->view('/templates/champ_icons', $data);

            $this->load->view('/templates/stop_content',$data);
            $this->load->view('/templates/footer',$data);
        
    }
    
    

    
}
