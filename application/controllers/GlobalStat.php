<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GlobalStat
 *
 * @author mrgab
 */
class GlobalStat extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('aram_model');
    }
    
    public function index() {
        $data = $this->aram_model->getAllChampionStat();
        //$this->SF->prh($data);
        
        $GSC = array(''); ///globalStatforChampion
        
        foreach ($data as $value) {
            
            if(in_array($value->champion, $GSC)){
                $GSC[$value->champion] = $value->statArray;
            }else{
    array_push($GSC, $value)
    $GSC[$value->champion] = $value->statArray;
            }
            
            
        }
        $this->SF->prh($GSC);
    }
}
