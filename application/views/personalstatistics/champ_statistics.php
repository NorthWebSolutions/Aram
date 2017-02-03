<div class="col-md-12 stat_panel">
    
 <div class="text-center">
 
    <h4>Your best champions</h4>

<?php

foreach ($MVC_data as $key => $value) {
    //$this->SF->prh($value);
  
    $win         = $value["win"];
    $lose        = $value["lose"];
    $kda        = $value["kda"];
    $championArray = json_decode($value["championArray"]);
    if($championArray != FALSE){
        
    
    $champName     = $championArray->name;
    //$this->SF->prh($championArray);
   
    
    

    ?>

 <div class="row">
    <div class="col-md-12"><!--Dinamic summoner icon generator --></div>
    <div class="col-md-12"><span class="championName"><?php echo "$champName"; ?></span></div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <h5 class="championStat"><?php echo " $win / $lose <br><small>$kda</small> "; ?></h5>
    </div>
  </div>

<?php  }} ?>
</div> </div>