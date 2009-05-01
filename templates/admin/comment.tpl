<h1>View Comments</h1>

<p>Total: {$total}</p>

<table cellspacing="1" cellpadding="3" width="100%">

    <tr class="tabletitle">
        <td>
            <b>Video</b>
        </td>
        <td>
            <b>User Name</b>
        </td>
        <td>
            <b>Comments</b>
        </td>
        <td align="center">
            <b>Action</b>
        </td>
    </tr>

    {section name=i loop=$comments}
        <tr class="{cycle values='tablerow1,tablerow2'}">
            <td>
                <a href="video_details.php?id={$comments[i].comment_video_id}">
                    {$comments[i].comment_video_id}
                </a>
            </td>
            <td>
                <a href="user_view.php?user_id={$comments[i].comment_user_id}">
                    {$comments[i].user_name}
                </a>
            </td>
            <td>
                {$comments[i].comment_text}
            </td>
            <td align="center">
                <a href='comment_edit.php?action=edit&id={$comments[i].comment_id}&page={$page}'>
                    <img src="{$img_css_url}/images/edit.gif" title="Edit" alt="Edit" border="0" style="vertical-align: middle;" />
                </a>
                <a href='comment.php?action=del&id={$comments[i].comment_id}&page={$page}' onclick='Javascript:return confirm("Are you sure you want to delete?");'>
                    <img src="{$img_css_url}/images/del.gif" title="Delete" alt="Delete" border="0" style="vertical-align: middle;" />
                </a>
            </td>
        </tr>
    {/section}

</table>

{if $links ne ""}
    <div class="margin-top-1em">
        {$links}
    </div>
{/if}