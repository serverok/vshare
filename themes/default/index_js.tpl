<script type="text/javascript" src="{$base_url}/js/poll.js"></script>
{if $home_page_slider ne '0'}
<script>
$.get(baseurl + "/recent_viewed_html.php", function(data){
    $("#flash_recent_videos").html(data);
});
</script>
{/if}
