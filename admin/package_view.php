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

$sql = "SELECT * FROM `packages` WHERE
       `package_id`='" . (int) $_GET['package_id'] . "'";
$result = mysql_query($sql) or mysql_die($sql);
$package_info = mysql_fetch_assoc($result);

$smarty->assign('package', $package_info);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/package_view.tpl');
$smarty->display('admin/footer.tpl');
db_close();
