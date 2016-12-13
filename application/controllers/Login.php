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
    }

    public function index() {

        $this->load->helper('form');






        $data['title'] = "Registration";
        //$data['crypted_str'] = $this->DNS->crypt_pass('YedQ?!E>E2HLX`NF');

        $this->load->view('/templates/header', $data);
        $this->load->view('/templates/normal_navbar', $data);
        $this->load->view('/templates/start_content', $data);

        $this->load->view('/forms/login_box', $data);
        $this->load->view('/templates/stop_content', $data);
        $this->load->view('/templates/footer', $data);
    }

    public function userLogin() {

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $password = $this->DNS->crypt_pass($password);

        $this->load->model('Users_model');
        $data['chk_summoner_login'] = $this->Users_model->check_summoner($username, $password);
        
        $this->load->view('login/success_login', $data);
    }
}
