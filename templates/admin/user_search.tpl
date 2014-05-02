<h1>Search Users</h1>

<form action="" method="get">
    <input type="hidden" name="a" value="Search" />

    <div>
        <label>User ID:</label>
        <input type="text" name="userid" size="20" />
        <input type="submit" name="search" value="Search" />
    </div>

    <div>
        <label>User Name:</label>
        <input type="text" name="user_name" size="20" />
        <input type="submit" name="search" value="Search" />
    </div>

    <div>
        <label>User IP:</label>
        <input type="text" name="user_ip" size="20" />
        <input type="submit" name="search" value="Search" />
    </div>
</form>

{if $smarty.get.user_ip ne ""}

<h1>Users (IP: {$smarty.get.user_ip})</h1>

<table class="table table-striped">

    <tr>
        <td>
            <b>ID</b>
            <a href="user_search.php?user_ip={$smarty.get.user_ip}&sort=user_id+asc&page={$page}">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="user_search.php?user_ip={$smarty.get.user_ip}&sort=user_id+desc&page={$page}">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Name</b>
            <a href="user_search.php?user_ip={$smarty.get.user_ip}&sort=user_name+asc&page={$page}">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="user_search.php?user_ip={$smarty.get.user_ip}&sort=user_name+desc&page={$page}">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Country</b>
            <a href="user_search.php?user_ip={$smarty.get.user_ip}&sort=user_country+asc&page={$page}">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="user_search.php?user_ip={$smarty.get.user_ip}&sort=user_country+desc&page={$page}">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Last Login</b>
            <a href="user_search.php?user_ip={$smarty.get.user_ip}&sort=user_last_login_time+asc&page={$page}">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="user_search.php?user_ip={$smarty.get.user_ip}&sort=user_last_login_time+desc&page={$page}">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Video</b>
        </td>
        {if $enable_package eq "yes"}
        <td>
            <b>Package</b>
        </td>
        {/if}
        <td>
            <b>Status</b>
            <a href="user_search.php?user_ip={$smarty.get.user_ip}&sort=user_account_status+asc&page={$page}">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="user_search.php?user_ip={$smarty.get.user_ip}&sort=user_account_status+desc&page={$page}">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td align="center">
            <b>Action</b>
        </td>
    </tr>

    {section name=aa loop=$users}
        <tr class="{cycle values="tablerow1,tablerow2"}">
            <td>
                {$users[aa].user_id}
            </td>
            <td>
                <a href="user_view.php?user_id={$users[aa].user_id}&page={$smarty.request.page}">
                    {$users[aa].user_name}
                </a>
            </td>
            <td>
                {$users[aa].user_country}
            </td>
            <td>
                {$users[aa].user_last_login_time|date_format}
            </td>
            <td align="right">
                {insert name=video_count assign=vdo uid=$users[aa].user_id}
                {if $vdo ne "0"}
                    <a href="user_videos.php?uid={$users[aa].user_id}">
                        {$vdo}
                    </a>
                {else}
                    {$vdo}
                {/if}
            </td>
            {if $enable_package eq "yes"}
            <td>
                {insert name=subscriber_info assign=pack uid=$users[aa].user_id}
                {$pack.package_name}
            </td>
            {/if}
            <td align="center">
                {$users[aa].user_account_status}
            </td>
            <td align="center">
                <a href="user_edit.php?action=edit&uid={$users[aa].user_id}&page={$smarty.request.page}&sort={$smarty.request.sort}">
                    <span class="glyphicon glyphicon-edit"></span>
                </a> &nbsp;
                <a href="user_delete.php?uid={$users[aa].user_id}&a={$smarty.get.a}&page={$smarty.get.page}&sort={$smarty.get.sort}" onclick="Javascript:return confirm('Are you sure you want to delete?');">
                    <span class="glyphicon glyphicon-remove-circle"></span>
                </a> &nbsp;
                <a href="mail_users.php?email={$users[aa].user_email}&uname={$users[aa].user_name}">
                    <span class="glyphicon glyphicon-envelope"></span>
                </a> &nbsp;
                <a href="user_login.php?username={$users[aa].user_name}" target="_blank">
                    <span class="glyphicon glyphicon-log-in"></span>
                </a>
            </td>
        </tr>
    {sectionelse}
        <tr>
            <td colspan="8">
                <p><center>There is no users found with IP: {$smarty.get.user_ip}</center></p>
            </td>
        </tr>

    {/section}

</table>

{if $links ne ""}
    <div class="margin-tb-1em">
        {$links}
    </div>
{/if}

{/if}