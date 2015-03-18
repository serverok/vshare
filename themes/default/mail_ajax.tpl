<table width="100%" cellpadding="3" cellspacing="0" align="center" border="0">
    <thead>
	    <tr>
	        <td colspan="5">
	           <span style="font-size: 15px; font-weight: bold;">{$mail_folder|capitalize}</span>
	           <hr>
	        </td>
	    </tr>
	    {if $mails|@count gt "0"}
		    <tr class="bg2">
		        <td width="5%">&nbsp;</td>
		        <td width="5%">&nbsp;</td>
		        <td width="20%">{if $mail_folder eq 'inbox'}From{else}To{/if}</td>
		        <td width="">Subject</td>
		        <td width="15%">Date</td>
		    </tr>
	    {/if}
    </thead>
    
    <tbody>
	    {section name=i loop=$mails}
	        <tr rel="mail-list" valign="top">
	            <td align="center">
	                <input type="checkbox" name="mid[]" value="{$mails[i].mail_id}" />
	            </td>
	            <td align="center">
	                {if $mails[i].mail_read == "0" AND $mail_folder eq 'inbox'}
	                    <img src="{$img_css_url}/images/newmail.gif" alt="New Message" />
	                {else}
	                    <img src="{$img_css_url}/images/mail.gif" alt="Message" />
	                {/if}
	            </td>
                <td align="left">
                    {if $mail_folder eq 'inbox'}
                        <a href="{$base_url}/{$mails[i].mail_sender}">{$mails[i].mail_sender}
                    {else}
                        <a href="{$base_url}/{$mails[i].mail_receiver}">{$mails[i].mail_receiver}
                    {/if}
                    
	                    <div rel="mail-detail" id="mail-photo-{$mails[i].mail_id}" style="display: none;">
	                        {insert name=member_img UID=$mails[i].user_id}
	                    </div>
                    </a>
                </td>
	            <td align="left">
	                <a href="javascript:void(0);" onclick="mail.detail('{$mails[i].mail_id}', '{$mail_folder}', '{$mails[i].mail_read}');">
	                    {$mails[i].mail_subject}
	                </a>
	                <div rel="mail-detail" id="mail-body-{$mails[i].mail_id}" style="display: none;">{$mails[i].mail_body}</div>
	                
	                {if $mail_folder ne 'outbox'}
                        <p rel="mail-detail" id="mail-reply-{$mails[i].mail_id}" style="display: none;">
                            <a id="mail-reply-bttn" href="javascript:void(0);" onclick="mail.compose('{$mails[i].mail_sender}','Re: {$mails[i].mail_subject}');">Reply</a>
                        </p>
                    {/if}
	            </td>
	            <td align="left">
	                {$mails[i].mail_date}
	            </td>
	        </tr>
	    {sectionelse}
	        <tr>
	            <td colspan="5" align="center"><h3>There are no messages in this folder.</h3></td>
	        </tr>
	    {/section}
    </tbody>
    
    {if $mails|@count gt "0"}
	    <tr class="page_links">
	        <td align="center"><input type="checkbox" name="select_all" id="select_all" /></td>
	        <td align="center"><input type="image" id="del-mails" onclick="mail.del('{$mail_folder}');" src="{$img_css_url}/images/del.gif" title="Delete" /></td>
	        <td align="right" colspan="3">{if $page_link ne ''}{$page_link}{else}&nbsp;{/if}</td>
	    </tr>
    {/if}
</table>

{literal}
<script type="text/javascript">
$(function(){
	$("#select_all").click(function(){
		var checked_status = this.checked;
		$("input[name='mid[]']").each(function(){
			this.checked = checked_status;
		});
	});
});
mail.rowcolor();
</script>
{/literal}