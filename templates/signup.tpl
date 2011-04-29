<div id="signup-box">

    <div class="section bg2">
    
        <div class="hd">
            <div class="hd-l">New Member? Sign up</div>
        </div>
        
        <form  method="post" action="{$base_url}/signup/" id="signup-form">
        
            <p>Just fill out the account information below:</p>
            
            <div>
                <label for="user_name">User Name:</label>
                <input type="text" id="user_name" name="user_name" value="{$signup.user_name}" />
            </div>                
            
            <div>
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" value="{$signup.email}" />
            </div>
                            
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="" />
            </div>
            
            <div>
                <label for="password_confirm">Confirm Password:</label>
                <input type="password" id="password_confirm" name="password_confirm"  value="" />
            </div>
            
            {if $signup_dob eq "1"}
                            
                <div>
                    <label>Date of Birth:</label>
                    <select name="month"><option>mm</option>
                        {foreach from=$months item=month}
                            <option {if $month eq $signup.month} selected {/if}>{$month}</option>
                        {/foreach}
                    </select>
                    <select name="day">
                        <option>dd</option>
                        {foreach from=$days item=day}
                            <option {if $day eq $signup.day} selected {/if}>{$day}</option>
                        {/foreach}
                    </select>
                    <select name="year">
                        <option>yyyy</option>
                        {foreach from=$years item=year}
                            <option {if $year eq $signup.year} selected {/if}>{$year}</option>
                        {/foreach}
                    </select>
                </div>
            
            {/if}
            
            {if $signup_captcha eq "1"}
                {if $captcha_type eq 'default'}
                    <div>
                        <label>Security Code:</label>
                        <img src="{$base_url}/captcha.php" alt="captcha" class="required" />
                    </div>
                    <div>
                        <label for="security_code">Enter Security Code:</label>
                        <input type="text" name="security_code" id="security_code" class="required" />
                    </div>
                {else}
                    <div>
                        <label>Security Code:</label>
                        <div class="indent">
                        {$recaptcha_html}
                        </div>
                    </div>
                {/if}
            {/if}
            
            {if $enable_package eq "yes"}
            
                <div class="package-container clearfix">
                
                    <label>Available Packages:</label>
                    <div id="packages">
                        {section name=i loop=$package}
    
                            <div class="package-box-1">
                                <input type="radio" name="pack_id" value="{$package[i].package_id}" />
                            </div>
                            
                            <div class="package-box-2">
                                <b>{$package[i].package_name}</b>
                                <br />
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
                            </div>
    
                        {/section}
                    </div>
                </div>

            {/if}

           <div class="indent">
                <ul>
                    <li>
                        I certify I am over {$age_minimum} years old.
                    </li>
                    <li>
                        I agree to the 
                        <a href="{$base_url}/pages/terms.html" target="_blank">terms of use</a> and 
                        <a href="{$base_url}/pages/privacy.html" target="_blank">privacy policy</a>.
                    </li>
                </ul>
            </div>
            
            <div class="submit">
                <input type="submit" value="Signup" name="submit" /> 
            </div>
            
        </form>
        
    </div>
    
</div> <!-- signup-box1 end -->

<div id="login_box2">

    <div class="section bg2">
    
        <div class="hd">        
            <div class="hd-l">{$site_name} Log In</div>
        </div>
    
        <form method="post" action="{$base_url}/login/" id="login-form">
        
            <div>
                <label for="user_name">User Name:</label>
                <input type="text" size="22" name="user_name" value="{$user_name}" />
            </div>
             
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" size="22" name="user_password" />
            </div>
         
            <div class="forget-passsword">
                <a href="{$base_url}/recoverpass.php">Forgot your password?</a>
            </div>
            
            <div class="submit">
                <input type="submit" value="Log In" name="action_login" />
                <input type="checkbox" name="autologin" />Remember
            </div>
             
        </form>
    </div>

</div> <!-- login_box2 -->