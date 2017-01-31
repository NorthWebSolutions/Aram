<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Home
 *
 * @author mrgab
 */
class Home extends CI_Controller
{
    //put your code here
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        
        
        
        
//        $this->load->helper('Url');
//        $this->load->library(array(
//            'Dns' => 'DNS'
//        ));
        //$this->load->helper('form');
        
        
        //////////// redirects
        //  PLEASE REDIRECT EVERTHYING BELLOW
        //
        //print_r($_SESSION);
        /// if not loged in
        if($this->session->nws_login != TRUE){
            redirect("Login/index");
        }
        

        /// if loged in but dont have summonerID
        if($this->session->nws_login === TRUE && !isset($_SESSION['summonerid'])){
            
            //triger SummonerId Search
            $summonerName = $_SESSION["username"];
            $summ_sm       = strtolower($summonerName);
            $summonerID    = $this->RAH->getSummonerIdBySummonerName($summonerName);          
            
            //
            $this->SF->prh($summonerID);
            
        if(isset($summonerID["status"]["status_code"]) && $summonerID["status"]["status_code"] == "404"){
            redirect("Profile/changeSummonerName");
        }
        
            
            
           
  
            
            $userNfo = array(
                'summonerid' => $summonerID[$summ_sm]["id"],
                'profileIconId' => $summonerID[$summ_sm]["profileIconId"],
                'summonerLevel' => $summonerID[$summ_sm]["summonerLevel"]);
            
            
            $this->session->set_userdata($userNfo);
        }      
         redirect("PersonalStatistics/overview");
        
//            $data['title'] = "Welcome Summoner";           
//            redirect("PersonalStatistics/overview");
        
    }
}
