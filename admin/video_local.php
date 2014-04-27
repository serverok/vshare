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

$admin_listing_per_page = get_config('admin_listing_per_page');
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$allowed_sort = array(
    "video_id asc",
    "video_id desc",
    "video_title asc",
    "video_title desc",
    "video_type asc",
    "video_type desc",
    "video_duration asc",
    "video_duration desc",
    "video_add_date asc",
    "video_add_date desc"
);

$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

if (in_array($sort, $allowed_sort)) {
    $query = ' ORDER BY ' . $sort;
} else {
    $query = " ORDER BY `video_id` DESC";
}

$sql = "SELECT * FROM `servers` WHERE
        `server_type`!=1 AND
        `status`=1
        ORDER BY `space_used` ASC
        LIMIT 1";
$servers = DB::fetch($sql);

$sql = "SELECT count(`video_id`) AS `total` FROM `videos` WHERE
       `video_vtype`='0' AND
       `video_server_id`='0'";
$total = DB::getTotal($sql);

$start = ($page - 1) * $admin_listing_per_page;

require 'Pager/Pager.php';
require 'Pager/Sliding.php';

$params = array();
$params['mode'] = 'Sliding';
$params['perPage'] = $admin_listing_per_page;
$params['linkClass'] = 'pager';
$params['delta'] = 2;
$params['totalItems'] = $total;
$params['urlVar'] = 'page';

$pager = new Pager_Sliding($params);
$data = $pager->getPageData();
$links = $pager->getLinks();

$sql = "SELECT * FROM `videos` WHERE
       `video_vtype`='0' AND
       `video_server_id`='0'
        $query
        LIMIT $start, $admin_listing_per_page";
$videos = DB::fetch($sql);

$smarty->assign(array(
    'links' => $links["all"],
    'total' => $total + 0,
    'page' => $page + 0,
    'videos' => $videos,
    'servers' => $servers
));

$smarty->display('admin/header.tpl');
$smarty->display('admin/video_local.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
