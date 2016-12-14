<script>
$("#signup-form #user_name").on("blur", function(){
    $("label[for=user_name]").parent().children("span.text-danger").remove();
    var username = $(this).val();
    if (username.length > 0) {
        $.get(baseurl + "/ajax/username_check.php?user_name=" + username).done(function(data){
            if (data != "true") {
                $("label[for=user_name]").parent().append('<span class="text-danger">Username not available. Please choose another one.</span>');
            }
        });
    }
});
</script>
