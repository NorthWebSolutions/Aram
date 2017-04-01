<?php if ( $this->session->flashdata('msg') ) { ?>

    <div class="SiteResponds"> <?php echo $FLASH_MSG; ?> </div>
<?php } ?>
<?php

///// get statistic: 
//    totalmach
$totalMach = count($DataBaseData);

$winsAllFromDB  = 0;
$losesAllFromDB = 0;






foreach ($DataBaseData as $key => $value) {
    if ( $value["gameIsWin"] ) {
        $winsAllFromDB++;
    } else {
        $losesAllFromDB++;
    }
}



$winPercent_num = ($winsAllFromDB / $totalMach ) * 100;

$winPercent = round($winPercent_num,1,PHP_ROUND_HALF_UP);

?>
<div class="col-md-3">
<?php $this->load->view("personalstatistics/left_panel_dock"); ?>    
</div>


<div class="col-md-9">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">Our Database sotred data from ARAM history:</div>
        </div>
        <table class="table stat_panel ">
            <thead>
            <th>&nbsp;</th>
            <th>Champion</th>
<th class="text-center" >K/D/A <br /><small>Creeps</small> </th>
            <th class="text-center">Damage Dealt<br />
                <small>to champions</small></th>
            <th class="text-center">Damage Taken<br />

                <small>by champions</small></th>
                        <th class="text-center">Gold Earned<br />

                <small>not-spent</small></th>
            <th class="text-center">IP <small>earned</small><br/><small>Game Time</small></th>

            </thead>
            <tbody>
<?php


foreach ($DataBaseData as $key => $value) {
    
    
   $statsObj = $value["statsArray"];
   
   $kills = $statsObj->championsKilled;
   $level = $statsObj->level;
   $numDeaths = $statsObj->numDeaths;
   $goldSpent = $statsObj->goldSpent;
   $goldEarned = $statsObj->goldEarned;
   $goldDef = $goldEarned-$goldSpent;
   $minionsKilled = $statsObj->minionsKilled;
   $time = $statsObj->timePlayed;
   $assists = $statsObj->assists;

   


    $gameId           = $value["gameID"];
    //$mapId = $value["mapID"];
    $gameMode         = $value["gameMode"];
    $teamId           = $value["teamID"];
    $ipEarned         = $value["ipEarned"];
    $createDate       = $value["gameDate"];
    $totalDamageDealt = $value["totalDamage"];
    $totalDamageTaken = $value["totalDamageTaken"];



    $game_isWin = $value["gameIsWin"];
    $championID = $value["champion"];
    if ( $value["championArray"] != Null ) {
        $championName  = $value["championArray"]->name;
        $championTitle = $value["championArray"]->title;
        $champId       = $value["championArray"]->id;




        $img_opt                    = array( 'class' => "img img-circle champ-icon sml" );
        $championImageData["url"]   = IMG_path . "/championicons/id/$champId.png";
        $championImageData["alt"]   = $championName;
        $championImageData["class"] = "img img-circle champ-icon sml";
        $championIMG                = $this->SR->imgWrapper($championImageData);
    }

    if ( $game_isWin ) {
        echo "<tr class=\"success\">";
    } else {
        echo "<tr class=\"warning\">";
    }
    echo "<td  class=\"status_color\">$championIMG</td>";



    if ( $value["championArray"] != Null ) {
        echo "<td>$championName <small><br>$championTitle</small></td>";
    } else {
        echo "<td>$championID</td>";
    }
echo "<td class=\"text-center\">$kills/$numDeaths/$assists<br>$minionsKilled</td>";
    echo "<td class=\"text-center\"> $totalDamageDealt </td>";
                                    echo "<td class=\"text-center\"> $totalDamageTaken</td>";
                                    echo "<td class=\"text-center\"> $goldEarned <br> $goldDef </td>";
                                    echo "<td class=\"text-center\"> $ipEarned <br> $time </td>";

}

?>
                </tr>

            </tbody>
        </table>
    </div>
</div>
