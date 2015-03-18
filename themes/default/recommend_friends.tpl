<div id="content">

    <div class="section bg2">
    
        <div class="hd">
            <div class="hd-l">Recommend Video</div>
        </div>

        <div style="padding:2em;">

            {if $report ne ""}
                {foreach from=$report item=msg}
                    {$msg}
                {/foreach}
            {else}
            
                <form method="post" action="">
                    <strong>Enter email addresses, separated by commas. Maximum 50 characters.</strong><br /><br />
                    <textarea id="recipients" name="emails" rows="5" cols="32" size="60" maxlength="200">{$emails}</textarea><br /><br />
                    <strong>Your name:</strong><br />
                    <input type="text" name="fname" value="{if $user_name ne ''}{$user_name}{else}{$fname}{/if}" maxlength="100" style="width :255px;" /><br />
                    <strong>Your Email:</strong><br />
                    <input type="text" name="guest_email" maxlength="100" value="{if $guest_email ne ''}{$guest_email}{else}{$user_email}{/if}" style="width :255px;" /><br /><br />
                    <strong>Add a personal message:</strong><br />
                    <textarea wrap="virtual" name="message" rows="6" cols="32" maxlength="200">{if $message ne ""}{$message}{else}This is awesome!{/if}</textarea><br /><br />
                    <input type="submit" name="submit" value="Send" />
                </form>
            
            {/if}

        </div>
        
    </div>

</div> <!--  content -->

<div id="sidebar">
    {insert name=advertise adv_name='wide_skyscraper'}
</div>