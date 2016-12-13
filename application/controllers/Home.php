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
class Home extends CI_Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        
        $this->load->helper('form');
        $this->load->library(array ('Dns' => 'DNS'));
        
        
        
        
        
        $data['title'] = "Welcome Summoner" ;
        $data['crypted_str'] = $this->DNS->crypt_pass('YedQ?!E>E2HLX`NF');
        
        $this->load->view('/templates/header', $data);
        $this->load->view('/templates/normal_navbar', $data);
        $this->load->view('/templates/start_content', $data);
        $this->load->view('/templates/debug_box', $data);
        $this->load->view('/forms/login_box', $data);
        $this->load->view('/templates/stop_content', $data);
        $this->load->view('/templates/footer', $data);
        
    }
}
