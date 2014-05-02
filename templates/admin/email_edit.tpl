<h1>Edit Email: {$email.email_id}</h1>

<form action="?email_id={$smarty.request.email_id}" method="post">

    <div>
        <label for="email_subject">Subject: </label>
        <input name="email_subject" id="email_subject" value="{$email.email_subject}" size="80" />
    </div>

    <div>
        <textarea name="email_body" id="email_body" rows="20" cols="100">{$email.email_body}</textarea>
    </div>

    <div>
        <label for="comment">Comments: <br /><i>(for admin)</i></label>
        <input name="comment" id="comment" value="{$email.comment}" size="80" />
    </div>

    <div class="submit">
        <input type="submit" name="submit" value="Update" class="btn btn-primary" />
    </div>

</form>

{if $editor_wysiwyg_email eq 1}
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
        theme_advanced_resizing : true,
        paste_auto_cleanup_on_paste : true,
        paste_convert_headers_to_strong : false,
        paste_strip_class_attributes : "all",
        paste_remove_spans : false,
        paste_remove_styles : false
    });

</script>
{/literal}
{/if}