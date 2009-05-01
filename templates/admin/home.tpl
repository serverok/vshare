<h1>Site Statistics</h1>

<div class="menubar">Statistics</div>

<table cellspacing="2" cellpadding="3" width="90%">

<tr class="tablerow1">
	<td><b>Number of Videos:</b></td>
	<td><b>{$total_video}</b></td>
</tr>

<tr class="tablerow2">
	<td><b>Number of Public Videos:</b></td>
	<td><b>{$total_public_video}</b></td>
</tr>

<tr class="tablerow1">
	<td><b>Number of Private Videos:</b></td>
	<td><b>{$total_private_video}</b></td>
</tr>

<tr class="tablerow2">
	<td><b>Number of Users:</b></td>
	<td><b>{$total_users}</b></td>
</tr>

<tr class="tablerow1">
	<td><b>Number of Channels:</b></td>
	<td><b>{$total_channel}</b></td>
</tr>

<tr class="tablerow2">
	<td><b>Number of Groups:</b></td>
	<td><b>{$total_groups}</b></td>
</tr>

</table>

<br />

<h1>Version Information</h1>

<p>You are using vShare version: {$vshare_version} (DB Version: {$version})</p>

{if $vshare_status eq "old"}
<p><font size="2" color="#ff0000"><b>
You are using old version of vShare<br />
You must upgrade to vShare {$latest_version}<br />
More information on vShare {$latest_version} available at <a href="http://buyscripts.in/vshare-release.html" target="_blank">http://buyscripts.in/vshare-release.html</a>
</b></font></p>
{/if}