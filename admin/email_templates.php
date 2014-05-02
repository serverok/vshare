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

if (isset($_GET['sort']) && $_GET['sort'] != '') {
    $query = " ORDER BY $_GET[sort]";
} else {
    $query = " ORDER BY `email_id` ASC";
}

$sql = 'SELECT * FROM `email_templates` ' . $query;
$email_templates_all = DB::fetch($sql);

$smarty->assign('email_templates_all', $email_templates_all);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/email_templates.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
