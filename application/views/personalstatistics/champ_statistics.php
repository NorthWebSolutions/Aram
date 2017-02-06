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
                //$this->SF->prh($championArray);

                $img        = $this->SR->returnChampImg($champId);
                $img_string = $img["img"];

                ?>
<div class="row"><div class="col-md-12"><hr></div>
                <div class="row">
                    <div class="col-md-5"><?php echo "$img_string"; ?></div>
                    <div class="col-md-7">
                        <span class="championName"><?php echo "$champName"; ?></span><br>
                        <span class="championStat"><?php echo " $win / $lose <br><small>$kda</small> "; ?></span>
                    </div>
                </div>
        
            
            </div>

    <?php }
} ?>
    </div> </div>