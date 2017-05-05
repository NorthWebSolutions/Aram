
<div class="col-md-4 col-md-offset-4">
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="panel-title text-center">Welcome Summoner</div>
    </div>
    <div class="panel-body ">
      <p class="text-center"> Your summoner name not exist, <br>
        please change it to vaild.</p>
      <?php if ( Profile::$form_vail_error_bool) { ?>
      <div class="panel-footer danger"> <?php echo validation_errors(); ?> </div>
      <?php } ?>
      <?php echo form_open('profile/changeSummonerName'); ?>
      <div class="form-group">
        <h5 class="sr-only">select server:</h5>
<?php  echo form_dropdown('server', unserialize(SRV_LIST), 'euw', "class='form-control'")?>
        </select>
      </div>
      <div class="form-group">
        <h5 class="sr-only">Your Summoner Name</h5>
        <input type="text" name="username" value="<?php echo set_value('username'); ?>" size="50"  class="form-control" placeholder="Your Summoner Name"/>
      </div>
      <div class="h5 text-center">
        <input type="submit" value="change my name" class="btn btn-default"/>
        <br>
        <br>
        <a href="/login/logout" class="small">Back to login</a> </div>
    </div>
  </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</div>
