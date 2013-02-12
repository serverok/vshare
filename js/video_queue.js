
//$(document.ready(function(){
video_queue_display();
	$('div [rel=video_queue]').each(function(){
		   $(this).click(function(){
			     var myClass = new Array();
			     myClass['video-queue'] = 'video-queue-info';
			     myClass['video-queue-info'] = 'video-queue-info';
			     myClass['video-queue home-video-queue'] = 'video-queue-info home-video-queue'
			     var video_id = $(this).attr('id');
			     var cssClass = $(this).attr('class');
			     $("#"+video_id).removeClass(cssClass).addClass(myClass[cssClass]);
			     $("#"+video_id).html('Added to queue');

			     if (video_id.match('_'))
			     {
			    	 var tmp = video_id.split('_');
			    	 video_id = tmp[0];
			     }
			     
			     var sUrl = baseurl + "/ajax/video_queue.php";
			     sUrl = sUrl + "?video_id=" + video_id;
			     $.ajax({
			         type: "GET",
			         url: sUrl,
			         dataType: 'html',
			         success: function(html){
			    	    video_queue_display();
			    	 },
			         error: video_queue_error
			     });
			     function video_queue_error(){
			     }
				 
			   });
	});

	function video_queue_display(){
		var show = '';
        var sUrl = baseurl + "/ajax/video_queue_display.php";
        $.ajax({
            type: "GET",
            url: sUrl,
            dataType: 'html',
            success: function(html){
               $("#quicklist_box").html(html);
               show = $.COOKIE('show');

               if (show == '')
               {
            	   $("#quicklist_cont").hide();
               }
               
            },
            error: function(){
            }
        });
    }
	
	var cookieName = '';
	var cookieValue = '';
	
	jQuery.COOKIE = function(cookieName,cookieValue){
		var expiredays = 1;
		
		if (cookieValue != undefined)
		{
			var exdate=new Date();
			expiredays = exdate.setDate(exdate.getDate()+expiredays);
			document.cookie =''+ cookieName +'= ' + cookieValue + '; expires='+exdate.toUTCString()+'; path=/';
		}
		else
		{
			var cookieValue = '';
        	
	        if (document.cookie && document.cookie != '') {
	        	var cookies = document.cookie.split(';');
	        	
	        	for (var i = 0; i < cookies.length; i++) {
	                var cookie = jQuery.trim(cookies[i]);
	                
	                if (cookie.match(cookieName + '='))
	                {
	                	cookieValue = cookie.substring(cookieName.length + 1);
	                }
	            }
	        }
	        return cookieValue;
		}
	}
	
	
	
//});