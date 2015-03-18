{if $smarty.session.UID ne ''}
<div class="section bg2">
	<div class="hd">
		<div class="hd-l">Family Filter is ON.</div>
	</div>
	
	<div class="margin-1em">
		<ul>
			<li><strong>{$site_name}</strong> understands that some content may not be appropriate for all users.</li>
			<li>We provide a Family Filter so that you can choose the content best suited to your personal interest.</li>
			<li>Turning OFF the Family Filter may display content that is only suitable for viewers over {$age_minimum} years of age.</li>
			<li>Click the button below if you are over {$age_minimum} and would like to turn OFF the Family Filter.</li>
			<li style="list-style:none;margin: 5px 0 5px 0;padding: 5px 0 5px 0;">
				<form method="POST" action="">
					<input type="submit" value="I am over {$age_minimum} - set Family Filter OFF" name="submit" />
				</form>
			</li>
		</ul>
	</div>
</div>
{else}
<div class="margin-1em">
    <p>Please verify you are {$age_minimum} or older by <a href="{$base_url}/login/">signing in</a> or <a href="{$base_url}/signup/">signing up</a>.</p>
    <p>If you would instead prefer to avoid potentially inappropriate content, consider activating {$site_name}'s Family Filter.</p>
</div>
{/if}