<div class="col-md-9 myaccount">

	<div class="page-header">
		<h1>My Account</h1>
	</div>

	<div class="col-md-4">

		<h4>
			<a href="{$base_url}/{$smarty.session.USERNAME}">
			<span class="glyphicon glyphicon-eye-open"></span> My Profile
			</a>
		</h4>

		<h4>
			<a href="{$base_url}/{$smarty.session.USERNAME}/edit/">
			<span class="glyphicon glyphicon-edit"></span> Edit Profile
			</a>
		</h4>

		{if $enable_package eq "yes"}

		<h4>
			<a href="{$base_url}/renew_account.php?uid={$smarty.session.UID}&action=upgrade" style="text-decoration: none;">
			<span class="glyphicon glyphicon-upload"></span> Upgrade Package</a>
		</h4>

		{/if}

		<h4>
			<a href="{$base_url}/user_delete.php">
			<span class="glyphicon glyphicon-remove delete"></span> Delete Account</a>
		</h4>

	</div>



	<div class="col-md-4">

		<h4>
			<a href="{$base_url}/upload/">
			<span class="glyphicon glyphicon-film"></span> Upload Video</a>
		</h4>

		<h4>
			<a href="{$base_url}/user_photo_upload.php">
			<span class="glyphicon glyphicon-picture"></span> Upload Profile Photo</a>
		</h4>

		<h4>
			<a href="{$base_url}/privacy/">
			<span class="glyphicon glyphicon-lock"></span> Privacy Settings</a>
		</h4>

	</div>


	<div class="col-md-4">

		<h4>
			<a href="{$base_url}/{$smarty.session.USERNAME}/playlist/">
			<span class="glyphicon glyphicon-list"></span> My Playlists</a>
		</h4>

		<h4>
			<a href="{$base_url}/{$smarty.session.USERNAME}/favorites/">
			<span class="glyphicon glyphicon-heart"></span> My Favorites</a>
		</h4>

		<h4>
			<a href="{$base_url}/{$smarty.session.USERNAME}/groups/">
			<span class="glyphicon glyphicon-user"></span> My Groups</a>
		</h4>

	</div>

</div>