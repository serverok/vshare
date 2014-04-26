<?php
/******************************************************************************
 *
 * COMPANY: BuyScripts.in
 * PROJECT: vShare Youtube Clone
 * VERSION: [VSHARE_VERSION]
 * LISENSE: http://buyscripts.in/vshare-license.html
 * WEBSITE: http://buyscripts.in/youtube_clone.html
 *
 * This program is a commercial software and any kind of using it must agree
 * to vShare license.
 *
 ******************************************************************************/

include '../include/config.php';

check_admin_login();

$menu_heading = array(
    array(
        'Site Configuration',
        '#',
        1
    ),
    array(
        'User Admin',
        '#',
        1
    ),
    array(
        'Video Management',
        '#',
        1
    ),
    array(
        'Channel Management',
        '#',
        1
    ),
    array(
        'Group Management',
        '#',
        1
    ),
    array(
        'Email Settings',
        '#',
        1
    ),
    array(
        'Poll setting',
        '#',
        1
    ),
    array(
        'Package Settings',
        '#',
        1
    ),
    array(
        'Other Settings',
        '#',
        1
    ),
    array(
        'Web Pages',
        '#',
        1
    ),
    array(
        'Video Processing',
        '#',
        1
    ),
    array(
        'Servers',
        '#',
        1
    ),
    array(
        'Maintenance',
        '#',
        1
    )
);

$menu_items = array(
    array(
        'Site Statistics',
        'home.php',
        0
    ),
    array(
        'Site Settings',
        'settings.php',
        0
    ),
    array(
        'Upload Logo',
        'upload_logo.php',
        0
    ),
    array(
        'Upload Watermark',
        'upload_watermark.php',
        0
    ),
    array(
        'Admin password',
        'change_password.php',
        0
    ),
    array(
        'Advertisements',
        'advertisements.php',
        0
    ),
    array(
        'Admin Log',
        'admin_log.php',
        0
    ),

    array(
        'All Users',
        'users.php',
        1
    ),
    array(
        'Active Users',
        'users.php?a=Active',
        1
    ),
    array(
        'Inactive Users',
        'users.php?a=Inactive',
        1
    ),
    array(
        'Suspend Users',
        'users.php?a=Suspend',
        1
    ),
    array(
        'Search Users',
        'user_search.php',
        1
    ),
    array(
        'Email Users',
        'mail_users.php?a=user',
        1
    ),
    array(
        'Add User',
        'user_add.php',
        1
    ),

    array(
        'All Videos',
        'videos.php',
        2
    ),
    array(
        'Public Videos',
        'videos.php?a=public',
        2
    ),
    array(
        'Private Videos',
        'videos.php?a=private',
        2
    ),
    array(
        'Approve Videos',
        'video_approve.php',
        2
    ),
    array(
        'Inactive Videos',
        'video_inactive.php',
        2
    ),
    array(
        'Featured Videos',
        'video_featured.php',
        2
    ),
    array(
        'Feature Requests',
        'video_feature_requests.php',
        2
    ),
    array(
        'Flagged Videos',
        'videos.php?a=inappropriate',
        2
    ),
    array(
        'Manage Comments',
        'comment.php',
        2
    ),
    array(
        'User Deleted Videos',
        'video_user_deleted.php',
        2
    ),
    array(
        'Search Videos',
        'video_search.php',
        2
    ),
    array(
        'Tags',
        'tags.php',
        2
    ),
    array(
        'Local Videos',
        'video_local.php',
        2
    ),
    array(
        'Embedded Videos',
        'videos.php?a=embedded',
        2
    ),

    array(
        'View Channels',
        'channels.php',
        3
    ),
    array(
        'Add Channels',
        'channel_add.php',
        3
    ),
    array(
        'Search Channels',
        'channel_search.php',
        3
    ),
    array(
        'Sort Channels',
        'channel_sort.php',
        3
    ),

    array(
        'All Groups',
        'groups.php',
        4
    ),
    array(
        'Public Groups',
        'groups.php?a=public',
        4
    ),
    array(
        'Private Groups',
        'groups.php?a=private',
        4
    ),
    array(
        'Protected Groups',
        'groups.php?a=protected',
        4
    ),
    array(
        'Search Groups',
        'group_search.php',
        4
    ),
    array(
        'Email Templates',
        'email_templates.php',
        5
    ),
    array(
        'View Polls',
        'poll_list.php',
        6
    ),
    array(
        'Add New Poll',
        'poll_add.php',
        6
    ),

    array(
        'Packages',
        'packages.php',
        7
    ),
    array(
        'Add New Package',
        'package_add.php',
        7
    ),
    array(
        'Extend Subscription',
        'subscription_extend.php',
        7
    ),
    array(
        'Edit Subscription',
        'subscription_edit.php',
        7
    ),
    array(
        'Bad Words',
        'bad_words.php',
        8
    ),
    array(
        'Reserve User Name',
        'reserve_user_name.php',
        8
    ),

    array(
        'List Pages',
        'page.php',
        9
    ),
    array(
        'Add Page',
        'page_add.php',
        9
    ),
    array(
        'Import Video',
        'import_video.php',
        10
    ),
    array(
        'Import Folder',
        'import_folder.php',
        10
    ),
    array(
        'Bulk Import',
        'import_bulk.php',
        10
    ),
/*    array(
        'Auto Import',
        'import_auto.php',
        10
    ),*/
    array(
        'Add FLV/Embed',
        'video_add_flv.php',
        10
    ),
    array(
        'Process Queue',
        'process_queue.php',
        10
    ),
    array(
        'List Server',
        'server_manage.php',
        11
    ),
    array(
        'Add Server',
        'server_add.php',
        11
    ),
    array(
        'Site Map',
        'sitemap.php',
        12
    ),
    array(
        'Update Counters',
        'update_counters.php',
        12
    ),
    array(
        'Regenerate Tags',
        'tags_regenerate.php',
        12
    ),
    array(
        'View PHP Info',
        'phpinfo.php',
        12
    )
);

if ($config['family_filter'] == 1) {
    $menu_items[] = array(
        'Adult Videos',
        'videos.php?a=adult',
        2
    );
}

if ($config['enable_package'] == 'yes') {
	$menu_items[] = array(
        'Payments',
        'payments.php',
        0
	);
}

$smarty->assign('menu_heading', $menu_heading);
$smarty->assign('menu_items', $menu_items);
$smarty->display('admin/header.tpl');
$smarty->display('admin/menu.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
