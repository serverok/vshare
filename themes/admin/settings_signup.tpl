<div class="page-header">
    <h1>Signup Settings</h1>
</div>

<form method="post" action="" class="form-horizontal" role="form">

    <fieldset>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="signup">Allow User Signup:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="signup" id="signup">
                <option value="1" {if $signup_enable =='1'}selected="selected"{/if}>Yes</option>
                <option value="0" {if $signup_enable =='0'}selected="selected"{/if}>No</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/2.9/signup_settings#signup_enable" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="signup_verify">Signup Verification:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="signup_verify" id="signup_verify">
                <option value="1" {if $signup_verify eq "1"}selected="selected"{/if}>Enable</option>
                <option value="0" {if $signup_verify eq "0"}selected="selected"{/if}>Disable</option>
                <option value="2" {if $signup_verify eq "2"}selected="selected"{/if}>Admin</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/2.9/signup_settings#signup_verify" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="notify_signup">Notify Signup:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="notify_signup" id="notify_signup">
                <option value="1" {if $notify_signup eq "1"}selected="selected"{/if}>Enable</option>
                <option value="0" {if $notify_signup eq "0"}selected="selected"{/if}>Disable</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/2.9/signup_settings#notify_signup" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="signup_captcha">Signup Captcha:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="signup_captcha" id="signup_captcha">
                <option value="1" {if $signup_captcha eq "1"}selected="selected"{/if}>Enable</option>
                <option value="0" {if $signup_captcha eq "0"}selected="selected"{/if}>Disable</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/2.9/signup_settings#signup_captcha" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="captcha_type">Signup Captcha Type:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="captcha_type" id="captcha_type">
                <option value="default" {if $captcha_type eq "default"}selected="selected"{/if}>Default</option>
                <option value="recaptcha" {if $captcha_type eq "recaptcha"}selected="selected"{/if}>Recaptcha</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/2.9/signup_settings#captcha_type" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group recaptcha-keys">
        <label class="col-sm-3 control-label" for="recaptcha_sitekey">reCaptcha Site Key:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input type="text" name="recaptcha_sitekey" id="recaptcha_sitekey" value="{$recaptcha_sitekey}" class="form-control">
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/2.9/signup_settings#recaptcha_sitekey" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group recaptcha-keys">
        <label class="col-sm-3 control-label" for="recaptcha_secretkey">reCaptcha Secret Key:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input type="text" name="recaptcha_secretkey" id="recaptcha_secretkey" value="{$recaptcha_secretkey}" class="form-control">
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/2.9/signup_settings#recaptcha_secretkey" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="signup_dob">Date of Birth on Signup:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="signup_dob" id="signup_dob">
                <option value="0" {if $signup_dob =='0'}selected="selected"{/if}>No</option>
                <option value="1" {if $signup_dob =='1'}selected="selected"{/if}>Yes</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/2.9/signup_settings#signup_dob" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="signup_age_min">Age Minimum:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="signup_age_min" value="{$signup_age_min}" id="signup_age_min">
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/2.9/signup_settings#signup_age_min" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

     <div class="form-group">
        <label class="col-sm-3 control-label" for="signup_age_min_enforce">Age Minimum Enforce:</label>
        <div class="col-sm-5">
            <div class="input-group">
            <select class="form-control" name="signup_age_min_enforce" id="signup_age_min_enforce">
                <option value="0" {if $signup_age_min_enforce =='0'}selected="selected"{/if}>No</option>
                <option value="1" {if $signup_age_min_enforce =='1'}selected="selected"{/if}>Yes</option>
            </select>
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/2.9/signup_settings#signup_age_min_enforce" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="signup_auto_friend">Default Friend:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control" type="text" name="signup_auto_friend" id="signup_auto_friend" value="{$signup_auto_friend}" />
                <div class="input-group-addon">
                    <a href="http://buyscripts.in/docs/vshare/2.9/signup_settings#signup_auto_friend" target="_blank"><span class="glyphicon glyphicon-question-sign"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Update</button>
        </div>
    </div>

    </fieldset>

</form>

<script>
if ($("#captcha_type").val() == "default") {
    $(".recaptcha-keys").addClass("hidden");
}
$("#captcha_type").change(function(){
    var captcha_type = $(this).val();
    if (captcha_type == "recaptcha") {
        $(".recaptcha-keys").removeClass("hidden");
    } else {
        $(".recaptcha-keys").addClass("hidden");
    }
});
</script>