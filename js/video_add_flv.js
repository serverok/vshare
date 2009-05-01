$(function(){
    $('#video_add_flv').validate(
    {
        rules: 
        {
            video_url:"required",
            video_user: "required",
            video_title: "required",
            video_description: "required",
            video_keywords: "required",
            chlist: "required"
        },
        messages: 
        {
            video_url: "Please enter video url",
            video_user: "Please enter a username",
            video_title: "Please enter video title",
            video_description: "Please enter description",
            video_keywords: "Please enter keywords",
            chlist: "Please select a channel"
        }
    });
});