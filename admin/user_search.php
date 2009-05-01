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
require '../include/language/' . LANG . '/lang_admin_user_search.php';

check_admin_login();

if (isset($_GET['userid']) || isset($_GET['user_name']))
{
    
    if ($_GET['userid'] != null)
    {
        if (is_numeric($_GET['userid']))
        {
            $sql = "SELECT * FROM `users` WHERE
                   `user_id`='" . (int) $_GET['userid'] . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            
            if (mysql_num_rows($result) == 0)
            {
                $err = str_replace('[USER_ID]', $_GET['userid'], $lang['userid_not_found']);
            }
            else
            {
                $redirect_url = VSHARE_URL . '/admin/user_view.php?user_id=' . $_GET['userid'];
                redirect($redirect_url);
            }
        }
        else
        {
            $err = $lang['userid_invalid'];
        }
    }
    else if ($_GET['user_name'] != null)
    {
        $sql = "SELECT `user_id` FROM `users` WHERE
               `user_name`='" . mysql_clean($_GET['user_name']) . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result) == 0)
        {
            $err = str_replace('[USERNAME]', $_GET['user_name'], $lang['user_name_not_found']);
        }
        else
        {
            $user = mysql_fetch_assoc($result);
            $redirect_url = VSHARE_URL . '/admin/user_view.php?user_id=' . $user['user_id'];
            redirect($redirect_url);
        }
    }
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/user_search.tpl');
$smarty->display('admin/footer.tpl');
db_close();