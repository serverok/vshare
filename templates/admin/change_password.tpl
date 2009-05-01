<h1>Change Admin Password</h1>

{if $msg eq ""}

<form method="post" action="">

    <div>
        <label>Admin Name:</label>
        <input name="admin_name" value="{$admin_name}" size="25" />
    </div>

    <div>
        <label for="password">Current Password:</label>
        <input type="password" name="password" id="password" size="25" autocomplete="off" />
    </div>

    <div>
        <label for="password_new">New Password:</label>
        <input type="password" name="password_new" id="password_new" size="25" autocomplete="off" />
    </div>

    <div>
        <label for="password_confirm">Confirm Password:</label>
        <input type="password" name="password_confirm" id="password_confirm" size="25" autocomplete="off" />
    </div>

    <div class="submit">
        <input type="submit" value="Submit" name="submit" />
    </div>

</form>

{/if}