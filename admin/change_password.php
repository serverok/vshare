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
require '../include/language/' . LANG . '/lang_admin_change_password.php';

check_admin_login();

if (isset($_POST['submit']))
{
    if ($_POST['admin_name'] == '')
    {
        $err = $lang['admin_name_null'];
    }
    else if (md5($_POST['password']) != $_SESSION['APASSWORD'])
    {
        $err = $lang['password_wrong'];
    }
    else if (strlen($_POST['password_new']) < 4)
    {
        $err = $lang['password_short'];
    }
    else if ($_POST['password_new'] != $_POST['password_confirm'])
    {
        $err = $lang['password_confirm_error'];
    }
    
    if ($err == '')
    {
        if ($config['admin_name'] != $_POST['admin_name'])
        {
            $sql = "UPDATE `sconfig` SET
                   `svalue`='" . mysql_clean($_POST['admin_name']) . "' WHERE
                   `soption`='admin_name'";
            mysql_query($sql) or mysql_die($sql);
            $_SESSION['AUID'] = $_POST['admin_name'];
            $smarty->assign('admin_name', $_POST['admin_name']);
        }
        
        $password_new_md5 = md5($_POST['password_new']);
        $sql = "UPDATE `sconfig` SET
               `svalue`='$password_new_md5' WHERE
               `soption`='admin_pass'";
        mysql_query($sql) or mysql_die($sql);
        $_SESSION['APASSWORD'] = $password_new_md5;
        $msg = $lang['password_changed'];
    
    }
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/change_password.tpl');
$smarty->display('admin/footer.tpl');
db_close();
