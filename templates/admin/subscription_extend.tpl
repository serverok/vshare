<h1>Extend Subscription</h1>

<form method="post" action="">

    <div>
		<label for="extend_for">Extend:</label>
		<select name="extend_for" id="extend_for">
			<option value="specific_user" {if $smarty.request.extend_for eq "specif_user"}selected="selected"{/if}>Specific User</option>
			<option value="all_users" {if $smarty.request.extend_for eq "all_users"}selected="selected"{/if}>All Users</option>
			<option value="expired_users" {if $smarty.request.extend_for eq "expired_users"}selected="selected"{/if}>Expired Users</option>
		</select>
    </div>

    <div>
        <label for="username">User Name:</label>
        <input type="text" name="username" id="username" value="{$smarty.request.username}" size="23" />
    </div>
    
    <div>
		<label for="duration">Duration:</label>
		<input type="text" name="duration" id="duration" size="4" value="{$smarty.request.duration}" />
		<select name="duration_type">
			<option value=""> -- SELECT -- </option>
			<option value="days" {if $smarty.request.duration_type eq "days"}selected="selected"{/if}>Days</option>
			<option value="months" {if $smarty.request.duration_type eq "months"}selected="selected"{/if}>Months</option>
			<option value="years" {if $smarty.request.duration_type eq "years"}selected="selected"{/if}>Years</option>
		</select>
    </div>
    
    <div class="submit">
        <input type="submit" name="submit" value="Submit" />
    </div>
    
</form>