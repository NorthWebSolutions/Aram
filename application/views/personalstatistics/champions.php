<div class="container">
    <div class="row">

            <?php

            foreach ($MWC as $key => $value) {

                $win           = $value["win"];
                $lose          = $value["lose"];
                $kda           = $value["kda"];
                $championArray = json_decode($value["championArray"]);
                if ( $championArray != FALSE ) {


                    $champName = $championArray->name;
                    $champId   = $championArray->id;

                    $championImageData["url"]   = IMG_path . "/championicons/id/$champId.png";
                    $championImageData["alt"]   = $champName;
                    $championImageData["class"] = "img img-circle img-responsive center-block champ-icon  ";
                    $championIMG                = $this->SR->imgWrapper($championImageData);

                    ?>
                    
                    <div class="col-md-2">
                    <div class="panel panel-default champ_box">
                    <div class="panel-body">
                    <div class="champImg"><?php echo $championIMG; ?> </div>
                    
                    <div class="champText text-center"><?php echo "$champName<br>"; ?>
                                <?php echo " $win / $lose <br><small>$kda</small> "; ?> </div>
                    </div>
                    </div>
                    </div>
                        
                            
                <?php }
            }

            ?>

    </div>
</div>
