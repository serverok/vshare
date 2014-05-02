<h1>Add New User</h1>

<form method="POST" action="">

    <div>
        <label for="user_name">Username:</label>
        <input type="text" name="user_name" id="user_name" value="{$smarty.post.user_name}" />
    </div>

    <div>
        <label for="user_email">Email:</label>
        <input type="text" name="user_email" id="user_email" value="{$smarty.post.user_email}" />
    </div>

    <div>
        <label for="user_password">Password:</label>
        <input type="text" name="user_password" id="user_password" />
    </div>

    {if $enable_package eq "yes"}
        <div>
            <label for="user_package_id">Package:</label>
            <select name="user_package_id" id="user_package_id">
            {section name=i loop=$package}
                <option value="{$package[i].package_id}">{$package[i].package_name}</option>
            {/section}
            </select>
        </div>
        <div>
            <label for="user_package_duration">Duration:</label>
            <input type="text" size="2" name="user_package_duration" id="user_package_duration" value="{$smarty.post.user_package_duration}" />
            <select name="user_package_duration_type" id="user_package_duration_type">
                <option value="days">Days</option>
                <option value="months">Months</option>
                <option value="years">Years</option>
            </select>
        </div>
    {/if}

    <div>
        <input type="submit" name="submit" value="Add User" class="btn btn-primary" />
    </div>

</form>