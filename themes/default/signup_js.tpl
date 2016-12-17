<script>
$("#signup-form #user_name").on("blur", function(){
    var msg_container = $("#signup-form #user_name").parent().parent();
    msg_container.children("span.text-danger").remove();
    var username = $(this).val();
    if (username.length > 0) {
        $.get(baseurl + "/ajax/username_check.php?user_name=" + username).done(function(data){
            if (data != "true") {
                msg_container.append('<span class="text-danger">Username not available. Please choose another one.</span>');
            }
        });
    }
});
</script>
