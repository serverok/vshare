function video_add_favorite(video_id) 
{
	var sUrl = baseurl + '/ajax/video_add_favorite.php';
	var postData = "video_id=" + video_id;

    $.ajax({
        type: "POST",
        url: sUrl,
        data: postData,
        dataType: 'html',
        success: video_add_favorite_success,
        error: video_add_favorite_error
    });
}

function video_add_favorite_success(msg) 
{
	$('#video-tools-result').fadeIn("slow");
	$('#video-tools-result').html(msg);
}

function video_add_favorite_error() 
{
	alert('Ajax Error');
}