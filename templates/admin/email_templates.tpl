<h1>Email Templates</h1>

<table cellspacing="1" cellpadding="3" width="100%" border="0">

    <tr class="tabletitle">
        <td width="60">
            <b>Email ID</b>
            <a href="?a={$smarty.request.a}&status={$smarty.request.status}&sort=email_id+asc&page={$page}">
                <img src="{$img_css_url}/images/up.gif" border="0" alt="" />
            </a>
            <a href="?a={$smarty.request.a}&status={$smarty.request.status}&sort=email_id+desc&page={$page}">
                <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
            </a>
        </td>
        <td>
            <b>Email Subject</b>
            <a href="?a={$smarty.request.a}&status={$smarty.request.status}&sort=email_subject+asc&page={$page}">
                <img src="{$img_css_url}/images/up.gif" border="0" alt="" />
            </a>
            <a href="?a={$smarty.request.a}&status={$smarty.request.status}&sort=email_subject+desc&page={$page}">
                <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
            </a>
        </td>
        <td>
            <b>Comments</b>
        </td>
        <td width="100" align="center">
            <b>Action</b>
        </td>
    </tr>

    {section name=aa loop=$emails}

        <tr class="{cycle values="tablerow1,tablerow2"}">
            <td>{$emails[aa].email_id}</td>
            <td>{$emails[aa].email_subject}</td>
            <td>{$emails[aa].comment}</td>
            <td align="center">
                <a href="email_edit.php?action=edit&email_id={$emails[aa].email_id}">
                    <img src="{$img_css_url}/images/edit.gif" title="Edit" alt="Edit" />
                </a>
            </td>
        </tr>

    {/section}

</table>

<div class="margin-tb-1em">
    {$links}
</div>