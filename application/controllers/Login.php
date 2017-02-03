<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author mrgab
 */
class Login extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->library(array("Dns" => "DNS"));
        $this->load->helper('form');
    }

    public function index() {
        
           if($this->session->nws_login == TRUE){
            redirect("Home/index");
        }
        
        $data['title'] = "Summoner Login" ;
    
        
    if($this->session->flashdata('msg')){
         $data['FLASH_MSG'] = $this->session->flashdata('msg');
     
    }
        

        $this->load->view('/templates/header', $data);
        
        $this->load->view('/templates/start_content', $data);
        $this->load->view('/home/lol_logo_div', $data);     

        $this->load->view('/home/content', $data);
        
        $this->load->view('/forms/login_box', $data);
        
        $this->load->view('/templates/stop_content', $data);
        $this->load->view('/templates/footer', $data);
    }

    public function userLogin() {
        
//        if($data["chk_summoner_login"]){die ("Multiple login? ");}

        $email = $this->input->post('email');
  

        $password = $this->DNS->crypt_pass($this->input->post('password'));

        $this->load->model('Users_model');
        $login_bool = $this->Users_model->check_summoner($email, $password);
        
        if($login_bool){
            
            /// if login data provided is exist in the database:
            $this->session->set_flashdata('msg', 'Login success!',"true");
            redirect("/Home/index");
             
    
            
            
            
        }else{
             
            $this->session->set_flashdata('msg', 'Failed Login, there are no maching data.',"true");
            redirect("/Login/index");
    }
        
        
       
        
        
    }
    
    
    function logout() {
        session_destroy();
        redirect("/Home/index");
    }
    
    
    
    
    
}
