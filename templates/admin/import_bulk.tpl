<div class="page-header">
    <h1>Bulk Import</h1>
</div>

<script language="JavaScript" type="text/javascript" src="{$base_url}/js/admin_bulk_import.js"></script>
<script language="JavaScript" type="text/javascript" src="{$base_url}/js/jquery.validate.min.js"></script>
<link href="{$img_css_url}/css/admin_import_bulk.css" rel="stylesheet" type="text/css" />

{if $videos eq ''}

<p>Import videos from Youtube based on keyword.</p>

<form action="" method="get" class="form-horizontal" role="form">

    <fieldset>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="keyword">Keyword:</label>
        <div class="col-sm-5">
            <input class="form-control" name="keyword" id="keyword" value="{$smarty.get.keyword}" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="user_name">Video added to:</label>
        <div class="col-sm-5">
            <input class="form-control" name="user_name" id="user_name" value="{$smarty.get.user_name}" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="channel" >Channel:</label>
        <div class="col-sm-5">
            <select class="form-control" name="channel">
                <option value="">-----------SELECT-----------</option>
                {section name=i loop=$channels}
                    <option value="{$channels[i].channel_id}"{if $channels[i].channel_id eq $smarty.get.channel}selected="selected"{/if}>{$channels[i].channel_name_html}</option>
                {/section}
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Search</button>
        </div>
    </div>

    </fieldset>

</form>

{literal}
<script>
    $(function(){
        validate_bulk_import_search_form();
    });
</script>
{/literal}

{/if}

{if $smarty.get.keyword ne ''}

{if $videos ne ''}

<form action="import_bulk_process.php" method="post" name="bulk_import" onsubmit="return validate_frm();">

    {section name=i loop=$videos}

        <div class="media{if $videos[i].imported ne "0"} bg-success{/if}">
            <div class="pull-left">
                {if $videos[i].imported eq "0"}
                <input type="checkbox" name="video_id[]" value="{$videos[i].video_id}" />
                {else}
                    <img src="{$base_url}/templates/images/tick.png" alt="imported" />
                {/if}
            </div>

            <a class="pull-left" href="#">
                <img src="{$videos[i].thumb_url}" alt="{$videos[i].video_title}" />
                <img src="http://i.ytimg.com/vi/{$videos[i].video_id}/3.jpg" alt="{$videos[i].video_title}" />
            </a>

            <div class="media-body">
                <h4>{$videos[i].video_title}</h4>
                <p>{$videos[i].video_description}</p>
                <p>Duration: {$videos[i].video_duration}</p>
                {if $videos[i].imported ne "0"}
                    <h4><span class="label label-success">Already Imported.</span></h4>
                {/if}
            </div>
        </div>

    {/section}

    <input type="hidden" name="import_site" value="youtube" />
    <input type="hidden" name="page" value="{$smarty.get.page}" />
    <input type="hidden" name="keyword" value="{$smarty.get.keyword}" />
    <input type="hidden" name="user_name" value="{$user_name}" />
    <input type="hidden" name="channel_id" value="{$channel_id}" />

    <div style="float:left;clear:both;">
        <input type="checkbox" name="select_all" id="select_all" /> Select All
    </div>

    <div style="clear:both"></div>

    <div>
        <select name="import_method">
            <option value="embed">Embed (NO space, bandwidth needed)</option>
            <option value="download">Download (NEED space & bandwidth)</option>
        </select>
        <input type="submit" name="submit" value="Import Selected Videos" />
    </div>
</form>

{/if}


<div class="row">
    <div class="col-md-12">
        {$links}
    </div>
</div>

{/if}