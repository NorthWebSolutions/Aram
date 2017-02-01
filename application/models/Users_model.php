<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users_model
 *
 * @author mrgab
 */
class Users_model extends CI_Model{
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->library(array("Dns" => "DNS"));
    }
    
    
    public function reg_new_summoner() {
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            
                ///// SECURE THE PASSWORD: 
            $this->load->library(array ('Dns' => 'DNS'));
               
            $password = $this->input->post('password');
            $encrypted_Pw = $this->DNS->crypt_pass($password);

            $insert_Data = array(
                'username' => $username,
                'password' => $encrypted_Pw,
                'email' => $email,
                'active' => 1
            );
            // 2, push the data to db
            $this->db->insert('users', $insert_Data);
        
    }
    
    
    public function check_summoner($email, $PassWord) {
        
  
        $query = $this->db->get_where('users', array('email' => $email, 'password' => $PassWord));
        $row = $query->row();

        
        if (isset($row)){
            //// yes it is an array :) hurray... return TRUE
            
            
            $userNfo = array(
                'username' => $row->username,
                'email'     => $row->email,
                'nws_login' => TRUE
                 );
            
            
            $this->session->set_userdata($userNfo);
      
           
            return TRUE;
        }else{

            return   FALSE;
        }

        //return $query->row_array();
        
    }
    
    public function returnOnlyUsernames() {
        
        $query = $this->db->select('username')
                
                ->order_by('username')
                ->get('users');
        
        $result = $query->result();
        return $result;
        
    }
    
}
