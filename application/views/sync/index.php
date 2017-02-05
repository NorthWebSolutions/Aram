<?php 

    if(isset($tmp_data) && $tmp_data != FALSE){
        foreach ($tmp_data as $data_row){
           
                      $this->SF->prh($data_row);
        }
    } else {
    echo "<h4>No syncronisation reqired - all data stored in the DB</h4>";
}

?>