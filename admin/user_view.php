<?php
/******************************************************************************
 *
 *   COMPANY: BuyScripts.in
 *   PROJECT: vShare Youtube Clone
 *   VERSION: 2.8
 *   LISENSE: http://buyscripts.in/vshare-license.html
 *   WEBSITE: http://buyscripts.in/youtube_clone.html
 *
 *   This program is a commercial software and any kind of using it must agree 
 *   to vShare license.
 *
 ******************************************************************************/

require '../include/config.php';
require '../include/language/' . LANG . '/lang_admin_user_search.php';

check_admin_login();

if (isset($_GET['user_id']))
{
    $user_id = (int) $_GET['user_id'];
    
    $sql = "SELECT * FROM `users` WHERE
           `user_id`='" . $user_id . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    
    if (mysql_num_rows($result) == 0)
    {
        $err = str_replace('[USER_ID]', $user_id, $lang['userid_not_found']);
    }
    else
    {
        $user_info = mysql_fetch_assoc($result);
        $smarty->assign('user', $user_info);
    }
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/user_view.tpl');
$smarty->display('admin/footer.tpl');
db_close();
