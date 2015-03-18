<table width="100%" cellpadding="3" cellspacing="0" align="center" border="0">
    <thead>
        <tr>
            <td colspan="5"><span style="font-size: 15px; font-weight: bold;">Compose</span></td>
        </tr>
    </thead>
</table>

<div class="compose-container">
    <form action="javascript:void(0);" id="frm" method="post" onsubmit="javascript:mail.send();">
        <div>
            <label>To:</label>
            <input type="text" name="mail_to" id="mail_to" maxlength="40" value="{$mail_to}" />
        </div>
        
        <div>
            <label>Subject:</label>
            <input type="text" name="mail_subject" id="mail_subject" value="{$mail_subject}" maxlength="200" size="50" />
        </div>
        
        <div>
            <label>Message:</label>
            <textarea name="mail_body" id="mail_body" cols="50" rows="10">{$mail_body}</textarea>
        </div>
        
        <div>
            <label>&nbsp;</label>
            <input type="submit" name="send" value="Send" />
        </div>
    </form>
</div>