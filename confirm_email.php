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
require 'include/language/' . LANG . '/lang_confirm_email.php';

if (isset($_GET['k']) && isset($_GET['u']) && isset($_GET['i']))
{
    if (! is_numeric($_GET['u']))
    {
        $err = $lang['invalid_vcode'];
    }
    else
    {
        if (! is_numeric($_GET['i']))
        {
            $err = $lang['invalid_vcode'];
        }
        else
        {
            if (strlen($_GET['k']) > 40)
            {
                $err = $lang['invalid_vcode'];
            }
            else
            {
                $data1 = 'EMAIL_CHANGE' . $_GET['u'];
                $sql = "SELECT * FROM `verify_code` WHERE
                       `id`='" . (int) $_GET['i'] . "' AND
                       `vkey`='" . mysql_clean($_GET['k']) . "' AND
                       `data1`='" . mysql_clean($data1) . "'";
                $result = mysql_query($sql) or mysql_die($sql);
                
                if (mysql_num_rows($result) > 0)
                {
                    $tmp = mysql_fetch_assoc($result);
                    $sql = "UPDATE `users` SET
                           `user_email`='" . mysql_clean($tmp['data2']) . "' WHERE
                           `user_id`='" . (int) $_GET['u'] . "'";
                    mysql_query($sql) or mysql_die($sql);
                    $msg = str_replace('[NEW_EMAIL]', $tmp['data2'], $lang['email_changed']);
                    $sql = "DELETE FROM `verify_code` WHERE
                           `id`='" . (int) $_GET['i'] . "'";
                    mysql_query($sql) or mysql_die($sql);
                    set_message($msg, 'success');
                    $redirect_url = VSHARE_URL . '/index.php';
                    redirect($redirect_url);
                }
                else
                {
                    $err = $lang['invalid_vcode'];
                }
            }
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
