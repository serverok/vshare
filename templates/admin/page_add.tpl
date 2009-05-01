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

<h1>Add New Page</h1>

<form method="post" action="">

	<div>
		<label>File Name:</label>
		<input type="text" name="page_name" size="25" maxlength="64" value="{$smarty.request.page_name}" />.html
	</div>
	
	<div>
		File Name should be in lowercase. No special characters are allowed other than hyphen (-).
	</div>

	<div>
		<textarea name="content" rows="15" cols="100">{$smarty.request.content}</textarea>
	</div>

	<div>
		<label for="title">Title:</label>
		<input type="text" name="title" id="title" size="90" maxlength="200" value="{$smarty.request.title}" />
	</div>

	<div>
		<label for="description">Description:</label>
		<input type="text" name="description" id="description" size="90" maxlength="200" value="{$smarty.request.description}" />
	</div>

	<div>
		<label for="keywords">Keywords:</label>
		<input type="text" name="keywords" id="keywords" size="90" maxlength="200" value="{$smarty.request.keywords}" />
	</div>

	<div>
		<label for="members_only">Members Only:</label>
		<select name="members_only" id="members_only">
			<option value="0">No</option>
			<option value="1">Yes</option>
		</select>
	</div>

	<div class="indent">
		<input type="submit" name="submit" value="Save Page" />
	</div>

</form>