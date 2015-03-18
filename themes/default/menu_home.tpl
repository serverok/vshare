{if $smarty.session.USERNAME ne ""}
	<ul>
		<li><a href="{$base_url}/{$smarty.session.USERNAME}/public/">My Videos</a></li>
		<li><a href="{$base_url}/{$smarty.session.USERNAME}/favorites/">My Favorites</a></li>
		<li><a href="{$base_url}/{$smarty.session.USERNAME}/playlist/">My Playlist</a></li>
		<li><a href="{$base_url}/{$smarty.session.USERNAME}/groups/">My Groups</a></li>
		<li><a href="{$base_url}/{$smarty.session.USERNAME}/">My Profile</a></li>
	</ul>
{/if}