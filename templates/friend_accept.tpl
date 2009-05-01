{if $AID ne ""}
	<div id="friend-accept">
        <h2>Friend Invitation from {$user_name}</h2>
        <p>Accept this invitation if you know this user and wish to share videos with each other.</p>
		<b>User:</b> <a href="{$base_url}/{$user_name}">{$user_name}</a>
		<p><b>Accept?</b></p>
		
		<form action="{$base_url}/friend_accept.php" method="post">
			<input type="hidden" value="{$id}" name="id" />
			<input type="hidden" value="{$AID}" name="AID" />
			<input type="submit" value="Accept Invitation" name="friend_accept" />
		</form>
		<form onsubmit="return confirm('Are you sure you want to deny this friend request?');" action="{$base_url}/friend_accept.php" method="post">
			<input type="hidden" value="{$id}" name="id" />
			<input type="hidden" value="{$AID}" name="AID" />
			<input type=submit value="No thanks" name="friend_deny" />
		</form>
	</div>
{/if}