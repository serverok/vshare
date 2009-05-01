<div id="content">

    {if $total ne "0"}

        <form method="post" action="{$base_url}/mail_delete.php" name="mail" id="mail-box-listing" onsubmit="return validate_frm();">
    
            <input type="hidden" name="folder" value="{$mail_folder}" />
            
            <div class="section bg2 mail-box">
            
                <div class="hd">
                    <div class="hd-l">{$mail_title}</div>
                    <div class="hd-r">{if $total ne "0"}Messages {$start_num} - {$end_num} of {$total}{/if} </div>
                </div>
                
                <table width="700" cellpadding="3" cellspacing="0" align="center" border="0">
                
                    <tr class="bg4">
                        <td width="5">&nbsp;</td>
                        <td width="5">&nbsp;</td>
                        <td><b>Subject</b></td>
                        <td width="70"><b>{if $mail_folder eq 'inbox'}From{else}To{/if}</b></td>
                        <td width="160"><b>Date</b></td>
                    </tr>
                    
                    {section name=i loop=$mails}
                    
                    <tr class="{cycle values="bg2,bg3"}">
                        <td>
                            <input type="checkbox" name="mid[]" value="{$mails[i].mail_id}" />
                        </td>
                        <td width="5">
                            {if $mails[i].mail_read == "0" AND $mail_folder eq 'inbox'}
                                <img src="{$img_css_url}/images/newmail.gif" alt="New Message" />
                            {else}
                                <img src="{$img_css_url}/images/mail.gif" alt="Message" />
                            {/if}
                        </td>
                        <td>
                            <a href="{$base_url}/msg.php?id={$mails[i].mail_id}{if $mail_folder eq outbox}&folder={$mail_folder}{/if}">
                                {$mails[i].mail_subject}
                            </a>
                        </td>
                        <td>
                            {if $mail_folder eq 'inbox'}
                                <a href="{$base_url}/{$mails[i].mail_sender}">{$mails[i].mail_sender}</a>
                            {else}
                                <a href="{$base_url}/{$mails[i].mail_receiver}">{$mails[i].mail_receiver}</a>
                            {/if}
                        </td>
                        <td>
                            {$mails[i].mail_date}
                        </td>
                    </tr>
                    {/section}
                    
                    <tr class="bg4">
                        <td width="5"><input type="checkbox" name="select_all" id="select_all" /></td>
                        <td width="5"><input type="image" src="{$img_css_url}/images/del.gif" title="Delete" /></td>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    
                </table>

                {if $page_link ne ''}
                    <div class="page_links">
                        Pages: {$page_link}
                    </div>
                {/if}
            </div>
        </form>

    {else}
        <h5>You have no messages in your {$mail_title}</h5>
    {/if}

</div> <!--  content -->

<div id="sidebar">
    {insert name=advertise adv_name='wide_skyscraper'}
</div> 

<script language="JavaScript" type="text/javascript" src="{$base_url}/js/mail.js"></script>