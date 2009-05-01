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
require '../include/language/' . LANG . '/lang_admin_index.php';

if (isset($_SESSION['AUID']) && isset($_SESSION['APASSWORD']))
{
    if (($_SESSION['AUID'] == $config['admin_name']) && ($_SESSION['APASSWORD'] == $config['admin_pass']))
    {
        $redirect_url = VSHARE_URL . '/admin/main.php';
        redirect($redirect_url);
    }
}

if (isset($_POST['submit']))
{
    $user_password = $_POST['password'];
    $user_name = $_POST['user_name'];
    
    if (get_magic_quotes_gpc())
    {
        $user_password = stripslashes($user_password);
        $user_name = stripslashes($user_name);
    }
    
    $user_password_md5 = md5($user_password);
    
    if ($user_name == '' || $user_password == '')
    {
        $err = $lang['login_empty'];
    }
    else if (($user_name == $config['admin_name']) && ($user_password_md5 == $config['admin_pass']))
    {
        $_SESSION['AUID'] = $config['admin_name'];
        $_SESSION['APASSWORD'] = $config['admin_pass'];
        $redirect_url = VSHARE_URL . '/admin/main.php';
        redirect($redirect_url);
    }
    else
    {
        $err = $lang['login_invalid'];
    }
}

$login_error = '';

if ($err != '')
{
    $login_error = $err;
    $err = '';
}
else if ($msg != '')
{
    $login_error = $msg;
    $msg = '';
}

$smarty->assign('login_error', $login_error);
$smarty->display('admin/header.tpl');
$smarty->display('admin/index.tpl');
$smarty->display('admin/footer.tpl');
db_close();
