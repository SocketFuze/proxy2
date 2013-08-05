<?php

  if (!defined("_VALID_PHP"))

      die('Direct access to this location is not allowed.');



  if(!$user->getAcl("AddList")): print $core->msgAlert(_CG_ONLYADMIN, false); return; endif;

?>

<div class="block-top-header">

  <h1><img src="images/backup-sml.png" alt="" />Proxy - Add List</h1>

  <div class="divider"><span></span></div>

</div>

<p class="info"><span><?php echo $core->langIcon();?></span>Add proxies / lists to the database.</p>

<div class="block-border">

  <div class="block-header">

    <h2>Add New List</h2>

  </div>

  <div class="block-content">
  
  <form method="post" action="" id="admin_form_add" name="admin_form_add" style="width: 100%;">

      <table class="forms">

        <tr>

          <td>
          
            Allowed Type(s) For Adding: 
            
            <select style="padding: 2px;">            
                <option value="all">All Types</option>            
                <option value="http">HTTP</option>            
                <option value="https">HTTPS</option>            
                <option value="socks5">Socks 5</option>            
                <option value="socks4">Socks 4</option>          
            </select>              
              
          </td>

        </tr>

      </table>        

    <div id="backup" class="box clearfix">
      
		<textarea name="ipaddress" id="ipaddress" rows="3" style="background-color: #4F4646; color: #36B36A; padding: 10px; margin-bottom: 10px; width: 580px; height: 380px;" onfocus="clickclear(this, 'IP:Port')" onblur="clickrecall(this,'IP:Port')">IP:Port</textarea>        
		<p id="checker-form-toolbar">            
          <a class="button-blue postProxy" data-fancybox-type="ajax" href="processProxy.php" id="btnAdd">Add Proxies</a>  
                  
    </div>
    
    </form>

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
  
  $('#btnAdd').on("click", function (e) {
    $(this).text("Adding Proxies...");
    e.preventDefault();
    ajaxManager.addReq({
      type: "POST",
      cache: false,
      url: this.href,
      data: $("#admin_form_add").serializeArray(),
      success: function (data) {        
		$.fancybox(data, {
          fitToView: false,
          width: 905,
          height: 505,
          autoSize: false,
		  beforeClose:function(){ $('#btnAdd').text("Proxies Added"); }
        }); // fancybox
		next();		
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
<script type="text/javascript">
function clickclear(thisfield, defaulttext) {
if (thisfield.value == defaulttext) {
thisfield.value = "";
}
}
function clickrecall(thisfield, defaulttext) {
if (thisfield.value == "") {
thisfield.value = defaulttext;
}
}
</script>