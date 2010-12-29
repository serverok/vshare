{include file="admin/settings_menu.tpl"}

<h1>Signup Settings</h1>

<form method="post" action="">

    <div>
        <label for="signup">Allow User Signup:</label>
        <select name="signup" id="signup">
            <option value="1" {if $signup_enable =='1'}selected="selected"{/if}>Yes</option>
            <option value="0" {if $signup_enable =='0'}selected="selected"{/if}>No</option>
        </select>
    </div>
    
    <div>
        <label for="signup_verify">Signup Verification:</label>
        <select name="signup_verify" id="signup_verify">
            <option value="1" {if $signup_verify eq "1"}selected="selected"{/if}>Enable</option>
            <option value="0" {if $signup_verify eq "0"}selected="selected"{/if}>Disable</option>
        </select>
    </div>

    <div>
        <label for="notify_signup">Notify Signup:</label>
        <select name="notify_signup" id="notify_signup">
            <option value="1" {if $notify_signup eq "1"}selected="selected"{/if}>Enable</option>
            <option value="0" {if $notify_signup eq "0"}selected="selected"{/if}>Disable</option>
        </select>
    </div>
    
    <div>
        <label for="signup_captcha">Signup Captcha:</label>
        <select name="signup_captcha" id="signup_captcha">
            <option value="1" {if $signup_captcha eq "1"}selected="selected"{/if}>Enable</option>
            <option value="0" {if $signup_captcha eq "0"}selected="selected"{/if}>Disable</option>
        </select>
    </div>
    
    <div>
        <label for="captcha_type">Signup Captcha Type:</label>
        <select name="captcha_type" id="captcha_type">
            <option value="default" {if $captcha_type eq "default"}selected="selected"{/if}>Default</option>
            <option value="recaptcha" {if $captcha_type eq "recaptcha"}selected="selected"{/if}>Recaptcha</option>
        </select>
    </div>
    
    <div>
        <label for="signup_dob">Date of Birth on Signup:</label>
        <select name="signup_dob" id="signup_dob">
            <option value="0" {if $signup_dob =='0'}selected="selected"{/if}>No</option>
            <option value="1" {if $signup_dob =='1'}selected="selected"{/if}>Yes</option>
        </select>
    </div>
    
    <div>
        <label for="signup_age_min">Age Minimum:</label>
        <input type="text" name="signup_age_min" value="{$signup_age_min}" id="signup_age_min">
    </div>

     <div>
        <label for="signup_age_min_enforce">Age Minimum Enforce:</label>
        <select name="signup_age_min_enforce" id="signup_age_min_enforce">
            <option value="0" {if $signup_age_min_enforce =='0'}selected="selected"{/if}>No</option>
            <option value="1" {if $signup_age_min_enforce =='1'}selected="selected"{/if}>Yes</option>
        </select>
    </div>

    <div>
        <label for="signup_auto_friend">Default Friend:</label>
        <input type="text" name="signup_auto_friend" id="signup_auto_friend" value="{$signup_auto_friend}" />
    </div>
    
    <div class="submit">
        <input type="submit" name="submit" value="Update" />
    </div>

</form>