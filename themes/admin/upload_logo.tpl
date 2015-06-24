<script language="JavaScript" type="text/javascript" src="{$base_url}/js/fileinput.min.js"></script>
<link href="{$base_url}/themes/default/css/fileinput.css" rel="stylesheet">

<div class="page-header">
    <h1>Upload Logo</h1>
</div>

<div class="row">
    <div class="col-sm-3">
        <div class="thumbnail well">
         <img src="{$img_css_url}/default/images/logo.jpg?{$vshare_rand}" alt="" />
        </div>
    </div>

    <div class="col-sm-5">
        <label class="control-label">Select file to upload:</label>
        <form action="upload_logo.php?a={$smarty.request.a}&action=edit" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <input id="input-21" type="file" class="file" name="logo"/>
        </form>
        <span class="help-block">Photo must be in JPG format</span>
        <p class="small alert alert-warning">To clear cache open the <a href="{$img_css_url}/default/images/logo.jpg" target="_blank">Logo image</a> on a new browser and refresh it (Press F5 on your keyboard), so you will be able to see the new image</p>
    </div>
</div>

{literal}
<script>
$("#input-21").fileinput({
previewFileType: "image",
browseClass: "btn btn-primary",
removeClass: "btn btn-danger",
removeLabel: "Delete",
removeIcon: '<i class="glyphicon glyphicon-trash"></i>',
uploadClass: "btn btn-info btn-upload",
uploadLabel: "Upload",
uploadIcon: '<i class="glyphicon glyphicon-upload"></i>',
});
$(".btn-upload").attr("name", "submit");
</script>
{/literal}