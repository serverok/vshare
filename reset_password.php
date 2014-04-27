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

require 'include/config.php';
require 'include/language/' . LANG . '/lang_reset_password.php';

if (isset($_GET['k']) && isset($_GET['u']) && isset($_GET['i']))
{
    if (! is_numeric($_GET['i']))
    {
        $err = $lang['vcode_invalid'];
    }
    else if (! is_numeric($_GET['u']))
    {
        $err = $lang['vcode_invalid'];
    }
    
    if ($err == '')
    {
        $data1 = 'PWD_RESET' . $_GET['u'];
        
        $sql = "SELECT * FROM `verify_code` WHERE
               `id`='" . (int) $_GET['i'] . "' AND
               `vkey`='" . DB::quote($_GET['k']) . "' AND
               `data1`='" . DB::quote($data1) . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result) > 0)
        {
            $verify_code_info = mysql_fetch_assoc($result);
            $password = $verify_code_info['data2'];
            
            $sql = "UPDATE `users` SET
                   `user_password`='" . md5($password) . "' WHERE
                   `user_id`='" . (int) $_GET['u'] . "'";
            mysql_query($sql) or mysql_die($sql);
            
            $sql = "DELETE FROM `verify_code` WHERE
                   `id`='" . (int) $_GET['i'] . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            set_message($lang['password_changed'], 'success');
            $redirect_url = VSHARE_URL . '/login/';
            redirect($redirect_url);
        }
        else
        {
            $err = $lang['vcode_invalid'];
        }
    }
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('footer.tpl');
db_close();
