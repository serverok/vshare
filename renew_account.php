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

require 'include/config.php';
require 'include/language/' . LANG . '/lang_renew_account.php';

$_GET['uid'] = (int) $_GET['uid'];

if ($config['enable_package'] == 'yes')
{
    if (isset($_POST['submit']))
    {
        $package_id = isset($_POST['package_id']) ? $_POST['package_id'] : '';
        
        if ( $package_id == '')
        {
            $err = $lang['select_package'];
        }
        else
        {
            $redirect_url = VSHARE_URL . '/package_options.php?package_id=' . (int) $package_id . '&user_id=' . $_GET['uid'];
            redirect($redirect_url);
        }
    }
    
    $sql = "SELECT * FROM `packages` WHERE
           `package_status`='Active' AND
           `package_trial`='no'
            ORDER BY `package_price` DESC";
    $result = mysql_query($sql) or mysql_die($sql);
    $package = mysql_fetch_all($result);
    $smarty->assign('package', $package);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('sub_menu', 'menu_home.tpl');
$smarty->display('header.tpl');
$smarty->display('renew_account.tpl');
$smarty->display('footer.tpl');
db_close();
