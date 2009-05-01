{if $msg_info ne ''}

<div id="content">

    <div class="section bg2">
        
        <div class="hd">
            <div class="hd-l">{$msg_info.mail_subject}</div>
        </div>
            
        <div class="private-message-photo">
            <a href="{$base_url}/{$sender}{$msg_info.mail_sender}">
                {insert name=member_img UID=$msg_info.user_id} 
            </a>
        </div>

        <div class="private-message-meta">
            
            <div>
                <b>Sender: </b><a href="{$base_url}/{$sender}{$msg_info.mail_sender}">{$msg_info.mail_sender}</a><br />
                <b>Sent: </b>{$msg_info.mail_date}
            </div>

            <div class="private-message-reply">
                {if $smarty.get.folder ne 'outbox'}
                    <a href="{$base_url}/compose.php?receiver={$msg_info.mail_sender}&subject={$reply_subject}">Reply</a>
                {/if}
                <a href="{$base_url}/mail_delete.php?mail_id={$msg_info.mail_id}&folder={$smarty.get.folder}">Delete</a>
            </div>
            
        </div>
        
        <div class="clearfix"></div>
        
        <div class="private-message">
            <b>Details: </b>{$msg_info.mail_body}
        </div>

    </div> <!-- section -->

</div> <!-- content -->

{else}

<div id="content">
    <h5>Message not found.</h5>
</div>

{/if}

<div id="sidebar">
    {insert name=advertise adv_name='wide_skyscraper'}
</div>
