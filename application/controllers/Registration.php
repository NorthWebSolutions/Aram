<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Registration
 *
 * @author mrgab
 */
class Registration extends CI_Controller {

    //put your code here

    public static $form_vail_error_bool = FALSE;

    public function __construct() {
        parent::__construct();
    }

    public function index() {


        $this->load->helper('form');
        $this->load->library(array( 'Dns' => 'DNS'));

        
        $data['SERVERS_list']   = unserialize (SRV_LIST);
        $data['title'] = "Registration";
        //$data['crypted_str'] = $this->DNS->crypt_pass('YedQ?!E>E2HLX`NF');

        $this->load->view('/registration/index',$data);
    }

    public function addnewsummoner() {
        $this->load->model('Users_model');
        $this->load->library('form_validation');


        $this->form_validation->set_rules(
                  'username','Username','required|min_length[3]|max_length[18]|is_unique[users.username]',array(
            'required'  => 'You have not provided %s.',
            'is_unique' => 'This %s already exists.'
                  )
        );
        $this->form_validation->set_rules('password','Password','trim|required|min_length[6]');
        $this->form_validation->set_rules('passconf','Password Confirmation','trim|required|matches[password]');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[users.email]');



        if ( $this->form_validation->run() == FALSE ) {

            //// return becouse something is missing or not good
            Registration::$form_vail_error_bool = TRUE;
            $data['title']                      = "Registration FAIL";
            $this->load->view('/registration/index',$data);
        } else {
            //// Store USER DATA
            $this->Users_model->reg_new_summoner();

            ///Set Status_msg
            $this->session->set_flashdata('msg','Registration success!',"true");
            redirect('Login/index');
        }
    }

}
