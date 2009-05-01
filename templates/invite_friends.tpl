<div id="content">

    {if $smarty.get.welcome eq "1"}
    
        <div class="page">
            <h2>Welcome to {$site_name}, {$user_name}!</h2>
            <p>We hope you enjoy your experience. Write anytime to let us know how we can serve you better.</p>
            <p><i>The {$site_name} Team</i></p>
        </div>
            
        <div class="bg2 padding-1em page">
        
            <h3>What would you like to do next?</h3>
            
            <div class="invite-friends-welcome clearfix">
            
                <div class="box-1">
                    <ul>
                        <li>
                            <a href="{$base_url}/{$smarty.session.USERNAME}/edit/"><strong>Complete your profile page</strong></a>
                            <p>The {$site_name} community wants to know about you.</p>
                        </li>
                        <li>
                            <a href="{$base_url}/upload/"><strong>Upload your videos</strong></a>
                            <p>Share your experiences with the world.</p>
                        </li>
                    </ul>
                </div>
                
                <div  class="box-2">
                    <ul>
                       <li>
                          <a href="{$base_url}/channels/"><strong>Browse the channels</strong></a>
                          <p>Watch videos organized into categories.</p>
                       </li>
                        <li>
                            <a href="{$base_url}/recent/"><strong>Start watching videos </strong></a>
                            <p>Search and browse 1000's of streaming videos.</p>
                        </li>
                    </ul>
                </div>
            
            </div>
        
        </div>
        
    {/if}
    
    <div class="section">
    
        <div class="hd">
            <div class="hd-l">Invite Your Friends</div>
        </div>
        
        <form action="" method="post" id="invite-friends-form">
        
            <p class="intro">
                We'll send each person you list below an email invitation to join {$site_name} as your friend or family.
            </p>
            
            <div>
                <label>Your First Name:</label>
                <input maxlength="60" size="30" name="first_name" value="{$first_name}" />
            </div>
           
            <div>
                <label>{if $smarty.get.UID eq ""}Email Addresses:{else}Send to:{/if}</label>
                {if $smarty.get.UID eq ""}
                    Enter Email Addresses separated by a Comma:<br />
                    <textarea id="recipients" name="recipients" cols="45" rows="3">{$recipients}</textarea>
                    <input type="hidden" name="UID" value="" />
                {else}
                    <input type="hidden" name="UID" value="{$smarty.get.UID}" />
                    {insert name=id_to_name assign=uname un=$smarty.get.UID}
                    {$uname}
                {/if}
            </div>

            <div>
                <label>Your Message:</label>
                <div class="indent">
                    {if $smarty.get.UID eq ""}
                        Hello,
                    {else}
                        {insert name=id_to_name assign=uname un=$smarty.get.UID}
                        Hello {$uname},
                    {/if}
                    <br /><br />
            
                    {$site_name} is a new site for sharing and hosting personal videos.<br />
        
                    I have been using {$site_name} to share videos with my friends and family.<br />
            
                    I would like to add you to the list of people I may share videos with.<br /><br />
            
                    Personal message from [{if $first_name ne "" }{$first_name}{else}Your Name{/if}]:<br /><br />
                    
                    <textarea name="message" rows="5" cols="45">Have you heard about {$site_name}? I love this site.</textarea>
                </div>
            </div>

            <div class="submit">
                <input type="submit" value="Send Invite" name="submit" />
            </div>
            
        </form>
        
    </div>
    
</div> <!-- content -->

<div id="sidebar">
    {insert name=advertise adv_name='wide_skyscraper'}
</div>