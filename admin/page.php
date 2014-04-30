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
require '../include/language/' . LANG . '/lang_admin_page.php';

Admin::auth();

$result_per_page = Config::get('admin_listing_per_page');

if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $msg = 'Page updated (' . VSHARE_URL . '/pages/' . $name . '.html)';
}

if (isset($_GET['action']) && $_GET['action'] == 'del' && is_numeric($_GET['id'])) {
    $sql = "DELETE FROM `pages` WHERE
           `page_id`='" . (int) $_GET['id'] . "'";
    DB::query($sql);
    $msg = $lang['page_deleted'];
}

$sql = "SELECT * FROM `pages`";
$pages = DB::fetch($sql);

if (! $pages) {
    $msg = $lang['page_not_found'];
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('pages', $pages);
$smarty->assign('total', count($pages));
$smarty->display('admin/header.tpl');
$smarty->display('admin/page.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
