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

$sql = "SELECT * FROM `servers` ORDER BY `id` ASC";
$servers = DB::fetch($sql);

$smarty->assign('msg', $msg);
$smarty->assign('err', $err);
$smarty->assign('server_info', $servers);
$smarty->display('admin/header.tpl');
$smarty->display('admin/server_manage.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
