{if $signup_verification_msg ne ""}
<div class="col-md-12">
    <div class="page-header">
        <h2>Information</h2>
    </div>
    <p class="lead">{$signup_verification_msg}</p>
    <p><a href="{$base_url}/">Return to the home page</a></p>
</div>
{else}
<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default">
        <div class="panel-body">
            <h2>New Member? Sign up</h2>
            <p class="text-muted">Just fill out the account information below:</p>
            <hr>

            <form  method="post" action="{$base_url}/signup/" id="signup-form" class="" role="form">
                <div class="form-group">
                    <label for="user_name" class="control-label">User Name</label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                        <input type="text" id="user_name" name="user_name" value="{$signup.user_name}" class="form-control input-lg" required autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="control-label">E-Mail Address</label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
                        <input type="email" name="email" id="email" value="{$signup.email}" class="form-control input-lg" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="password" class="control-label">Your Password</label>
                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                                <input type="password" id="password" name="password" value="" class="form-control input-lg" required>
                            </div>
                        </div>
                        <p class="visible-xs visible-sm"></p>
                        <div class="col-md-6">
                            <label for="password_confirm" class="control-label">Confirm Your Password</label>
                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                                <input type="password" id="password_confirm" name="password_confirm" class="form-control input-lg" required>
                            </div>
                        </div>
                    </div>
                </div>

                {if $signup_dob eq "1"}
                    <div class="form-group">
                        <label class="control-label">Date of Birth:</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </div>
                                    <select name="month" class="form-control input-lg" required>
                                        <option value="">Month</option>
                                        {foreach from=$months item=month}
                                            <option {if $month eq $signup.month} selected {/if}>{$month}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </div>
                                    <select name="day" class="form-control input-lg" required>
                                        <option value="">Day</option>
                                        {foreach from=$days item=day}
                                            <option {if $day eq $signup.day} selected {/if}>{$day}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </div>
                                    <select name="year" class="form-control input-lg" required>
                                        <option value="">Year</option>
                                        {foreach from=$years item=year}
                                            <option {if $year eq $signup.year} selected {/if}>{$year}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                {/if}

                {if $captcha_enabled eq "1"}
                    <div class="form-group">
                        <label class="control-label">Verify you are human:</label>
                        <div class="col-md-offset-1">
                            {$captcha_html}
                        </div>
                    </div>
                {/if}

                {if $enable_package eq "yes"}
                    <div class="form-group">
                        <label class="control-label">Available Packages:</label>
                        <div class="col-md-offset-1">
                            {section name=i loop=$package}
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="pack_id" value="{$package[i].package_id}" required>
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
                    <div class="col-md-8 col-sm-8">
                        <small>By signing up you agree to the <a href="{$base_url}/pages/terms.html" target="_blank" class="text-nowrap">Terms of Service</a> and the <a href="{$base_url}/pages/privacy.html" target="_blank" class="text-nowrap">Privacy Policy</a>.</small>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <p class="visible-xs">&nbsp;</p>
                        <button type="submit" class="btn btn-success btn-lg btn-block" name="submit">Sign Up</button>
                    </div>
                </div>
            </form>
            <p></p>
            <p class="hidden-xs">&nbsp;</p>
        </div>
    </div>
</div>
{/if}