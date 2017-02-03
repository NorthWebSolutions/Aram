<?php     



if($this->session->flashdata('msg')){?>

<div class="SiteResponds"> <?php echo  $FLASH_MSG;?> </div>
<?php     } ?>
      <?php
///// get statistic: 
//    totalmach
$totalMach = count($DataBaseData);

$winsAllFromDB = 0;
$losesAllFromDB = 0;






foreach ($DataBaseData as $key => $value) {
    if ($value["gameIsWin"]) {
        $winsAllFromDB++;
    } else {
        $losesAllFromDB++;
    }
}



$winPercent_num = ($winsAllFromDB / $totalMach ) *100 ;

$winPercent = round( $winPercent_num , 1, PHP_ROUND_HALF_UP);






?>
<div class="col-md-3">
<?php $this->load->view("personalstatistics/left_panel_dock");?>    
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
        
        <th>Damage Dealt<br />
<small>to champions</small></th>
        <th>Damage Taken<br />

         <small>by champions</small></th>
        <th>IP <small>earned</small></th>
        
          </thead>
      <tbody>
        <?php
                        $i = 1;
                        foreach ($DataBaseData as $key => $value) {




                            $gameId = $value["gameID"];
                            //$mapId = $value["mapID"];
                            $gameMode = $value["gameMode"];
                            $teamId = $value["teamID"];
                            $ipEarned = $value["ipEarned"];
                            $createDate = $value["gameDate"];
                            $totalDamageDealt = $value["totalDamage"];
                            $totalDamageTaken = $value["totalDamageTaken"];



                            $game_isWin = $value["gameIsWin"];
                            $championID = $value["champion"];
                            if($value["championArray"] != Null){
                            $championName = $value["championArray"]->name;
                            $championTitle = $value["championArray"]->title;
                            }

                            if ($game_isWin) {
                                echo "<tr class=\"success\">";
                            } else {
                                echo "<tr class=\"warning\">";
                            }
                            echo "<td  class=\"status_color\">&nbsp;</td>";
                            
                            
                            
                            if($value["championArray"] != Null){
                                echo "<td>$championName <small>$championTitle</small></td>"; 
                                
                            }else{
                                    echo "<td>$championID</td>"; 
                                }
                            
                            echo "<td> $totalDamageDealt </td>
                                    <td> $totalDamageTaken</td>
                                    <td> $ipEarned </td>";

                            $i++;
                        }
                        ?>
          </tr>
        
      </tbody>
    </table>
  </div>
</div>
