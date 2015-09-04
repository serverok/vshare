<?php
/******************************************************************************
 *
 * COMPANY: BuyScripts.in
 * PROJECT: vShare Youtube Clone
 * VERSION: VSHARE_VERSION_NUMBER_HERE
 * LICENSE: http://buyscripts.in/vshare-license
 * WEBSITE: http://buyscripts.in/vshare-youtube-clone
 *
 * This program is a commercial software and any kind of using it must agree
 * to vShare license.
 *
 ******************************************************************************/

require 'admin_config.php';
require '../include/config.php';
require '../include/language/' . LANG . '/admin/upload_watermark.php';

Admin::auth();

if (isset($_POST['submit'])) {

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . DB::quote($_POST['watermark_url']) . "' WHERE
           `soption`='watermark_url'";
    DB::query($sql);

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . DB::quote($_POST['watermark_file_url']) . "' WHERE
           `soption`='watermark_file_url'";
    DB::query($sql);

    $msg = $lang['watermark_uploaded'];

    $smarty->assign('watermark_url', $_POST['watermark_url']);
    $smarty->assign('watermark_file_url', $_POST['watermark_file_url']);
}

$smarty->assign('vshare_rand', $_SERVER['REQUEST_TIME']);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/upload_watermark.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
