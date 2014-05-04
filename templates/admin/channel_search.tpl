<div class="page-header">
    <h1>Channel Search</h1>
</div>

<form action="" method="get" class="form-horizontal" role="form">

    <input type="hidden" name="action" value="search">

    <div class="form-group">
        <label class="col-sm-2 control-label">Channel ID:</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="id" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Channel Name:</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="name" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" name="search" class="btn btn-default btn-lg">Search</button>
        </div>
    </div>

</form>

<div style="clear:both; margin-bottom: 2em"></div>

{if $channel.channel_id ne ""}

{insert name=channel_count assign=count cid=$channel.channel_id}

<div>
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

<div style="margin-top: 2em">
    <a href="channel_edit.php?action=edit&chid={$channel.channel_id}&page={$smarty.request.page}" class="btn btn-default btn-lg">
        Edit Channel
    </a>
</div>

{/if}