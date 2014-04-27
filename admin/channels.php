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

$result_per_page = get_config('admin_listing_per_page');

if (isset($_GET['action']) && ($_GET['action'] == 'del')) {
    $sql = "DELETE FROM `channels` WHERE
           `channel_id`='" . (int) $_GET['chid'] . "'";
    DB::query($sql);
}

$allowedSort = array(
    'channel_name asc',
    'channel_id desc',
    'channel_name desc',
    'channel_id desc'
);

$channel_sort = isset($_GET['sort']) ? $_GET['sort'] : '';

if (! in_array($channel_sort, $allowedSort)) {
    $query = " ORDER BY `channel_id` ASC";
} else {
    $query = " ORDER BY " . $channel_sort;
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$sql = "SELECT count(*) AS `total` FROM `channels` $query";
$total = DB::getTotal($sql);

$start_from = ($page - 1) * $result_per_page;

require 'Pager/Pager.php';
require 'Pager/Sliding.php';

$params = array();
$params['mode'] = 'Sliding';
$params['perPage'] = $result_per_page;
$params['linkClass'] = 'pager';
$params['delta'] = 2;
$params['totalItems'] = $total;
$params['urlVar'] = 'page';

$pager = new Pager_Sliding($params);
$data = $pager->getPageData();
$links = $pager->getLinks();

$sql = "SELECT * FROM `channels`
        $query
        LIMIT $start_from, $result_per_page";
$channels_all = DB::fetch($sql);

foreach ($channels_all as $channel) {
    $channel['channel_name'] = htmlspecialchars_uni($channel['channel_name']);
    $channels[] = $channel;
}

$smarty->assign('links', $links['all']);
$smarty->assign('total', $total);
$smarty->assign('page', $page);
$smarty->assign('channels', $channels);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/channels.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
