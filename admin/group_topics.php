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

if (! is_numeric($_GET['gid'])) {
    echo 'gid empty';
    exit(0);
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$sql = "SELECT `group_name` FROM `groups` WHERE
       `group_id`=" . (int) $_GET['gid'];
$tmp = DB::fetch1($sql);
$group_name = $tmp['group_name'];

$smarty->assign('group_name', $group_name);

if (isset($_GET['action']) && $_GET['action'] == 'del' && is_numeric($_GET['TID'])) {
    $sql = "DELETE FROM `group_topics` WHERE
           `group_topic_id`='" . (int) $_GET['TID'] . "'";
    DB::query($sql);
}

$query = " WHERE `group_topic_group_id`='" . (int) $_GET['gid'] . "'";

$sort_allowed = array(
    'group_topic_title asc',
    'group_topic_title desc',
    'group_topic_add_time asc',
    'group_topic_add_time desc',
    'group_topic_approved asc',
    'group_topic_approved desc'
);

$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

if (in_array($sort, $sort_allowed)) {
    $query .= " ORDER BY " . DB::quote($sort);
} else {
    $query .= " ORDER BY `group_topic_id` DESC";
}

$sql = "SELECT count(*) AS `total` FROM `group_topics` $query";
$total = DB::getTotal($sql);

$start_from = ($page - 1) * $result_per_page;

require_once 'Pager/Pager.php';
require_once 'Pager/Sliding.php';

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

$sql = "SELECT * FROM `group_topics`
        $query
        LIMIT $start_from, $result_per_page";
$topics = DB::fetch($sql);

$smarty->assign('link', $links["all"]);
$smarty->assign('grandtotal', $total);
$smarty->assign('total', $total + 0);
$smarty->assign('page', $page + 0);
$smarty->assign('grptps', $topics);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/group_topics.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
