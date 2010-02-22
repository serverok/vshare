
var load_content = 0;
var load_div = 0;

function show_user_videos(user_id)
{
	if ($("#show_user_videos").is(':hidden'))
	{
		$("#show_user_videos").show();
		load_div = 0;
	}
	else
	{
		$("#show_user_videos").hide();
		load_div = 0;
	}
	
	if (load_content == 0 && user_id != '')
	{
		$("#show_user_videos").html('<img src="' + baseurl + '/templates/images/loading.gif" align="center" />').show();
	
		var sUrl = baseurl + "/ajax/user_videos.php";
		var postData = "user_id=" + user_id + "&video_id=" + vid;
	
		$.ajax({
			type: "GET",
			url: sUrl,
			data: postData,
			dataType: 'html',
			success: function(msg)
			{
				$("#show_user_videos").html(msg).show();
				load_content = 1;
				load_div = 1;
			},
			error: function()
			{
				alert('Connection Failed.');
			}
		});
	}
	else if (load_div == 1)
	{
		$("#show_user_videos").show();
	}
}

