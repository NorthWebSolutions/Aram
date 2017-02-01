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
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="panel-title text-center">Welcome Summoner</div>
    </div>
    <div class="panel-body">
<table class="table stat_panel">
<thead>
    <tr><th colspan="2" class="text-center "><h3><?php echo ucfirst($this->session->username); ?><br />
<small>Aram stats:</small></h3></th></tr>
    
</thead>
<tbody>
  <tr>
    <td colspan="2"><h3>Database statistics:</h3></td>

  </tr>
  <tr> 
    <td>Total Mach:</td>
    <td><?php  echo "$totalMach";?></td>
  </tr>
  <tr>
    <td>Wins:</td>
    <td><?php echo "$winsAllFromDB";?></td>
  </tr>
  <tr>
    <td>Loses:</td>
    <td><?php echo "$losesAllFromDB";?></td>
  </tr>
  <tr>
    <td>Win Percent:</td>
    <td><?php echo "$winPercent%";?></td>
  </tr>
  <tr>
      <td colspan="2" class="text-center"><h3>Your Top 10 Aram champion</h3> </td>

  </tr>
  
  <?php 

    foreach ($MVC_data as $key => $value) {
      //$this->SF->prh($value);
      $win = $value["win"];
      $lose = $value["lose"];
      $champ_array = json_decode($value["championArray"]);

      $champName = $champ_array->name;
      $championArray = $value["championArray"];
      
      
      ?>
      

  <tr>
      <td colspan="2" class="h6"><?php  echo "champ_img <br> $champName"; ?></td>

  </tr>
    <tr>
    <td><?php  echo "Wins: $win"; ?></td>
    <td><?php echo "Loses: $lose"; ?></td>
  </tr>
     <?php }?>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</tbody>
</table>


        </div>
  </div>
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
