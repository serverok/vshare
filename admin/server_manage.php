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

$sql = "SELECT * FROM `servers`
        ORDER BY `id` ASC";
$result = mysql_query($sql) or mysql_die($sql);
$server = mysql_fetch_all($result);

$smarty->assign('msg', $msg);
$smarty->assign('err', $err);
$smarty->assign('server_info', $server);
$smarty->display('admin/header.tpl');
$smarty->display('admin/server_manage.tpl');
$smarty->display('admin/footer.tpl');
db_close();
