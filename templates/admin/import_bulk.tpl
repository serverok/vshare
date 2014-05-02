<script language="JavaScript" type="text/javascript" src="{$base_url}/js/admin_bulk_import.js"></script>
<script language="JavaScript" type="text/javascript" src="{$base_url}/js/jquery.validate.min.js"></script>
<link href="{$img_css_url}/css/admin_import_bulk.css" rel="stylesheet" type="text/css" />

<h1>Bulk Import</h1>

{if $videos eq ''}

<p>Import videos from Youtube based on keyword.</p>

<form action="" method="get" id="bulk-import-search" name="bulk-import-search">

    <div>
        <label for="keyword">Keyword:</label>
        <input name="keyword" id="keyword" value="{$smarty.get.keyword}" />
    </div>

    <div>
        <label for="user_name">Video added to:</label>
        <input name="user_name" id="user_name" value="{$smarty.get.user_name}" />
    </div>

    <div>
        <label for="channel" >Channel:</label>
        <select name="channel">
            <option value="">-----------SELECT-----------</option>
            {section name=i loop=$channels}
                <option value="{$channels[i].channel_id}"{if $channels[i].channel_id eq $smarty.get.channel}selected="selected"{/if}>{$channels[i].channel_name_html}</option>
            {/section}
        </select>
    </div>

    <div class="submit">
        <input type="submit" name="submit" value="Search" class="btn btn-primary" />
    </div>

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

        <div class="video-entry{if $videos[i].imported eq "1"} imported{/if}">

            <div class="check-box">
                {if $videos[i].imported eq "0"}
                <input type="checkbox" name="video_id[]" value="{$videos[i].video_id}" />
                {else}
                    <img src="{$base_url}/templates/images/tick.png" alt="imported" />
                {/if}
            </div>

            <div class="thumbnail">
                <img src="{$videos[i].thumb_url}" alt="{$videos[i].video_title}" />
                <img src="http://i.ytimg.com/vi/{$videos[i].video_id}/3.jpg" alt="{$videos[i].video_title}" />
        	</div>

            <div class="video-details">
            	<h2>{$videos[i].video_title}</h2>
            	<p>{$videos[i].video_description}</p>
            	<p>Duration: {$videos[i].video_duration}</p>
            	{if $videos[i].imported ne "0"}
            		<p class="imported">Already Imported.</p>
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

{if $links ne ''}
    {$links}
{/if}

{/if}