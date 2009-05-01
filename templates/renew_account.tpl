<form action="renew_account.php?uid={$smarty.get.uid}" method="post" name="renew_account" id="renew_account">

	{if $smarty.request.action eq "upgrade"}
		<h2>Upgrade Account</h2>
		<p>Choose one of the following packages to upgrade your account:</p>
	{else}
    	<h2>Your Account has Expired - Renew Now!</h2>
    	<p>Choose one of the following packages to renew your account:</p>
	{/if}

    <h3>Available Packages</h3>
    
    <div id="packages-all">
    
        {section name=i loop=$package}
        
    		<div class="box1">
    			<input type="radio" name="package_id" value="{$package[i].package_id}">
    		</div>
    		
			<div class="box2">
				<b>{$package[i].package_name}</b></input><br />
				{$package[i].package_description}<br />
				- <font color="#0055CC">{insert name=format_size size=$package[i].package_space}</font> video upload space<br />
				{if $package[i].package_videos gt "0"}
					- Maximum <font color="#0055CC">{$package[i].package_videos}</font> videos upload<br />
				{/if}
				{if $package[i].package_price gt "0"}
					- Registration cost only <font color="#0055CC">${$package[i].package_price}</font> per {$package[i].package_period|lower}
				{elseif $package[i].package_trial eq "yes"}
					- Register for <font color="#0055CC">{$package[i].package_trial_period} days</font> free upload
				{/if}
			</div>
			
		{/section}
		
	</div>
	
	<div class="submit">
		<input type=submit name="submit" value="Next >>" />
	</div>

</form>
