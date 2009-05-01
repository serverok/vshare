{if $allow_invite eq "1"}

<div class="section page">
	
    <div class="hd">
    	<div class="hd-l">
    		Invite Friends to {$group_info.group_name}
    	</div>
    </div>

    <form action="{$base_url}/group/{$group_info.group_url}/invite/" id="invite-members-forum" name="invite-members-forum" method="post" onsubmit="return false;">

        <input type="hidden" name="send" value="send" />

		<table width="100%" border="0">
			<tr>
				<td align="center">
					<select name="myfriends" id="myfriends" size="10" style="width:200px;">
						{$fname}
					</select>
				</td>
				
				<td align="center">
					<input type="button" name="add_all" value="Add All >>" style="width:120px;" onclick="invite_mem_addall();" /><br /><br />
					<input type="button" name="add" value="Add >" style="width:120px;" onclick="invite_mem_add();" /><br /><br />
					<input type="button" name="remove" value="< Remove" style="width:120px;" onclick="invite_mem_remove();" /><br /><br />
					<input type="button" name="remove_all" value="<< Remove All" style="width:120px;" onclick="invite_mem_removeall();" /><br /><br />
				</td>
				
				<td align="center">
					<select name="flist[]" id="invitefriends" size="10" style="width:200px;" />
					</select>
                    <div id="friends_div"></div>
				</td>
			</tr>
		</table>
      
        <h3>Invite New Friends</h3>
        
        <hr />
        
        <div>
            <label>Email Address:</label>
            <div class="indent">
                Enter Email Addresses separated by Commas:<br />
                <textarea id="recipients" name="recipients" cols="40" rows="3">{$smarty.request.recipients}</textarea>
            </div>
        </div>

        <div>
            <label>Your Message:</label>
            <div class="indent">
                Enter your message below:<br />
                <textarea name="message" rows="5" cols="45">{$message}</textarea>
            </div>
        </div>
        
        <div class="submit">
            <input type="button" value="Send" name="action_invite" onclick="invite_mem_send();" />
		</div>
		
    </form>

</div> <!-- section -->

{else}

<div align="center">
	Sorry! You are not allowed to invite members.
</div>

{/if}