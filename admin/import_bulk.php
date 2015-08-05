<?php
/******************************************************************************
 *
 * COMPANY: BuyScripts.in
 * PROJECT: vShare Youtube Clone
 * VERSION: VSHARE_VERSION_NUMBER_HERE
 * LICENSE: http://buyscripts.in/vshare-license
 * WEBSITE: http://buyscripts.in/vshare-youtube-clone
 *
 * This program is a commercial software and any kind of using it must agree
 * to vShare license.
 *
 ******************************************************************************/

require 'admin_config.php';
require '../include/config.php';
require 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata_YouTube');

Admin::auth();

if (Config::get('youtube_api_key') == '') {
    $err = 'You must set <strong>Youtube API Key</strong> at Configuration -> Miscellaneous -> Youtube API Key:';
}

if (isset($_GET['keyword'])) {
    $search_string = $_GET['keyword'];
    $page = isset($_GET['page']) ? $_GET['page'] : '';
    $user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
    $channel_id = isset($_GET['channel']) ? (int) $_GET['channel'] : 0;
    $admin_listing_per_page = Config::get('admin_listing_per_page');
    $user_info = User::getByName($user_name);

    if ($user_info) {
        $videos = Youtube::getVideos($search_string, 10, $page);

        if (count($videos['videos']) > 1) {
            $smarty->assign('videos', $videos);
        } else {
            $err = 'There are no videos found with keyword.';
        }

        $smarty->assign('user_name', $user_name);
        $smarty->assign('channel_id', $channel_id);
    } else {
        $err = 'User not found - ' . $_GET['user_name'];
    }
}

$smarty->assign('channels', Channel::get());
$smarty->assign('err', $err);
$smarty->display('admin/header.tpl');
$smarty->display('admin/import_bulk.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
