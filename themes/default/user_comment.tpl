{if $profile_comments ne ''}
    <div class="row">
        {section name = i loop=$profile_comments}
            {insert name=voter_name assign=name id=$profile_comments[i].profile_comment_posted_by}
            <div id="cid-{$profile_comments[i].profile_comment_id}" class="clearfix">
                <div class="col-md-4 col-sm-4">
                    <div class="thumbnail">
                        <a href="{$base_url}/{$name.name}">
                            {insert name=member_img UID=$profile_comments[i].profile_comment_posted_by}
                        </a>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8">
                    {if $smarty.session.UID eq $profile_comments[i].profile_comment_user_id}
                        <p>
                            <a class="btn btn-danger btn-xs pull-right" href="javascript:void(0)" onclick="delete_comment('{$profile_comments[i].profile_comment_id}')">
                                <span class="glyphicon glyphicon-remove"></span>
                            </a>
                        </p>
                    {/if}
                    <h5>
                        <a href="{$base_url}/{$name.name}">{$name.name}</a>
                        <small>on {$profile_comments[i].profile_comment_date|date_format}</small>
                    </h5>
                    <p>{$profile_comments[i].profile_comment_text}</p>
                </div>
            </div>
            <hr>
        {/section}
    </div>

{if $page_links ne ""}
    <div>{$page_links}</div>
{/if}

{else}

<div id="no-user-comments">
    No Comments
</div>

{/if}