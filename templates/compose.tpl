{include file=error.tpl}

<div id="content">

	<div class="section bg2">
	
		<div class="hd">
			<div class="hd-l">Send Message</div>
		</div>

		<div class="compose-container">
		
			<form action="" method="post">

                <div>
                    <label>To:</label>
                    <input type="text" name="mail_to" maxlength="40" value="{$mail_to}" />
                </div>			   
                
                <div>
                    <label>Subject:</label>
                    <input type="text" name="mail_subject" value="{$mail_subject}" maxlength="200" size="50" />
                </div>

                <div>
                    <textarea name="mail_body" cols="60" rows="6">{$mail_body}</textarea>
                </div>

                <div>
                    <input type="submit" name="send" value="Send" />
                </div>
                
			</form>
		
		</div>
    
	</div> <!-- section -->

</div> <!-- content -->

<div id="sidebar">
    {insert name=advertise adv_name='wide_skyscraper'}
</div>
