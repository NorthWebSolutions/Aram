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

        /// if not loged in
        if($this->session->nws_login != TRUE){
            redirect("Login/index");
        }
        

        /// if loged in but dont have summonerID
        if($this->session->nws_login === TRUE && !isset($_SESSION['summonerid'])){
            
            //triger SummonerId Search
            
                        $search = array(" ");
            $replace = array("");
            $summ_sm      = str_replace($search, $replace,strtolower( $_SESSION["username"]));
            $summonerServer = $this->session->server;
            $summonerID    = $this->RAH->getSummonerIdBySummonerName($summ_sm, $summonerServer);          
            

            
        if(isset($summonerID["status"]["status_code"]) && $summonerID["status"]["status_code"] == "404"){
            redirect("Profile/changeSummonerName");
        }
        
            
            
           
  
            
            $userNfo = array(
                'summonerid' => $summonerID[$summ_sm]["id"],
                'profileIconId' => $summonerID[$summ_sm]["profileIconId"],
                'summonerLevel' => $summonerID[$summ_sm]["summonerLevel"]);
            
            
            $this->session->set_userdata($userNfo);
           
        } 
        
        /// else
         redirect("PersonalStatistics/overview");
        
//            $data['title'] = "Welcome Summoner";           
//            redirect("PersonalStatistics/overview");
        
    }
}
