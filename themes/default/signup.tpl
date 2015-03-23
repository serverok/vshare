{if $signup_verification_msg ne ""}
    <h3 class="text-success">{$signup_verification_msg}</h3>
{else}
<div class="col-md-8">
    <div class="page-header">
        <h1>
            New Member? Sign up
            <br>
            <small>Just fill out the account information below:</small>
        </h1>
    </div>

    <form  method="post" action="{$base_url}/signup/" id="signup-form" class="form-horizontal" role="form">
        <div class="form-group">
            <label for="user_name" class="control-label col-md-3">User Name:</label>
            <div class="col-md-6">
                <input type="text" id="user_name" name="user_name" value="{$signup.user_name}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="control-label col-md-3">Email:</label>
            <div class="col-md-6">
                <input type="text" name="email" id="email" value="{$signup.email}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="control-label col-md-3">Password:</label>
            <div class="col-md-6">
                <input type="password" id="password" name="password" value="" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label for="password_confirm" class="control-label col-md-3">Confirm Password:</label>
            <div class="col-md-6">
                <input type="password" id="password_confirm" name="password_confirm"  value="" class="form-control">
            </div>
        </div>

        {if $signup_dob eq "1"}
            <div class="form-group">
                <label class="control-label col-md-3">Date of Birth:</label>
                <div class="col-md-2">
                    <select name="month" class="form-control">
                        <option>mm</option>
                        {foreach from=$months item=month}
                            <option {if $month eq $signup.month} selected {/if}>{$month}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="day" class="form-control">
                        <option>dd</option>
                        {foreach from=$days item=day}
                            <option {if $day eq $signup.day} selected {/if}>{$day}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="year" class="form-control">
                        <option>yyyy</option>
                        {foreach from=$years item=year}
                            <option {if $year eq $signup.year} selected {/if}>{$year}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
        {/if}

        {if $signup_captcha eq "1"}
            {if $captcha_type eq 'default'}
                <div class="form-group">
                    <label class="control-label col-md-3">Security Code:</label>
                    <div class="col-md-6">
                        <img src="{$base_url}/captcha.php" alt="captcha" class="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="security_code" class="control-label col-md-3">Enter Security Code:</label>
                    <div class="col-md-3">
                        <input type="text" name="security_code" id="security_code" class="form-control required">
                    </div>
                </div>
            {else}
                <div class="form-group">
                    <label class="control-label col-md-3">Security Code:</label>
                    <div class="col-md-6">
                    {$recaptcha_html}
                    </div>
                </div>
            {/if}
        {/if}

        {if $enable_package eq "yes"}
            <div class="form-group">
                <label class="control-label col-md-3">Available Packages:</label>
                <div class="col-md-6">
                    {section name=i loop=$package}
                        <div class="radio">
                            <label>
                                <input type="radio" name="pack_id" value="{$package[i].package_id}">
                                <b>{$package[i].package_name}</b>
                                <br>
                                <small>
                                {$package[i].package_description}<br />
                                - <font color="#0055CC">{insert name=format_size size=$package[i].package_space}</font> video upload space<br />
                                {if $package[i].package_videos gt "0"}
                                    - Maximum <font color="#0055CC">{$package[i].package_videos}</font> videos upload<br />
                                {/if}
                                {if $package[i].package_price gt "0"}
                                    - Registration cost only <font color="#0055CC">${$package[i].package_price}</font> per {$package[i].package_period|lower}
                                {elseif $package[i].package_trial eq "yes"}
                                    - Free for <font color="#0055CC">{$package[i].package_trial_period} days</font>
                                {/if}
                                </small>
                            </label>
                        </div>
                    {/section}
                </div>
            </div>
        {/if}

       <div class="form-group">
            <div class="col-md-offset-3 col-md-9">
                <ul>
                    <li>I certify I am over {$age_minimum} years old.</li>
                    <li>
                        I agree to the
                        <a href="{$base_url}/pages/terms.html" target="_blank">terms of use</a> and
                        <a href="{$base_url}/pages/privacy.html" target="_blank">privacy policy</a>.
                    </li>
                </ul>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-3 col-md-3">
                <button type="submit" class="btn btn-default btn-lg" name="submit">Signup</button>
            </div>
        </div>
    </form>
</div>

<div class="col-md-4">
    <div class="page-header">
        <h2>{$site_name} Log In</h2>
    </div>

    <form method="post" action="{$base_url}/login/" id="login-form" role="form">
        <div class="form-group">
            <label>User Name:</label>
            <input type="text" name="user_name" value="{$user_name}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" id="password" name="user_password" class="form-control" required>
        </div>
        <div class="checkbox">
            <label><input type="checkbox" name="autologin">Remember</label>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-default btn-lg" name="action_login">Log In</button>
        </div>
    </form>

    <br>

    <div class="forget-passsword">
        <a href="{$base_url}/recoverpass.php">Forgot your password?</a>
    </div>
</div>
{/if}