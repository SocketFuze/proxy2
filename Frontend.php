<div id="check-proxy">    
        
  <form method="post" action="" id="checker-form">            
		<fieldset>          
	          
			<textarea name="ipaddress" id="ipaddress" rows="3" style="background-color: #4F4646; color: #36B36A; padding: 10px; margin-bottom: 10px;" placeholder="12.34.56.78:8080" onkeyup="limitTextarea(this,500,10000)"></textarea>        </fieldset>            
		<p id="checker-form-toolbar">           
          
			<select style="padding: 6px 6px 8px 6px; margin-right: 7px;">            
				<option value="all">All Types</option>            
				<option value="http">HTTP</option>            
				<option value="https">HTTPS</option>            
				<option value="socks5">Socks 5</option>            
				<option value="socks4">Socks 4</option>          
			</select>    
          
          <a class="btn colored postProxy" data-fancybox-type="ajax" href="processProxy.php" id="postProxy">Check Proxies</a>   
          
          
			<input type="button" value="Format" onclick="cleansock(); return false;" class="btn colored checkbtn" />         
          
            <span id="rcnt"></span>      </p>    
        
	</form>                
</div>
<div class="clearfix">&nbsp;</div>

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

