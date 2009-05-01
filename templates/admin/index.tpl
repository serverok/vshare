<div id="login-box">

    <form method="post" action="{$base_url}/admin/index.php">

        <h1>Login</h1>

        {if $login_error ne ''}
            <div class="login-error">{$login_error}</div>
        {/if}
        
        <p>Enter your username and password to login</p>
        
        <div>
			<label for="user_name">Username:</label>
			<input id="user_name" name="user_name" type="text" size="25" />
        </div>

        <div>
			<label for="password">Password:</label>
			<input id="password" name="password" type="password" size="25" />
        </div>

        <div class="login">
			<input class="bttn" type="submit" name="submit" value="Login" /> &nbsp;
			<a href="./lost_password.php">Lost Password</a>
        </div>

    </form>

</div>

<p class="login-powered-by">
    Powered by: <a href="http://buyscripts.in" target="_blank">vShare</a>
</p>