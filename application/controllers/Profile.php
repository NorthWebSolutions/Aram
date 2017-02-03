<?php

class Profile extends CI_Controller {

    //put your code here

    public static $form_vail_error_bool = FALSE;

    public function __construct() {
        parent::__construct();
        if($this->session->nws_login != TRUE){            redirect("Login/index");}
             $this->load->helper('form');

        
    }

    public function index() {
        
    }

    public function changeSummonerName() {
        $this->load->model('Users_model');
        $this->load->library('form_validation');
//                $this->SF->prh($_SESSION);
//        die;



   


        $this->form_validation->set_rules(
                  'username','Username','required|min_length[3]|max_length[18]|is_unique[users.username]',array(
            'required'  => 'You have not provided %s.',
            'is_unique' => 'This %s already exists.'
                  )
        );




        if ( $this->form_validation->run() == FALSE ) {

            //// return becouse something is missing or not good
            Profile::$form_vail_error_bool = TRUE;
            
            
            $data['title']                 = "Some data is missing..";

            $this->load->view('/templates/header',$data);

            $this->load->view('/templates/start_content',$data);
            $this->load->view('/templates/normal_navbar',$data);

            ///CONTENT
            $this->load->view('/profile/changesummonername');

            $this->load->view('/templates/stop_content',$data);
            $this->load->view('/templates/footer',$data);
        } else {
            //// Store USER DATA
            
            $this->Users_model->updateSummoner();
        // !!!!!!!!!!!!!! DONT FORGET -> Destroy session data to avoid mistake in sessions
            session_destroy();
            redirect('Home/index');
        }
    }

}
