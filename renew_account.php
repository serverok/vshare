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

require 'include/config.php';
require 'include/language/' . LANG . '/lang_renew_account.php';

if ($config['enable_package'] == 'yes') {
    if (isset($_POST['submit'])) {
        $package_id = isset($_POST['package_id']) ? $_POST['package_id'] : '';
        if ($package_id == '') {
            $err = $lang['select_package'];
        } else {
            $redirect_url = VSHARE_URL . '/package_options.php?package_id=' . (int) $package_id . '&user_id=' . $_GET['uid'];
            Http::redirect($redirect_url);
        }
    }

    $sql = "SELECT * FROM `packages` WHERE
           `package_status`='Active' AND
           `package_trial`='no'
            ORDER BY `package_price` DESC";
    $package = DB::fetch($sql);
    $smarty->assign('package', $package);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('sub_menu', 'menu_home.tpl');
$smarty->display('header.tpl');
$smarty->display('renew_account.tpl');
$smarty->display('footer.tpl');
DB::close();
