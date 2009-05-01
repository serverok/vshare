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
require 'include/language/' . LANG . '/lang_activate.php';

if (isset($_GET['k']) && isset($_GET['u']) && isset($_GET['i']))
{
    if (! is_numeric($_GET['u']))
    {
        $err = $lang['invalid_vcode'];
    }
    else if (! is_numeric($_GET['i']))
    {
        $err = $lang['invalid_vcode'];
    }
    else if (strlen($_GET['k']) > 40)
    {
        $err = $lang['invalid_vcode'];
    }
    else
    {
        $data1 = 'SIGNUP' . $_GET['u'];
        $sql = "SELECT * FROM `verify_code` WHERE
               `id`=" . (int) $_GET['i'] . " AND
               `vkey`='" . mysql_clean($_GET['k']) . "' AND
               `data1`='" . mysql_clean($data1) . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result) > 0)
        {
            $sql = "UPDATE `users` SET
                   `user_email_verified`='yes',
                   `user_account_status`='active' WHERE
                   `user_id`='" . (int) $_GET['u'] . "'";
            mysql_query($sql) or mysql_die($sql);
            
            $sql = "DELETE FROM `verify_code` WHERE
                   `id`='" . (int) $_GET['i'] . "'";
            mysql_query($sql) or mysql_die($sql);
            
            $sql = "SELECT * FROM `users` WHERE
                   `user_id`='" . (int) $_GET['u'] . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            $tmp = mysql_fetch_assoc($result);
            
            User::login($tmp['user_name']);
            $redirect_url = VSHARE_URL . '/friends/invite/?welcome=1';
            redirect($redirect_url);
        
        }
        else
        {
            $err = $lang['invalid_vcode'];
        }
    }

}
else
{
    $err = $lang['invalid_vcode'];
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('footer.tpl');
db_close();
