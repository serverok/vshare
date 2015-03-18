{section name=i loop=$comments}

    <div class="comment" id="{$comments[i].comment_id}">
        
        <div class="comment_head">
        
            <div class="float_l">
                <a href="{$base_url}/{$comments[i].user_name}">{$comments[i].user_name}</a>
                {insert name=time_range assign=comment_time time=$comments[i].comment_add_time}
                <small>( {$comment_time} )</small>
            </div>
            <div class="float_r">
                {if $smarty.session.UID ne '' && $smarty.session.UID eq $comments[i].video_user_id}&nbsp;&nbsp;
                    <a href="javascript:void(0);" onclick="video_comment_delete('{$video_id}', '{$comments[i].comment_id}');">
                        <img src="{$img_css_url}/images/del.gif" alt="delete" />
                    </a>
                {/if}
            </div>
            
            <br />

            <div class="float_l">
               <a href="{$base_url}/{$comments[i].user_name}">
                    {insert name=member_img UID=$comments[i].comment_user_id type=1}
               </a>
            </div>

            <div class="comment_body">
                {$comments[i].comment_text}
            </div>
            
            <div class="clear"></div>

        </div>
           
    </div>

{/section}

{if $links ne ''}
    <div class="comment_pagination_block" align="right">
        {$links}
    </div>
{else}
    <br />
{/if}