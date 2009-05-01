function feature() {
	
	var sUrl = baseurl + "/ajax/video_feature_request.php";
	var postData = 'vid=' + vid;
	
	$.ajax({
        type: "POST",
        url: sUrl,
        data: postData,
        dataType: 'json',
        success: feature_success,
        error:feature_failure
    });
			
}

function feature_success(json) {
	
	if (json.messageType == 'success')
	{
		$('#video-tools-result').css('display','block').html(json.message);
		$('#video-tools-result').fadeIn("slow");
	} 
	else if(json.messageType == 'error')
	{
		$('#video-tools-result').css('color','red');
		$('#video-tools-result').css('display','block').html(json.message);
	}
	
}

function feature_failure() {
	$('#video-tools-result').css('color','red');
	$('#video-tools-result').css('display','block').html('connection failed');
}