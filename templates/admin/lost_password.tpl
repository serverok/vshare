<h1>Admin Password Reset</h1>


{if $smarty.request.submit eq ""}

<P>Click the button below to reset admin password.</p>

<form method="post" action="{$base_url}/admin/lost_password.php">
	<input type="submit" name="submit" value="Reset Admin Password" class="bttn" />
</form>

{else}
	<b>Email sent to your admin email address with password reset information.</b>
{/if}
