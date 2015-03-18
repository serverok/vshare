{if $profile_comments ne ''}
        
{section name = i loop=$profile_comments}
    
    <div id="cid-{$profile_comments[i].profile_comment_id}" class="profile-comment {cycle values="comment-bg1,comment-bg2"} clearfix">

        <div class="box1">
            {insert name=voter_name assign=name id=$profile_comments[i].profile_comment_posted_by}
            <a href="{$base_url}/{$name.name}">{$name.name}</a>
            <div class="margin-2em-auto">
                <a href="{$base_url}/{$name.name}">
                    {insert name=member_img UID=$profile_comments[i].profile_comment_posted_by type=1}
                </a>
            </div>
        </div>
            
        <div class="box2">
            <p class="date">{$profile_comments[i].profile_comment_date}</p>
            {$profile_comments[i].profile_comment_text}
            {if $smarty.session.UID eq $profile_comments[i].profile_comment_user_id}
                <a href="javascript:void(0)" onclick="delete_comment('{$profile_comments[i].profile_comment_id}')">
                    <img src="{$img_css_url}/images/del.gif" border="0" alt=""  class="delete-botton" />
                </a>
            {/if}
        </div>
        
    </div>
    
{/section}

{if $page_links ne ""}
    <div class="page_links">
        Pages: {$page_links}
    </div>
{/if}

{else}

<div id="no-user-comments">
    No Comments
</div>

{/if}