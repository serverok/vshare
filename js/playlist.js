$("#playlist-form-btn").click(function(){
	if ($("#show_playlists").is(':hidden')) {
		$("#show_playlists").show();
		show_playlists();
		return false;
	} else {
		$("#video_playlist_form").slideUp('fast');
		$("#show_playlists").hide();
	}
});

$(document).click(function(){
	$("#show_playlists").hide();
});

function create_playlist() {
	var playlist_name = $("form#pl-frm input#playlist_name").val();

	if (playlist_name == '') {
		return false;
	}

	$("#show_playlists").hide();

	var sUrl = baseurl + "/ajax/playlist.php";
	var postData = "action=create_playlist&playlist_name=" + playlist_name;

	$.ajax({
	    type: "GET",
	    url: sUrl,
	    data: postData,
	    dataType: 'json',
	    success: function(msg) {
            if (msg.messageType == "error") {
                $("#video-tools-result")
                    .removeClass("alert-success")
                    .addClass("alert-danger")
                    .text(msg.message)
                    .fadeIn("slow");
            } else {
                $("form#pl-frm input#playlist_name").val('');
                if (isNaN(parseInt(msg.message))) {
                    $("#video-tools-result")
                        .removeClass("alert-danger")
                        .addClass("alert-success")
                        .text(msg.message)
                        .fadeIn("slow");
                } else {
                    add_video_playlist(msg.message);
                }
            }
		},
	    error: function() {
			//$("#video-tools-result").html('connection failed').show();
		}
	});
}

function show_playlists() {
	$("#show_playlists").html('<img src="' + baseurl + '/templates/images/loading.gif" />');

	var sUrl = baseurl + "/ajax/playlist.php";
	var postData = "action=show_playlist&user_id=" + user_id;

	$.ajax({
	    type: "GET",
	    url: sUrl,
	    data: postData,
	    dataType: 'json',
	    success: function(msg) {
            if (msg.messageType == "error") {
                $("#video-tools-result")
                    .removeClass("alert-success")
                    .addClass("alert-danger")
                    .text(msg.message)
                    .fadeIn("slow");
                $("#show_playlists").hide();
            } else {
                $("#show_playlists").html(msg.message).show();
            }
		},
	    error: function() {
			//$("#video-tools-result").html('connection failed').show();
		}
	});
}

function add_video_playlist(pl_id) {
	var playlist_id = pl_id;

	if (playlist_id == 0) {
		playlist_id = $("form#show-pl-frm select#playlist_id").val();
	}

	var sUrl = baseurl + "/ajax/playlist.php";
	var postData = "action=add_playlist_video&video_id=" + vid + "&playlist_id=" + playlist_id;

	if (playlist_id == '') {
		return false;
	}

	$.ajax({
		type: "GET",
		url: sUrl,
		data: postData,
		dataType: 'json',
		success: function(msg) {
            if (msg.messageType == "error") {
                $("#video-tools-result")
                    .removeClass("alert-success")
                    .addClass("alert-danger")
                    .text(msg.message)
                    .fadeIn("slow");
            } else {
                $("#video-tools-result")
                    .removeClass("alert-danger")
                    .addClass("alert-success")
                    .text(msg.message)
                    .fadeIn("slow");
            }
		},
		error: function() {
			//$("#video-tools-result").html('connection failed').show();
		}
	});
}