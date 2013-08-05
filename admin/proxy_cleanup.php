<?php

  if (!defined("_VALID_PHP"))

      die('Direct access to this location is not allowed.');



  if(!$user->getAcl("Cleanup")): print $core->msgAlert(_CG_ONLYADMIN, false); return; endif;

?>

<div class="block-top-header">

  <h1><img src="images/backup-sml.png" alt="" />Proxy - Check &amp; Cleanup</h1>

  <div class="divider"><span></span></div>

</div>

<p class="info"><span><?php echo $core->langIcon();?></span>Check all the proxies in the database and remove any dead records.</p>

<div class="block-border">

  <div class="block-header">

    <h2>Check Database + Remove Dead</h2>

  </div>

  <div class="block-content">

      <table class="forms">

        <tr>

          <td>
          
              <form method="post" action="" id="admin_form_cleanup" name="admin_form_cleanup" style="float: left;">
    
                <a id="btnCleanup" type="submit" class="button-blue" href="cron.php">Run Cleanup</a>
                
              </form>
              
              <form method="post" action="" id="admin_form_cleanup" name="admin_form_cleanup" style="float: left; margin-left: 10px;">
              
                <a id="btnCheckup" type="submit" class="button-blue" href="cron.php">Run Checkup</a>
                
              </form>
          
          </td>

        </tr>

      </table>        

    <div id="backup" class="box clearfix">
      
		<div id="cleanupDiv"> </div>
        <div id="checkupDiv"> </div>
        
    </div>

    <div class="box clearfix">
    
    	<div>Last Checked: 20 August 2013 (8:24 PM) <span style="float: right;">Number Of Records: 10</span></div>

    </div>

  </div>

</div>
<script src="<?php echo SITEURL;?>/assets/main.js" type="text/javascript"></script>
<script>
/* <![CDATA[ */
$(document).ready(function () {
	
  ajaxManager.run();
  
  $('#btnCleanup').on("click", function (e) {
    $(this).text("Running Cleanup...");
    e.preventDefault();
    ajaxManager.addReq({
      type: "POST",
      cache: false,
      url: this.href,
      data: $("#admin_form_cleanup").serializeArray(),
      success: function (data) {        
		$("#cleanupDiv").html(data);
		next();		
		$(this).text("Cleanup Done");
      }, // success
	  failure: function(data){
      	next();
      }, // failure
      error: function(data){
      	next();
      } // error
    }); // ajax
  }); // on
  
  $('#btnCheckup').on("click", function (e) {
    $(this).text("Running Checkup...");
    e.preventDefault();
    ajaxManager.addReq({
      type: "POST",
      cache: false,
      url: this.href,
      data: $("#admin_form_checkup").serializeArray(),
      success: function (data) {        
		$("#checkupDiv").html(data);
		next();
		$(this).text("Checkup Done");
      }, // success
	  failure: function(data){
      	next();
      }, // failure
      error: function(data){
      	next();
      } // error
    }); // ajax
  }); // on
  
}); // ready
/* ]]> */
</script>
