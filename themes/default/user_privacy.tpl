<form method="POST" action="">
	<div class="section">
		<div class="hd">
			<div class="hd-l">Privacy Settings-&nbsp;{$smarty.session.USERNAME}</div>
		</div>
		<table border="0" align="center" width="25%">

			<tr>
				<td>Allow friend Invitations</td>
				<td>
					<select name="user_friend_invition">
						<option {if $user_info.user_friend_invition eq '1'}selected{/if} value="1">Yes</option>
						<option {if $user_info.user_friend_invition eq '0'}selected{/if} value="0">No</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Enable private message</td>
				<td>
					<select name="user_private_message">
						<option {if $user_info.user_private_message eq '1'}selected{/if} value="1">Yes</option>
						<option {if $user_info.user_private_message eq '0'}selected{/if} value="0">No</option>
					</select>
				</td>
			</tr>

			<tr>
				<td>Public favourites</td>
				<td>
					<select name="user_favourite_public">
						<option {if $user_info.user_favourite_public eq '1'}selected{/if} value="1">Yes</option>
						<option {if $user_info.user_favourite_public eq '0'}selected{/if} value="0">No</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Public playlists</td>
				<td>
					<select name="user_playlist_public">
						<option {if $user_info.user_playlist_public eq '1'}selected{/if} value="1">Yes</option>
						<option {if $user_info.user_playlist_public eq '0'}selected{/if} value="0">No</option>
					</select>
				</td>
			</tr>

			<tr>
				<td>Allow Profile comments</td>
				<td>
					<select name="user_profile_comment">
						<option {if $user_info.user_profile_comment eq '1'}selected{/if} value="1">Yes</option>
						<option {if $user_info.user_profile_comment eq '0'}selected{/if} value="0">No</option>
					</select>
				</td>
			</tr>
			
			<tr>
			    <td>Receive Email from Admin</td>
			    <td>
			        <select name="user_subscribe_admin_mail">
			            <option {if $user_info.user_subscribe_admin_mail eq '1'}selected{/if} value="1">Yes</option>
			            <option {if $user_info.user_subscribe_admin_mail eq '0'}selected{/if} value="0">No</option>
			        </select>
			    </td>
			</tr>

			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td align="center"><input type="submit" name="submit" value="Save"></td>
			</tr>
		</table>
	</div>
</form>