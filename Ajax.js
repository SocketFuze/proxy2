var ajaxManager = (function() {
     var requests = [];

     return {
        addReq:  function(opt) {
            requests.push(opt);
        },
        removeReq:  function(opt) {
            if( $.inArray(opt, requests) > -1 )
                requests.splice($.inArray(opt, requests), 1);
        },
        run: function() {
            var self = this,
                orgSuc;

            if( requests.length ) {
                oriSuc = requests[0].complete;

                requests[0].complete = function() {
                     if( typeof oriSuc === 'function' ) oriSuc();
                     requests.shift();
                     self.run.apply(self, []);
                };   

                $.ajax(requests[0]);
            } else {
              self.tid = setTimeout(function() {
                 self.run.apply(self, []);
              }, 1000);
            }
        },
        stop:  function() {
            requests = [];
            clearTimeout(this.tid);
        }
     };
}());

/* <![CDATA[ */
$(document).ready(function () {
  
  ajaxManager.run();
  
  $('.postProxy').on("click", function (e) {
    $(this).text("Checking Proxies...");
    e.preventDefault();
    ajaxManager.addReq({
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
    }); // ajax
  }); // on
}); // ready
/* ]]> */
