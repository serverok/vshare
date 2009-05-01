<h1>Edit Page: {$page_edit.page_name}.html</h1>

<form method="post" action="">

    <input type="hidden" name="page_id" value="{$page_edit.page_id}" />
    <input type="hidden" name="page_name" value="{$page_edit.page_name}" />
    
	<div>
        <textarea name="content" rows="15" cols="100">{$page_edit.page_content}</textarea>
	</div>
	
    <div>
        <label>Title:</label>
		<input type="text" name="title" value='{$page_edit.page_title}' size="90" maxlength="200" />
	</div>
	
    <div>
        <label>Description:</label>
        <input type="text" name="description" value='{$page_edit.page_description}' size="90" maxlength="200" />
	</div>
	
    <div>
        <label>Keywords:</label>
        <input type="text" name="keywords" value='{$page_edit.page_keywords}' size="90" maxlength="200" />
    </div>
    
    <div>
        <label>Members Only:</label>
        <select name="members_only">
            <option value="0" {if $page_edit.page_members_only eq "0"}selected="selected"{/if}>No</option>
            <option value="1" {if $page_edit.page_members_only eq "1"}selected="selected"{/if}>Yes</option>
        </select>
	</div>
	
    <div class="submit">
        <input type="submit" name="submit" value="Save Page" />
    </div>
    
</form>

{if $editor_wysiwyg_admin eq 1}
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
        paste_remove_styles : false
    });
</script>
{/literal}
{/if}