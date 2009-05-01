<h1>Edit Subscription</h1>

{if $todo eq "get_username"}

<form method="post" action="">
    <div>
        <b>User Name:</b>
        <input type="text" name="username" />
        <input type='submit' name='edit' value="Edit" />
    </div>
</form>

{elseif $todo eq "show_edit_form"}

<form method="post" action="">

	<div>
        <input type="hidden" name="uid" value="{$uid}" />
        <input type="hidden" name="username" value="{$username}" />
    </div>
    
    <div>
        <label for="package">Package:</label>
        <select name="package" id="package">
            {foreach from=$packages item=package_name}
                <option {if $pack_name eq $package_name}selected{/if}>{$package_name}</option>
            {/foreach}
		</select>
    </div>
    
    <div>
        <label>Expire Date:</label>
        <select name="expire_date">
            {foreach from=$expire_date item=expiry_date}
                <option {if $date eq $expiry_date} selected {/if}>{$expiry_date}</option>
            {/foreach}
        </select>

        <select name="expire_month">
            {foreach from=$expire_month item=expiry_month}
                <option {if $month eq $expiry_month} selected {/if}>{$expiry_month}</option>
            {/foreach}
        </select>

        <select name="expire_year">
            {foreach from=$expire_year item=expiry_year}
                <option {if $year eq $expiry_year} selected {/if}>{$expiry_year}</option>
            {/foreach}
		</select>
    </div>
    
    <div>
        <label for="used_space">Space Used (MB):</label>
        <input type="text" name="used_space" id="used_space" value="{$used_space}" /> 
    </div>
    
    <div>
        <label for="total_video">Total Videos:</label>
        <input type="text" name="total_video" id="total_video" value="{$total_video}" />
    </div>
    
	<div class="submit">
        <input type="submit" name="save_subscription" value="Save" />
	</div>

</form>

{elseif $todo eq "saved"}

<b><font color="#009900">Subscription saved for user: {$username}</font></b><br />
<p><b>
	<font color="#009900">
			Package: {$package}<br />
			Expire Date: {$new_expired_time|date_format:"%e %B %Y"}
	</font>
</b></p>

{/if}