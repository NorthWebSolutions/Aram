<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of sourceFeedback
 *
 * @author mrgab
 */
class sourceFeedback {
    //put your code here
    public function __construct() {
        
    }
    
    public function prh($param) {
        
        echo "<pre>";
        print_r($param);
        echo "</pre>";
        
    }
}