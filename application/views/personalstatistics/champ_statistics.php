<div class="col-md-12 stat_panel">
  <div class="text-center">
    <h4>Your best champions</h4>
    <?php

        foreach ($MVC_data as $key => $value) {
            //$this->SF->prh($value);

            $win           = $value["win"];
            $lose          = $value["lose"];
            $kda           = $value["kda"];
            $championArray = json_decode($value["championArray"]);
            if ( $championArray != FALSE ) {


                $champName = $championArray->name;
                $champId   = $championArray->id;
                
                             $championImageData["url"] = IMG_path."/championicons/id/$champId.png";
                              $championImageData["alt"] = $champName;
                            $championImageData["class"] = "img img-circle img-responsive";
                            $championIMG = $this->SR->imgWrapper($championImageData);
                //$this->SF->prh($championArray);

//                $img_string = $img["img"];
//                $img        = $this->SR->returnChampImg($champId);

                ?>
    <div class="row">
      <div class="col-md-12">
        <hr>
      </div>
      <div class="row">
        <div class="col-md-5"><?php echo "$championIMG"; ?></div>
        <div class="col-md-7"> <span class="championName"><?php echo "$champName"; ?></span><br>
          <span class="championStat"><?php echo " $win / $lose <br><small>$kda</small> "; ?></span> </div>
      </div>
    </div>
    <?php }
} ?>
  </div>
</div>
