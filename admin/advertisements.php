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

$query = '';

if (isset($_GET['sort'])) {
    $allowedSort = array(
        'adv_id desc',
        'adv_id asc',
        'adv_name asc',
        'adv_name desc'
    );

    if (in_array($_GET['sort'], $allowedSort)) {
        $query .= ' ORDER BY ' . DB::quote($_GET['sort']);
    }
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$sql = "SELECT count(*) AS `total` FROM `adv`";
$total = DB::getTotal($sql);

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

$pager = new pager_sliding($params);
$data = $pager->getpagedata();
$link = $pager->getLinks();

$sql = "SELECT * FROM `adv` $query
       LIMIT $start_from, $result_per_page";
$adv = DB::fetch($sql);

$smarty->assign('links', $link['all']);
$smarty->assign('total', $total + 0);
$smarty->assign('page', $page + 0);
$smarty->assign('adv', $adv);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/advertisements.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
