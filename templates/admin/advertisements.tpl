<h1>Advertisements</h1>

<table cellspacing="1" cellpadding="3" width="100%">
	<tr class="tabletitle">
	    <td width="60">
	    	<b>ID</b>
	        <a href="advertisements.php?sort=adv_id+asc">
	        	<img src="{$img_css_url}/images/up.gif" border="0" alt="" />
	        </a>
	        <a href="advertisements.php?sort=adv_id+desc">
	        	<img src="{$img_css_url}/images/down.gif" border="0" alt="" />
	        </a>
	    </td>
	    <td>
	        <b>Advertise Name</b>
	        <a href="advertisements.php?sort=adv_name+asc">
	        	<img src="{$img_css_url}/images/up.gif" border="0" alt="" />
	        </a>
	        <a href="advertisements.php?sort=adv_name+desc">
	        	<img src="{$img_css_url}/images/down.gif" border="0" alt="" />
	        </a>
	    </td>
	    <td>
	        <b>Status</b>
	    </td>
	    <td width="100" align="center">
	        <b>Action</b>
	    </td>
	</tr>

	{section name=aa loop=$adv}
	
	<tr class="{cycle values="tablerow1,tablerow2"}">
		<td>
			{$adv[aa].adv_id}
		</td>
		<td>
			{$adv[aa].adv_name}
		</td>
		<td>
			<a href="advertisement_status.php?adv_id={$adv[aa].adv_id}&page={$smarty.request.page}&sort={$smarty.request.sort}">{$adv[aa].adv_status}</a>
		</td>
		<td align="center">
			<a href="advertisement_edit.php?adv_id={$adv[aa].adv_id}&page={$smarty.request.page}&sort={$smarty.request.sort}">
                <img src="{$img_css_url}/images/edit.gif" title="Edit" alt="Edit" />
            </a>
		</td>
	</tr>

	{/section}

</table>

{if $links ne ""}
    <div style="margin-top:2em;">
        {$links}
    </div>
{/if}
