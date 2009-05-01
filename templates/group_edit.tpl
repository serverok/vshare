<div class="section">

    <div class="hd">
        <div class="hd-l">Edit Group</div>
        <div class="hd-r"><a href="{$base_url}/group/{$group_info.group_url}/">Back to {$group_info.group_name}</a></div>
    </div>
    
    <form name="group-edit" id="group-edit" method="post" action="{$base_url}/group/{$group_info.group_url}/edit/">
      
        <div>
            <label for="group_name">Group Name:</label>
            <input type="text" maxlength="60" size="53" name="group_name" id="group_name" value="{$group_info.group_name}" />
        </div>

        <div>
            <label for="group_keyword">Tags:</label>
            <input type="text" id="group_keyword" maxlength="60" size="53" name="group_keyword" value="{$group_info.group_keyword}" />            
            <div class="indent">            
                <strong>Enter one or more tags, separated by spaces.</strong><br />
                Tags are simply keywords used to describe your group so they are easily searched and organized.<br />
                For example, if you have a group for surfers, you might tag it: surfing beach waves.
            </div>
        </div>

        <div>
            <label for="group_description">Description:</label>
            <textarea cols="50" rows="5" name="group_description" id="group_description">{$group_info.group_description}</textarea>
            <div class="indent">
                <strong>Select between one to three channels that your group belong to.</strong><br />
                It helps to use relevant channels so that others can find your group!
            </div>
        </div>

        <div>
            <label>Group Channels:</label>
            <div class="indent">
                {$ch_checkbox}
            </div>
        </div>
        
        <div>
            <label>Type:</label>
            <div class="indent">
                <input type="radio" {if $group_info.group_type eq "public"}checked="checked"{/if} value=public name="group_type" /> Public, anyone can join <br />
                <input type="radio" {if $group_info.group_type eq "protected"}checked="checked"{/if} value=protected name="group_type" /> Protected, requires founder approval to join.<br />
                <input type="radio" {if $group_info.group_type eq "private"}checked="checked"{/if} value=private name="group_type" /> Private, by founder invite only, only members can view group details.
            </div>
        </div>

        <div>
            <label>Video Uploads:</label>
            <div class="indent">
                <input type="radio" {if $group_info.group_upload eq "immediate"}checked="checked"{/if} value="immediate" name="group_upload" />Post videos immediately.<br />
                <input type="radio" {if $group_info.group_upload eq "owner_approve"}checked="checked"{/if} value="owner_approve" name="group_upload" />Founder approval required before video is available.<br />
                <input type="radio" {if $group_info.group_upload eq "owner_only"}checked="checked"{/if} value="owner_only" name="group_upload" />Only Founder can add new videos.
            </div>
        </div>

        <div>
            <label>Forum Postings:</label>
            <div class="indent">
                <input type="radio" {if $group_info.group_posting eq "immediate"}checked="checked"{/if} value="immediate" name="group_posting" />Post topics immediately.<br />
                <input type="radio" {if $group_info.group_posting eq "owner_approve"}checked="checked"{/if} value="owner_approve" name="group_posting" /> Founder approval required before topic is available.<br />
                <input type="radio" {if $group_info.group_posting eq "owner_only"}checked="checked"{/if} value="owner_only" name="group_posting" />Only Founder can create a new topic.
            </div>
        </div>

        <div>
            <label>Group Icon:</label>
            <div class="indent">
                <input type="radio" {if $group_info.group_image eq "immediate"}checked="checked"{/if} value="immediate" name="group_image" /> Automatically set group icon to last uploaded video.<br />
                <input type="radio" {if $group_info.group_image eq "owner_only"}checked="checked"{/if} value="owner_only" name="group_image" /> Let owner pick the video as group icon.
            </div>
        </div>

        <div class="submit">
            <input type="submit" name="submit" value="Update" />
        </div>

    </form>
    
</div> <!-- section -->