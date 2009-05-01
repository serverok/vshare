<h1>Channel Search</h1>

<form action="" method="get">
    
    <div>
        <input type="hidden" name="action" value="search">
        <label>Channel ID:</label>
        <input type="text" name="id" />
    </div>
    
    <div>
        <label>Channel Name:</label>
        <input type="text" name="name" />
    </div>
    
    <div class="submit">
        <input type="submit" name="search" value="Search" />
    </div>
    
</form>

<div style="clear:both"></div>

{if $channel.channel_id ne ""}

{insert name=channel_count assign=count cid=$channel.channel_id}

<div id="channel-search-result">

    <div class="margin-tb-1em">
        <img src="{$base_url}/chimg/{$channel.channel_id}.jpg" width="120" height="90" alt="channel" />
    </div> 
        
    <div>
        <b>Channel ID: </b>
        {$channel.channel_id}
    </div>

    <div>
        <b>Channel Name: </b>
        {$channel.channel_name}
    <div>

    <div>
        <b>Description: </b>
        {$channel.channel_description}
    </div>

    <div>
        <b>Total Videos: </b>
        {$count[1]}
    </div>

    <div>
        <b>Total Groups: </b>
        {$count[2]}
    </div>
        
    <div class="margin-tb-1em;">
        <a href="channel_edit.php?action=edit&chid={$channel.channel_id}&page={$smarty.request.page}">
            Edit Channel
        </a>
    </div>

</div> 

{/if}