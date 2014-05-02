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

require '../include/config.php';
require 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata_YouTube');

Admin::auth();

$next = 0;
$previous = 0;

if (isset($_GET['keyword'])) {
    $search_string = $_GET['keyword'];
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
    $channel_id = isset($_GET['channel']) ? (int) $_GET['channel'] : 0;
    $admin_listing_per_page = Config::get('admin_listing_per_page');

    if ($page <= 0) $page = 1;

    $start = ($page - 1) * $admin_listing_per_page;

    $user_info = User::getByName($user_name);

    if ($user_info) {
        $yt = new Zend_Gdata_YouTube();
        $query = $yt->newVideoQuery();
        $query->setQuery($search_string);
        $query->setStartIndex($start);
        $query->setMaxResults($admin_listing_per_page);

        $feed = $yt->getVideoFeed($query);

        foreach ($feed as $entry) {
            $video['video_id'] = $entry->getVideoId();
            $video['thumb_url'] = $entry->mediaGroup->thumbnail[1]->url;
            $video['video_title'] = (string) $entry->mediaGroup->title;
            $video['video_description'] = (string) $entry->mediaGroup->description;
            $video['video_title'] = htmlspecialchars($video['video_title'], ENT_QUOTES, 'UTF-8');
            $video['video_description'] = htmlspecialchars($video['video_description'], ENT_QUOTES, 'UTF-8');
            $video['video_duration'] = sec2hms($entry->mediaGroup->duration->seconds);
            $video['imported'] = BulkImport::checkImported($video['video_id'], 'youtube');
            $videos[] = $video;
        }

        $total = 999;

        if (count($videos) > 1) {
            $smarty->assign('videos', $videos);
            $next = $page + 1;
            $previous = $page - 1;
        }

        $links = Paginate::getLinks2($total, $admin_listing_per_page, '', $page);

        $smarty->assign('user_name', $user_name);
        $smarty->assign('channel_id', $channel_id);
        $smarty->assign('links', $links);
    } else {
        $err = 'User not found - ' . $_GET['user_name'];
    }
}

$smarty->assign('channels', Channel::get());
$smarty->assign('next', $next);
$smarty->assign('err', $err);
$smarty->assign('previous', $previous);
$smarty->display('admin/header.tpl');
$smarty->display('admin/import_bulk.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
