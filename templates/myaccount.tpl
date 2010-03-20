<div class="section">

	<div class="hd">
		<div class="hd-l">My Account</div>
	</div>
	
	<div>
		<table cellspacing="0" cellpadding="0" border="0" align="center">
			<tr>
				<td align="left" valign="top">
					<ul style="list-style: none;">
						<li>
							<h3>
								<a href="{$base_url}/{$smarty.session.USERNAME}" style="text-decoration: none;">
									<img src="{$img_css_url}/images/profile.png" border="0" /> My Profile
								</a>
							</h3>
						</li>
						<li>
							<h3>
								<a href="{$base_url}/{$smarty.session.USERNAME}/edit/" style="text-decoration: none;">
									<img src="{$img_css_url}/images/profile_edit.png" border="0" /> Edit Profile
								</a>
							</h3>
						</li>
						{if $enable_package eq "yes"}
							<li>
								<h3>
									<a href="{$base_url}/renew_account.php?uid={$smarty.session.UID}&action=upgrade" style="text-decoration: none;">
										<img src="{$img_css_url}/images/upgrade.png" border="0" /> Upgrade Package
									</a>
								</h3>
							</li>
						{/if}
						<li>
							<h3>
								<a href="{$base_url}/user_delete.php" style="text-decoration: none;">
									<img src="{$img_css_url}/images/delete_account.png" border="0" /> Delete Account
								</a>
							</h3>
						</li>
						<li>
							<h3>
								<a href="{$base_url}/subscriptions/all/1" style="text-decoration: none;">
									<img src="{$img_css_url}/images/subscribe.png" width="37" height="32"> Subscriptions
								</a>
							</h3>
						</li>
					</ul>
				</td>
				<td align="left" valign="top">
					<ul style="list-style: none;">
						<li>
							<h3>
								<a href="{$base_url}/user_privacy.php" style="text-decoration: none;">
									<img src="{$img_css_url}/images/privacy_settings.png" border="0" /> Privacy Settings
								</a>
							</h3>
						</li>
						<li>
							<h3>
								<a href="{$base_url}/{$smarty.session.USERNAME}/playlist/" style="text-decoration: none;">
									<img src="{$img_css_url}/images/playlist.png" border="0" /> My Playlists
								</a>
							</h3>
						</li>
						<li>
							<h3>
								<a href="{$base_url}/upload/" style="text-decoration: none;">
									<img src="{$img_css_url}/images/upload_video.png" border="0" /> Upload Video
								</a>
							</h3>
						</li>
						<li>
							<h3>
								<a href="{$base_url}/user_photo_upload.php" style="text-decoration: none;">
									<img src="{$img_css_url}/images/upload_profile_photo.png" border="0" /> Upload Profile Photo
								</a>
							</h3>
						</li>
					</ul>
				</td>
			</tr>
		</table>
	</div>
	
</div>
