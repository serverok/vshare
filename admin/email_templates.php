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

Admin::auth();

$result_per_page = Config::get('admin_listing_per_page');

if (isset($_GET['sort']) && $_GET['sort'] != '') {
    $query = " ORDER BY $_GET[sort]";
} else {
    $query = " ORDER BY `email_id` ASC";
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$sql = "SELECT count(*) AS `total` FROM `email_templates`
       $query";
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

$pager = new Pager_Sliding($params);
$data = $pager->getPageData();
$links = $pager->getLinks();

$sql = "SELECT * FROM `email_templates`
        $query
        LIMIT $start_from, $result_per_page";
$emails = DB::fetch($sql);

$smarty->assign('links', $links['all']);
$smarty->assign('total', $total);
$smarty->assign('page', $page);
$smarty->assign('emails', $emails);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/email_templates.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
