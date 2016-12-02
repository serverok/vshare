$(function() {
	$("#select_all").click(function() {
		var checked_status = this.checked;
		$("input[name='video_id[]']").prop("checked", checked_status);
	});
});

function validate_frm() {
    var videos_selected = $("input[name='video_id[]']:checked").length;

	if(videos_selected < 1) {
		alert('You need to select video before importing.');
		return false;
	}

    return true;
}
