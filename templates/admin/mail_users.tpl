<h1>Send Email to {if $smarty.request.a eq "user"}User{elseif $smarty.request.a eq "group"}Group{else}{$smarty.request.uname}{/if}</h1>

{if $smarty.request.a eq "user"}
<form method="post" action="mail_users.php?a=user">
{elseif $smarty.request.a eq "group"}
<form method="post" action="mail_users.php?a=group">
{else}
<form method="post" action="mail_users.php?email={$smarty.request.email}&uname={$smarty.request.uname}">
{/if}

    {if $smarty.request.a eq "user"}
    
    <div>
        <label>Email To:</label>
        <select name="UID">
            {$user_ops}
        </select>
    </div>
    
    {elseif $smarty.request.a eq "group"}
    
    <div>
        <label>Email To:</label>
        <select name="GID">
            {$group_ops}
        </select>
    </div>
    
    {else}
    
    <div>
        <label>To:</label>
        <input type="text" name="email" size="30" value="{$smarty.request.email}" />
    </div>
    
    {/if}

    <div>
        <label for="subj">Subject:</label>
        <input type="text" name="subj" id="subj" size="60" value="{$smarty.request.subj}" /><br />
    </div>
    
    <div>
        <textarea name="htmlCode" cols="90" rows="18">{$smarty.request.htmlCode}</textarea>
    </div>
    
    <div>
        <input type="submit" name="submit" value="Send Email" />
    </div>

</form>

{if $editor_wysiwyg_email eq "1"}
<script language="javascript" type="text/javascript" src="{$base_url}/js/tiny_mce/tiny_mce.js"></script>

{literal}
<script language="javascript" type="text/javascript">
    tinyMCE.init({
        mode : "textareas",
        theme : "advanced",
        plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,media,searchreplace,print,contextmenu,paste,directionality,fullscreen",
        theme_advanced_buttons1_add : "fontselect,fontsizeselect",
        theme_advanced_buttons2_add : "separator,preview,forecolor,backcolor,hr",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_align : "left",
        theme_advanced_toolbar_location : "top",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_buttons_location: "top",
        theme_advanced_resizing : true,
        paste_auto_cleanup_on_paste : true,
        paste_convert_headers_to_strong : false,
        paste_strip_class_attributes : "all",
        paste_remove_spans : false,
        paste_remove_styles : false,
        convert_urls: true,
        relative_urls: false,
        remove_script_host: false
    });
</script>
{/literal}
{/if}