<div class="container">
  <nav class="navbar navbar-default">
    <div class="container-fluid"> 
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" 
                data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> 
            
            <span class="sr-only">Toggle navigation</span> 
            <span class="icon-bar"></span> 
            <span class="icon-bar"></span> 
            <span class="icon-bar"></span> 
        </button>
        <a class="navbar-brand" href="<?php
                if (isset($brand_link)) {
                    echo "$brand_link";
                }
                else {
                    echo "#";
                }
                ?>"><?php echo $title; ?></a> </div>
      
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
            <li><a href="/PersonalStatistics/ChampionStatistics">Champions</a></li>
          <?php 
                    
                    $username = $_SESSION["username"];
                    $server = $_SESSION["server"];
                    
                    echo "<li><a href=\"/sync/$username/$server\"> <span class=\"glyphicon glyphicon-refresh\"></span> Sync my data</a></li>";
                    
                    
                              
                              ?>
            
            <li><a href="/"><span class="glyphicon glyphicon-home"></span> Home</a></li>
            <li><a href="/login/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
      </div>
      <!-- /.navbar-collapse --> 
    </div>
    <!-- /.container-fluid --> 
  </nav>
</div>
