<?php
define("BASE_URL",'http://www.socketfuze.net');
?>
<html>
<head>
<link href="http://fonts.googleapis.com/css?family=Dosis:300,400,600,,700" media="all" rel="stylesheet" type="text/css" />

<link href="<?=BASE_URL;?>/theme/quadro/css/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?=BASE_URL;?>/assets/jquery.js"></script>

<script type="text/javascript" src="<?=BASE_URL;?>/assets/jquery-ui.js"></script>

<script type="text/javascript" src="<?=BASE_URL;?>/assets/tables.js"></script>

<script type="text/javascript" src="<?=BASE_URL;?>/assets/global.js"></script>

<script type="text/javascript" src="<?=BASE_URL;?>/assets/cycle.js"></script>

<script type="text/javascript" src="<?=BASE_URL;?>/assets/flex.js"></script>

<script type="text/javascript" src="<?=BASE_URL;?>/theme/quadro/master.js"></script>

<script type="text/javascript" src="<?=BASE_URL;?>/assets/fancybox/jquery.fancybox.pack.js"></script>

<script type="text/javascript" src="<?=BASE_URL;?>/assets/fancybox/helpers/jquery.fancybox-media.js"></script>

  <script src="<?=BASE_URL;?>/assets/main.js" type="text/javascript"></script>
    
    <script type="text/javascript">var _sf_startpt=(new Date()).getTime()</script>
    
    <script src="<?=BASE_URL;?>/assets/simplejax.js" type="text/javascript"></script>
	<script src="<?=BASE_URL;?>/assets/tinysort.js" type="text/javascript"></script>
    <script src="<?=BASE_URL;?>/assets/proxy.js" type="text/javascript"></script>

<!-- Styles -->
	<link rel="stylesheet" href="<?=BASE_URL;?>/assets/shortcodes.css">
    <link rel="stylesheet" href="<?=BASE_URL;?>/assets/proxy.css">
	<link rel="stylesheet" href="<?=BASE_URL;?>/assets/turquoise.css">

<link rel="stylesheet" type="text/css" href="<?=BASE_URL;?>/assets/fancybox/jquery.fancybox.css" media="screen" />
</head>
<body>
<div id="check-proxy">    
        
  <form method="post" action="" id="checker-form">            
		<fieldset>          

			<textarea name="ipaddress" id="ipaddress" rows="3" style="background-color: #4F4646; color: #36B36A; padding: 10px; margin-bottom: 10px;" placeholder="12.34.56.78:8080" onKeyUp="limitTextarea(this,500,10000)"></textarea>        </fieldset>            
		<p id="checker-form-toolbar">           
          
			<select style="padding: 6px 6px 8px 6px; margin-right: 7px;">            
				<option value="all">All Types</option>            
				<option value="http">HTTP</option>            
				<option value="https">HTTPS</option>            
				<option value="socks5">Socks 5</option>            
				<option value="socks4">Socks 4</option>          
			</select>    
          
          <a class="btn colored postProxy" data-fancybox-type="ajax" href="processProxy.php" id="postProxy">Check Proxies</a>   
          
          
			<input type="button" value="Format" onClick="cleansock(); return false;" class="btn colored checkbtn" />         
          
            <span id="rcnt"></span>      </p>    
        
	</form>                
</div>
<div class="clearfix">&nbsp;</div>
<script type="text/javascript">
/* <![CDATA[ */
			
   var lines,nL,innerTable,splitIP,port,nS; 
   
   nS = 0; // No of Submitted IPs
   function doPost() //Handles POST of IPs recursively
   {

	   //console.log(lines[nS]);  // For debugging purposes
	   
	   //POST
	   $.post("i-processProxy.php", { ipaddress: lines[nS]})
.always(function(data) {
  		var ipdata = data.split('###');
		document.getElementById(ipdata[0]).innerHTML = ipdata[1];
		//$('#'+ipdata[0]).html(ipdata[1]);

});
nS++;
	   if(nS<nL)//While number of submitted IPs less than number of IPs in the list
	   {
		   doPost(); // Recursively calling same function to POST next IP
	   }
   }
