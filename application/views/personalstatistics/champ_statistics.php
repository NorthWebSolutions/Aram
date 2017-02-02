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