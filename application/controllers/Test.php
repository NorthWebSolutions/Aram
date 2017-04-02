<?php

class Test extends CI_Controller {

    //put your code here

    public static $form_vail_error_bool = FALSE;

    public function __construct() {
        parent::__construct();
        if($this->session->nws_login != TRUE){            redirect("Login/index");}
                     $this->load->model('aram_model');
        

        
    }

    public function index($chkthis) {
        

                  
        $data['title'] = "RiotSync App";
        $this->load->view('/templates/header',$data);
        $this->load->view('/templates/start_content',$data);
        $chk_val = $this->aram_model->checkDatabasesForThisGameId($chkthis);
        $this->SF->prh($chk_val);
        $this->load->view('/templates/stop_content',$data);
        $this->load->view('/templates/footer',$data);
        
    }

   

}