$(document).ready(function () {
	
  //ajaxManager.run();
  
  $('.postProxy').on("click", function (e) {
    $(this).text("Checking Proxies...");
    e.preventDefault();
	
   lines = $.trim($('#ipaddress').val()).split('\n'); // Getting list of IP addresses, and removing trailing whitespaces/linebreaks
   nL = lines.length;//No of IP addresses (by number of lines)
   innerTable = ''; //Var to hold inner content of output display table
   splitIP = '';    //Var to hold array of IP & Port of Individual IPs
   port = ''; // var to hold port number
   for(i=0;i<nL;i++) //Iterating through IP addresses and build inner content for output display table
   {
      splitIP = lines[i].split(':');
      if(!(splitIP[1]))
        port = '';
      else
        port = splitIP[1];
      innerTable = innerTable + '<tr class="" id="'+lines[i]+'"><td><img src="http://api.find-ip.net/flags/us.png" alt="(US)" style="display:none;"></td><td style="text-align:center;">'+splitIP[0]+'</td><td style="text-align:center;">'+port+'</td><td style="text-align:center;" colspan="2"><img src="assets/images/ajax-loader.gif" alt="" /><span style="font-size:10px;">&nbsp;Processing...</span></td></tr>';
   }

   if((nL == 1) && (lines[0].length==0))    //Message for empty inputs
        innerTable = '<tr><td colspan="5" style="text-align:center;">Please enter at least one IP Address</td></tr>';

    var data = '<table id="results" cellpadding="0" cellspacing="1" style="margin-bottom: 6px;width:500px;font-size:12px;"><tbody><tr><th style="width:25px"></th><th style="width:175px;">Proxy IP</th><th style="width:50px;">Port</th><th style="width:100px;">Status</th><th style="width:150px;">Location</th></tr>'+innerTable+'</tbody></table>';
            $.fancybox(data, {
		  beforeClose:function(){ $('.postProxy').text("Checked Proxies"); },  afterShow:function(){nS=0;doPost();}
        });


			// fancybox
	//alert($("#checker-form").serializeArray());
    /*ajaxManager.addReq({
      type: "POST",
      cache: false,
      url: this.href,
      data: $("#checker-form").serializeArray(),
      success: function (data) {
        $.fancybox(data, {
          fitToView: false,
          width: 905,
          height: 505,
          autoSize: false,
		  beforeClose:function(){ $('.postProxy').text("Checked Proxies"); }
        }); // fancybox
		next();
      }, // success
	  failure: function(data){
      	next();
      }, // failure
      error: function(data){
      	next();
      } // error
    });  */  // ajax
  }); // on
}); // ready
/* ]]> */
</script>

<script type="text/javascript">

function cleansock(){
    var sockslist = window.document.frm.listsocks.value;
    var clean = sockslist.match(/d{1,3}([.])d{1,3}([.])d{1,3}([.])d{1,3}((:)|(s)+)d{1,8}/g );
    if(clean){
        var list="";
        for(var i=0;i<clean.length;i++){
            if(clean[i].match(/d{1,3}([.])d{1,3}([.])d{1,3}([.])d{1,3}(s)+d{1,8}/g )){
                clean[i]=clean[i].replace(/(s)+/,':');
            }
            list=list+clean[i]+"";
        }
        window.document.frm.listsocks.value=list;
    }
    else{
        window.document.frm.listsocks.value="Not found";
    }
}        

function limitTextarea(textarea, maxLines, maxChar) {
  		var lines = textarea.value.replace(/\r/g, '').split('\n'), lines_removed, char_removed, i;
			if (maxLines && lines.length > maxLines) {
				lines = lines.slice(0, maxLines);
				lines_removed = 1
			}
			if (maxChar) {
				i = lines.length;
				while (i-- > 0) if (lines[i].length > maxChar) {
					lines[i] = lines[i].slice(0, maxChar);
					char_removed = 1
				}
				if (char_removed || lines_removed) {
					textarea.value = lines.join('\n')
				}
			}
		}
    
</script>
</body>
</html>
