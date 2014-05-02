<h1>Site Settings</h1>

<form method="post" action="settings.php">

    <div>
        <label for="site_name">Site Name:</label>
        <input name="site_name" id="site_name" value="{$site_name}" size="40" />
        <a href="http://labs.buyscripts.in/projects/vshare/wiki/Site_Name" target="_blank"><img src="{$img_css_url}/images/help.png" alt="help" /></a>
    </div>

    <div>
        <label for="meta_keywords">Meta Keywords:</label>
        <input name="meta_keywords" id="meta_keywords" value="{$meta_keywords}" size="40" />
        <a href="http://labs.buyscripts.in/projects/vshare/wiki/Meta_Keywords" target="_blank"><img src="{$img_css_url}/images/help.png" alt="help" /></a>
    </div>

    <div>
        <label for="meta_description">Meta Description:</label>
        <input name="meta_description" id="meta_description" value="{$meta_description}" size="40" />
        <a href="http://labs.buyscripts.in/projects/vshare/wiki/Meta_Description" target="_blank"><img src="{$img_css_url}/images/help.png" alt="help" /></a>
    </div>

    <div>
        <label for="admin_email">Admin Email:</label>
        <input name="admin_email" id="admin_email" value="{$admin_email}" size="40" />
        <a href="http://labs.buyscripts.in/projects/vshare/wiki/Admin_Email" target="_blank"><img src="{$img_css_url}/images/help.png" alt="help" /></a>
    </div>

    <div>
        <label for="items_per_page">List Per Page:</label>
        <input name="items_per_page" id="items_per_page" value="{$items_per_page}" size="40" />
        <a href="http://labs.buyscripts.in/projects/vshare/wiki/List_Per_Page" target="_blank"><img src="{$img_css_url}/images/help.png" alt="help" /></a>
    </div>

    <div>
        <label for="rel_video_per_page">Related Videos:</label>
        <input name="rel_video_per_page" id="rel_video_per_page" value="{$rel_video_per_page}" size="40" />
        <a href="http://labs.buyscripts.in/projects/vshare/wiki/Related_Videos" target="_blank"><img src="{$img_css_url}/images/help.png" alt="help" /></a>
    </div>

    <div>
        <label for="num_watch_videos">Watch Videos:</label>
        <input name="num_watch_videos" id="num_watch_videos" value="{$num_watch_videos}" size="40" />
        <a href="http://labs.buyscripts.in/projects/vshare/wiki/Watch_Videos" target="_blank"><img src="{$img_css_url}/images/help.png" alt="help" /></a>
    </div>

    <div>
        <label for="guest_limit">Guest Limit:</label>
        <input name="guest_limit" id="guest_limit" value="{$guest_limit}" size="40" />
        <a href="http://labs.buyscripts.in/projects/vshare/wiki/Guest_Limit" target="_blank"><img src="{$img_css_url}/images/help.png" alt="help" /></a>
    </div>

    <div>
        <label for="cache_enable">Cache</label>
        <select name="cache_enable" id="cache_enable">
            <option value="1" {if $cache_enable eq "1"}selected="selected"{/if}>Yes</option>
            <option value="0" {if $cache_enable eq "0"}selected="selected"{/if}>No</option>
        </select>
        <a href="http://labs.buyscripts.in/projects/vshare/wiki/Cache" target="_blank"><img src="{$img_css_url}/images/help.png" alt="help" /></a>
    </div>

    <div>
        <label for="allow_html">Allow Links in comment:</label>
        <select name="allow_html" id="allow_html">
            <option value="1" {if $allow_html eq "1"}selected="selected"{/if}>Yes</option>
            <option value="0" {if $allow_html eq "0"}selected="selected"{/if}>No</option>
        </select>
        <a href="http://labs.buyscripts.in/projects/vshare/wiki/Allow_Links_in_comment" target="_blank"><img src="{$img_css_url}/images/help.png" alt="help" /></a>
    </div>

    <div>
        <label for="auto_approve">Auto Approve:</label>
        <select name="approve" id="auto_approve">
            <option value="1" {if $approve eq "1"}selected="selected"{/if}>Enable</option>
            <option value="0" {if $approve eq "0"}selected="selected"{/if}>Disable</option>
        </select>
        <a href="http://labs.buyscripts.in/projects/vshare/wiki/Auto_Approve" target="_blank"><img src="{$img_css_url}/images/help.png" alt="help" /></a>
    </div>

    <div>
        <label for="moderate_video_links">Moderate Uploads with Link:</label>
        <select name="moderate_video_links" id="moderate_video_links">
            <option value="1" {if $moderate_video_links eq "1"}selected="selected"{/if}>Yes</option>
            <option value="0" {if $moderate_video_links eq "0"}selected="selected"{/if}>No</option>
        </select>
    </div>

    <div>
        <label for="debug">Debug Mode:</label>
        <select name="debug" id="debug">
            <option value="1" {if $debug eq "1"}selected="selected"{/if}>Enable</option>
            <option value="0" {if $debug eq "0"}selected="selected"{/if}>Disable</option>
        </select>
        <a href="http://labs.buyscripts.in/projects/vshare/wiki/Auto_Approve" target="_blank"><img src="{$img_css_url}/images/help.png" alt="help" /></a>
    </div>

    <div>
        <label for="notify_upload">Notify Upload:</label>
        <select name="notify_upload" id="notify_upload">
            <option value="1" {if $notify_upload eq "1"}selected="selected"{/if}>Enable</option>
            <option value="0" {if $notify_upload eq "0"}selected="selected"{/if}>Disable</option>
        </select>
    </div>

    <div>
        <label for="embed_show">Embed Show:</label>
        <select name="embed_show" id="embed_show">
            <option value="1" {if $embed_show eq "1"}selected="selected"{/if}>Enable</option>
            <option value="0" {if $embed_show eq "0"}selected="selected"{/if}>Disable</option>
        </select>
    </div>

    <div>
        <label for="embed_type">Embed Type:</label>
        <select name="embed_type" id="embed_type">
            <option value="0" {if $embed_type eq "0"}selected="selected"{/if}>IFRAME</option>
            <option value="1" {if $embed_type eq "1"}selected="selected"{/if}>OBJECT</option>
        </select>
    </div>

    <div>
        <label for="enable_package">Service Type:</label>
        <select name="enable_package" id="enable_package">{$service_ops}</select>
        <a href="http://labs.buyscripts.in/projects/vshare/wiki/Service_Type" target="_blank"><img src="{$img_css_url}/images/help.png" alt="help" /></a>
    </div>

    {if $enable_package eq "yes"}

        <div>
            <label>Payment Method:</label>
            {$payment_method_ops}
        </div>

        <div>
            <label>CCBill Account No:</label>
            <input type="text" name="ccbill_ac_no" value="{$ccbill_ac_no}">
        </div>

        <div>
            <label>CCBill Sub account No:</label>
            <input type="text" name="ccbill_sub_ac_no" value="{$ccbill_sub_ac_no}">
        </div>

		<div>
            <label>CCBill Form Name:</label>
            <input type="text" name="ccbill_form_name" value="{$ccbill_form_name}">
        </div>

        <div>
            <label for="paypal_receiver_email">Paypal Receiver Email:</label>
            <input name="paypal_receiver_email" id="paypal_receiver_email" value="{$paypal_receiver_email}" size="40" />
        </div>

        <div>
            <label>Enable Test Payment ?</label>
            <div class="indent">
                <input type=radio name=enable_test_payment value="yes" {if $enable_test_payment eq "yes"}checked="checked"{/if} /> Yes<br />
                <input type=radio name=enable_test_payment value="no" {if $enable_test_payment ne "yes"}checked="checked"{/if} /> No<br />
            </div>
        </div>

    {/if}

    <div>
        <label for="family_filter">Family Filter:</label>
        <select name="family_filter" id="family_filter">
            <option value="1" {if $family_filter eq "1"}selected="selected"{/if}>Enable</option>
            <option value="0" {if $family_filter eq "0"}selected="selected"{/if}>Disable</option>
        </select>
    </div>

    <div>
        <label for="hotlink_protection">Hotlink Protection:</label>
        <select name="hotlink_protection">
            <option value="0"{if $hotlink_protection eq "0"} selected="selected"{/if}>Disabled</option>
            <option value="1"{if $hotlink_protection eq "1"} selected="selected"{/if}>Normal Hotlink Protection</option>
            <option value="2"{if $hotlink_protection eq "2"} selected="selected"{/if}>Only Allow Logged in Users</option>
        </select>
    </div>

    <div class="submit">
        <input type="submit" name="submit" value="Update" class="btn btn-primary" />
    </div>

</form>
