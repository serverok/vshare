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

check_admin_login();

$result_per_page = Config::get('admin_listing_per_page');

if (isset($_GET['sort']) && ! empty($_GET['sort'])) {
    $query = "WHERE `video_approve`=0 ORDER BY $_GET[sort]";
} else {
    $query = "WHERE `video_approve`=0 ORDER BY `video_id` DESC";
}

if (isset($_GET['action']) && $_GET["action"] == 'approve') {
    $sql = "UPDATE `videos` SET
           `video_approve`='1',
           `video_active`='1' WHERE
           `video_id`='" . (int) $_GET['video_id'] . "'";
    DB::query($sql);

    $msg = 'Video [VID: <a href="' . VSHARE_URL . '/show.php?id=' . $_GET['video_id'] . '" target=_blank>' . $_GET['video_id'] . '</a>] Approved';

    $tmp = Video::getById($_GET['video_id']);
    $type = $tmp['video_type'];
    $keyword = $tmp['video_keywords'];
    $channel = $tmp['video_channels'];
    $keyword = DB::quote($keyword);

    if ($type == 'public') {
        require VSHARE_DIR . '/include/class.tags.php';
        $tags = new Tags($keyword, $_GET['video_id'], 'user_id_not_used', $channel);
        $tags->add();
        $video_tags = $tags->get_tags();
        $sql = "UPDATE `videos` SET
               `video_keywords`='" . DB::quote(implode(' ', $video_tags)) . "' WHERE
               `video_id`='" . (int) $_GET['video_id'] . "'";
        DB::query($sql);
    }

    User::updateVideoCount($tmp['video_user_id'], 1);
}

if (isset($_GET['action']) && $_GET['action'] == 'approve_all') {
    $sql = "SELECT `video_user_id` FROM `videos` WHERE
           `video_approve`='0'";
    $approved_video_users = DB::fetch($sql);

    foreach ($approved_video_users as $video_user) {
        User::updateVideoCount($video_user['video_user_id'], 1);
    }

    $sql = "UPDATE `videos` SET `video_approve`='1'";
    DB::query($sql);
    $msg = 'All Videos Approved';
}

$sql = "SELECT count(*) AS `total` FROM `videos` WHERE
       `video_approve`='0'";
$total = DB::getTotal($sql);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$start_from = ($page - 1) * $result_per_page;

require 'Pager/Pager.php';
require 'Pager/Sliding.php';

$params = array(
    'mode' => 'Sliding',
    'perPage' => $result_per_page,
    'linkClass' => 'pager',
    'delta' => 2,
    'totalItems' => $total,
    'urlVar' => 'page'
);

$pager = new Pager_Sliding($params);
$data = $pager->getPageData();
$links = $pager->getLinks();

$sql = "SELECT * FROM `videos`
       $query
       LIMIT $start_from, $result_per_page";
$videos = DB::fetch($sql);

$smarty->assign('links', $links['all']);
$smarty->assign('total', $total);
$smarty->assign('page', $page);
$smarty->assign('videos', $videos);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/video_approve.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
