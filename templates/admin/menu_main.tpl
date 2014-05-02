<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->

    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#vshare-admin-main-menu">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php">vShare</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->

    <div class="collapse navbar-collapse" id="vshare-admin-main-menu">

        <ul class="nav navbar-nav">

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Configuration <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="settings.php">Site Settings</a></li>
                    <li><a href="settings_video.php">Video Settings</a></li>
                    <li><a href="settings_signup.php">Signup Settings</a></li>
                    <li><a href="settings_player.php">Player Settings</a></li>
                    <li><a href="settings_miscellaneous.php">Miscellaneous</a></li>
                    <li><a href="settings_home.php">Home Page</a></li>
                    <li class="divider"></li>
                    <li><a href="upload_logo.php">Upload Logo</a></li>
                    <li><a href="upload_watermark.php">Upload Watermark</a></li>
                    <li><a href="advertisements.php">Advertisements</a></li>
                    <li><a href="admin_log.php">Admin Log</a></li>
                    <li><a href="email_templates.php">Email Templates</a></li>
                    <li class="divider"></li>
                    <li><a href="server_manage.php">List Server</a></li>
                    <li><a href="server_add.php">Add Server</a></li>
                    <li class="divider"></li>
                    <li><a href="change_password.php">Admin password</a></li>
               </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="users.php">All Users</a></li>
                    <li><a href="users.php?a=Active">Active Users</a></li>
                    <li><a href="users.php?a=Inactive">Inactive Users</a></li>
                    <li><a href="users.php?a=Suspend">Suspend Users</a></li>
                    <li><a href="user_search.php">Search Users</a></li>
                    <li><a href="mail_users.php?a=user">Email Users</a></li>
                    <li><a href="user_add.php">Add User</a></li>
               </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Videos <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="videos.php">All Videos</a></li>
                    <li><a href="video_approve.php">Approve Videos</a></li>
                    <li><a href="videos.php?a=public">Public Videos</a></li>
                    <li><a href="videos.php?a=private">Private Videos</a></li>
                    {if $family_filter}
                    <li><a href="videos.php?a=adult">Adult Videos</a></li>
                    {/if}
                    <li><a href="video_inactive.php">Inactive Videos</a></li>
                    <li><a href="video_featured.php">Featured Videos</a></li>
                    <li><a href="video_feature_requests.php">Feature Requests</a></li>
                    <li><a href="videos.php?a=inappropriate">Flagged Videos</a></li>
                    <li><a href="comment.php">Manage Comments</a></li>
                    <li><a href="video_user_deleted.php">User Deleted Videos</a></li>
                    <li><a href="video_search.php">Search Videos</a></li>
                    <li><a href="tags.php">Tags</a></li>
                    <li><a href="video_local.php">Local Videos</a></li>
                    <li><a href="videos.php?a=embedded">Embedded Videos</a></li>
               </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="channels.php">View Channels</a></li>
                    <li><a href="channel_add.php">Add Channels</a></li>
                    <li><a href="channel_search.php">Search Channels</a></li>
                    <li><a href="channel_sort.php">Sort Channels</a></li>
                    <li class="divider"></li>
                    <li><a href="groups.php">All Groups</a></li>
                    <li><a href="groups.php?a=public">Public Groups</a></li>
                    <li><a href="groups.php?a=private">Private Groups</a></li>
                    <li><a href="groups.php?a=protected">Protected Groups</a></li>
                    <li><a href="group_search.php">Search Groups</a></li>
                    <li class="divider"></li>
                    <li><a href="poll_list.php">View Polls</a></li>
                    <li><a href="poll_add.php">Add New Poll</a></li>
                    <li class="divider"></li>
                    <li><a href="page.php">List Pages</a></li>
                    <li><a href="page_add.php">Add Page</a></li>
                    <li class="divider"></li>
                    <li><a href="bad_words.php">Bad Words</a></li>
                    <li><a href="reserve_user_name.php">Reserve User Name</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Process <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="process_queue.php">Process Queue</a></li>
                    <li><a href="import_video.php">Import Video</a></li>
                    <li><a href="import_folder.php">Import Folder</a></li>
                    <li><a href="import_bulk.php">Bulk Import</a></li>
                    <li><a href="video_add_flv.php">Add FLV/Embed</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">More <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    {if $enable_package eq "yes"}
                    <li><a href="payments.php">Payments</a></li>
                    <li><a href="packages.php">Packages</a></li>
                    <li><a href="package_add.php">Add New Package</a></li>
                    <li><a href="subscription_extend.php">Extend Subscription</a></li>
                    <li><a href="subscription_edit.php">Edit Subscription</a></li>
                    <li class="divider"></li>
                    {/if}
                    <li><a href="sitemap.php">Site Map</a></li>
                    <li><a href="update_counters.php">Update Counters</a></li>
                    <li><a href="tags_regenerate.php">Regenerate Tags</a></li>
                    <li><a href="phpinfo.php">View PHP Info</a></li>
                </ul>
            </li>

        </ul>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php">Logout</a></li>
      </ul>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
