{if $video_info|@count gt '0'}

<div class="quicklist_box_head">
    <div class="float-l">Quicklists({$video_info|@count})&nbsp;&nbsp;<a id="ql_remove_all" href="javascript:void(0);"><small>Remove all</small></a></div>
    <div class="float-r"><a id="ql_show_hide" href="javascript:void(0)">show / hide</a></div>
</div>
<div class="clear" id="quicklist_cont">
   {section name=i loop=$video_info}
       <div class="video-list clear" id="div_{$video_info[i].video_id}">
           <div class="float-l">
               <a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/" style="position: relative;">
                   <img src="{$video_info[i].video_thumb_url}/thumb/{$video_info[i].video_folder}/1_{$video_info[i].video_id}.jpg" width="55" height="35" />
                   <span class="video-time">{$video_info[i].video_length}</span>
               </a>
           </div>
           
           <div class="float-l">
               <div class="float-l">
                   <a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/">{$video_info[i].video_title|truncate:30}</a>
               </div>
               <div class="clear float-l" style="width: 170px;">
                   {insert name=id_to_name assign=uname un=$video_info[i].video_user_id}
                   {$video_info[i].video_view_number} views &nbsp;&nbsp; <a href="{$base_url}/{$uname}">{$uname}</a>
               </div>
               <div class="float-l">
                  <a rel="ql_remove" id="{$video_info[i].video_id}" href="javascript:void(0);"><img src="{$base_url}/templates/images/del.gif" width="10" height="10" border="0" /></a>
               </div>
           </div>
       </div>
   {/section}
</div>

{literal}
<script type="text/javascript">
var dis = '';var show = '';
$("div.quicklist_box a#ql_show_hide").click(function(){
    $("div#quicklist_cont").slideToggle('fast',function(){
         dis = $("div#quicklist_cont").css('display');

           if (dis == 'block')
           {
               show = 1;
           }
           
           $.COOKIE('show', show);
    });
});

$("div.quicklist_box a#ql_remove_all").click(function(){
   $.COOKIE('video_queue', '');
   video_queue_display();
});

$("div.quicklist_box a[rel=ql_remove]").each(function(){
   $(this).click(function(){
       var box = $(this).attr("id");
       $("div#div_" + box).remove();
       
       var sUrl = baseurl + "/ajax/video_queue_remove.php?id=" + box;
        $.ajax({
            type: "GET",
            url: sUrl,
            dataType: 'html',
            success: function(html){
               video_queue_display();
            }
        });
   });
});

</script>
{/literal}

{/if}
