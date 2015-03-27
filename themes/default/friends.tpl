<div class="col-md-9">
    {if $total_friends eq "0"}
        <div class="alert alert-warning">
            <p><strong>You have not invited any friends or family at this time!</strong></p>
            <p><a href="{$base_url}/invite_friends.php">Invite</a> your friends and family to start sharing videos today!</p>
        </div>
    {else}
        <div class="page-header">
            <h1>
                My Contacts :
                <small>
                {if $smarty.request.view eq ""}
                    Overview
                {else}
                    {$smarty.request.view}
                {/if}
                {if $smarty.request.view ne "" and $smarty.request.view ne "All"}
                (<a class="text-danger" href="friends.php?del_list={$smarty.get.view}" onclick="javascript: return confirm('Are you sure you want to delete this contact group?')" title="Delete list">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>)
                {/if}
                </small>
                <span class="pull-right font-size-md">
                    {if $smarty.request.sort ne "name"}
                        <a class="btn" href="{$base_url}/friends/?view={$view}&sort=name">Sort by Name</a> | Sort by Date Added
                    {else}
                        Sort by Name | <a class="btn" href="{$base_url}/friends/?view={$view}">Sort by Date Added</a>
                    {/if}
                </span>
            </h1>
        </div>

        <div class="pull-right">
            <div class="input-group">
                <span class="input-group-addon">View:</span>
                <select name="view" class="form-control" onchange="javascript: document.location.href='{$base_url}/friends.php?view='+this.value;">
                    {$ftype_ops}
                </select>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="clearfix">&nbsp;</div>

        {if $total ne "0"}{$link}{/if}

        <form id="friendsForm" name="friendsForm" action="" method="post" class="form-horizontal" role="form">
            <input type="hidden" name="action_name" id="action_name">
            <input type="hidden" name="view">
            <input type="hidden" value="t" name="sort">
            <input type="hidden" value="1" name="page">

            {section name=i loop=$friends}
                <div class="row">
                    <div class="col-md-4">
                        <div class="thumbnail">
                            {if $friends[i].friend_id ne ''}
                                <a href="{$base_url}/{$friends[i].friend_name}">
                                    {insert name=member_img UID=$friends[i].friend_friend_id}
                                </a>
                            {/if}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label>
                            <input id="AID[]" type="checkbox" value="{$friends[i].friend_id}" name="AID[]">
                            {if $friends[i].friend_status eq "Confirmed"}
                            <a href="{$base_url}/{$friends[i].friend_name}">{$friends[i].friend_name}</a>
                            {else}
                            {$friends[i].friend_name}
                            {/if}
                        </label>

                        {if $friends[i].friend_status eq "Confirmed"}
                            {insert name=video_count assign=video uid=$friends[i].friend_friend_id}
                            {insert name=favour_count assign=favour uid=$friends[i].friend_friend_id}
                            {insert name=friends_count assign=frnd uid=$friends[i].friend_friend_id}
                            <p>
                                Videos:
                                {if $video ne "0" and $video ne ""}
                                    <a href="{$base_url}/{$friends[i].friend_name}/public/">{$video}</a>
                                {else}
                                    0
                                {/if}
                                | Favorites:
                                {if $favour ne "0"}
                                    <a href="{$base_url}/{$friends[i].friend_name}/favorites/">
                                        {$favour}
                                    </a>
                                    {else}
                                        0
                                    {/if}
                                | Friends: {if $frnd ne "0"}
                                <a href="{$base_url}/{$friends[i].friend_name}/friends/">
                                    {$frnd}
                                </a>
                                {else}
                                    0
                                {/if}
                            </p>
                        {/if}
                        {insert name=showlist assign=showlist id=$friends[i].friend_id}
                        <p>Lists: {$showlist}</p>
                        <p>
                            Status: {$friends[i].friend_status}
                            {if $friends[i].friend_status eq "Pending"}
                                ({$friends[i].friend_invite_date|date_format:"%B %e, %Y"})
                            {/if}
                        </p>
                    </div>
                </div>
             <hr>
            {/section}

            <div class="col-md-6">
                <select id="action" onchange=doAction(this.value) name="action" class="form-control">
                    {$action_ops}
                </select>
            </div>
            <div class="col-md-6">
                <a class="btn btn-default" href="javascript:createNewList();">New List</a>
            </div>
            {if $page_links ne ""}
                <div class="clearfix"></div>
                <div>{$page_links}</div>
            {/if}
        </form>
    {/if}
</div>
<div class="col-md-3">
   {insert name=advertise adv_name='wide_skyscraper'}
</div>