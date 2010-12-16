<div style="margin:4em">
	{if $unsubscribed_success eq '0'}
		<h2>CONFIRM UNSUBSCRIPTION</h2>
		<p>Are you sure you want to remove from the Mailing list ?</p>
		
		<form method="POST" action="">
			<input type="submit" name="submit" value="Unsubscribe" />
			<input type="submit" name="submit" value="Cancel" />
		</form>
	{else}
		{$unsubscribe_txt}	
	{/if}
</div>
