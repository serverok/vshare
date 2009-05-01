<?php
/******************************************************************************
 *
 *   COMPANY: BuyScripts.in
 *   PROJECT: vShare Youtube Clone
 *   VERSION: 2.7
 *   LISENSE: http://buyscripts.in/vshare-license.html
 *   WEBSITE: http://buyscripts.in/youtube_clone.html
 *
 *   This program is a commercial software and any kind of using it must agree 
 *   to vShare license.
 *
 ******************************************************************************/

require '../include/config.php';

check_admin_login();

$admin_listing_per_page = get_config('admin_listing_per_page');

if (! isset($_GET['a']) || $_GET['a'] == '')
{
    $_GET['a'] = 'All';
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

if ($_GET['a'] != 'All')
{
    $query = "WHERE `user_account_status`='" . mysql_clean($_GET['a']) . "'";
}
else
{
    $query = '';
}

if (! empty($_GET['sort']))
{
    $query .= " ORDER BY " . mysql_clean($_GET['sort']);
}
else
{
    $query .= " ORDER BY `user_id` DESC";
}

$sql = "SELECT count(*) AS `total` FROM `users`
        $query";
$result = mysql_query($sql) or mysql_die($sql);
$tmp = mysql_fetch_array($result);
$total = $tmp['total'];

$start_from = ($page - 1) * $admin_listing_per_page;

require 'Pager/Pager.php';
require 'Pager/Sliding.php';

$params = array();
$params['mode'] = 'Sliding';
$params['perPage'] = $admin_listing_per_page;
$params['linkClass'] = 'pager';
$params['delta'] = 2;
$params['totalItems'] = $total;
$params['urlVar'] = 'page';

$pager = & new Pager_Sliding($params);
$data = $pager->getPageData();
$links = $pager->getLinks();

$sql = "SELECT * FROM `users`
        $query
        LIMIT $start_from, $admin_listing_per_page";
$result = mysql_query($sql) or mysql_die($sql);
$users = mysql_fetch_all($result);

$smarty->assign('links', $links['all']);
$smarty->assign('total', $total + 0);
$smarty->assign('page', $page + 0);
$smarty->assign('users', $users);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/users.tpl');
$smarty->display('admin/footer.tpl');
db_close();
