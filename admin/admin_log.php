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

$admin_listing_per_page = get_config('admin_listing_per_page');
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$allow_sort = array(
    'admin_log_ip asc',
    'admin_log_ip desc',
    'admin_log_time asc',
    'admin_log_time desc'
);

$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

if (! in_array($sort, $allow_sort))
{
    $query = " ORDER BY `admin_log_id` DESC";
}
else
{
    $query = " ORDER BY " . mysql_clean($sort);
}

$sql = "SELECT count(*) AS `total` FROM
	   `admin_log` $query";
$result = mysql_query($sql) or mysql_die($sql);
$tmp = mysql_fetch_assoc($result);
$total = $tmp['total'];

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

$sql = "SELECT * FROM `admin_log`
		$query
		LIMIT $start, $admin_listing_per_page";
$result = mysql_query($sql) or mysql_die($sql);
$admin_log_info = mysql_fetch_all($result);

$smarty->assign('admin_log_info', $admin_log_info);
$smarty->assign('links', $links["all"]);
$smarty->assign('page', $page + 0);
$smarty->assign('sort', $sort);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/admin_log.tpl');
$smarty->display('admin/footer.tpl');
db_close();
