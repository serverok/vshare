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
require '../include/language/' . LANG . '/lang_admin_reset_password.php';

if (isset($_GET['k']) && isset($_GET['i']))
{
    if (! is_numeric($_GET['i']))
    {
        $err = $lang['invalid_key'];
    }
    else if (strlen($_GET['k']) > 40)
    {
        $err = $lang['invalid_key'];
    }
    else
    {
        
        $data1 = 'ADMIN_PWD_CHANGE';
        
        $sql = "SELECT * FROM `verify_code` WHERE
               `id`='" . (int) $_GET['i'] . "' AND
               `vkey`='" . $_GET['k'] . "' AND
               `data1`='" . $data1 . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result) > 0)
        {
            $tmp = mysql_fetch_assoc($result);
            $sql = "UPDATE `sconfig` SET
                   `svalue`='" . md5($tmp['data2']) . "' WHERE
                   `soption`='admin_pass'";
            mysql_query($sql) or mysql_die($sql);
            
            $sql = "DELETE FROM `verify_code` WHERE
                   `id`='" . (int) $_GET['i'] . "'";
            mysql_query($sql) or mysql_die($sql);
            set_message($lang['password_changed'], 'success');
            $redirect_url = VSHARE_URL . '/admin/index.php';
            redirect($redirect_url);
        }
        else
        {
            $err = $lang['invalid_key'];
        }
    }
}
else
{
    $err = $lang['invalid_key'];
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('error.tpl');
$smarty->display('footer.tpl');
db_close();
