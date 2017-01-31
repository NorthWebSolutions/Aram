<?php

class Profile extends CI_Controller {

    //put your code here

    public static $form_vail_error_bool = FALSE;

    public function __construct() {
        parent::__construct();
    }
    public function index() {
        
        
        
    } 
    
    public function changeSummonerName() {
        
        // !!!!!!!!!!!!!! DONT FORGET -> Destroy session data to avoid mistake in sessions
        //session_destroy();

        $this->load->view('/profile/changesummonername');

    }
}