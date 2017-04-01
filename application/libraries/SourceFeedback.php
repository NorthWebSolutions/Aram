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
       // echo "<div class=\"container debug_line\">";
        echo "<pre>";
        //echo "<h6>Debug Panel</h6><hr>";
        print_r($param);
        echo "</pre>";
       //echo "</div>";
        
    }
    
    

}

