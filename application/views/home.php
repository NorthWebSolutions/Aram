<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$data['title'] = "Welcome Summoner" ;
        $this->load->view('/templates/header', $data);
        
        $this->load->view('/templates/start_content', $data);
       

//if(!isset($chk_summoner_login) || !$chk_summoner_login){
//    $this->load->view('/forms/login_box', $data);
//
//}
        
        $this->load->view('/home/lol_logo_div', $data);
        $this->load->view('/home/content', $data);
        $this->load->view('/forms/login_box', $data);
        
        $this->load->view('/templates/stop_content', $data);
        $this->load->view('/templates/footer', $data);
        
        
        
        ?> 
        