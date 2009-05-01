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
require '../include/language/' . LANG . '/lang_admin_server_manage_edit.php';

check_admin_login();

if (isset($_POST['submit']))
{
    
    $server_id = (int) $_POST['server_id'];
    
    if ($_POST['server_ip'] == '')
    {
        $err = $lang['ip_numeric'];
    }
    else if ($_POST['server_url'] == '')
    {
        $err = $lang['server_url_empty'];
    }
    else if ($_POST['user_name'] == '')
    {
        $err = $lang['user_name_empty'];
    }
    else if ($_POST['password'] == '')
    {
        $err = $lang['password_empty'];
    }
    else if ($_POST['server_type'] == 2)
    {
        $server_secdownload_secret = isset($_POST['server_secdownload_secret']) ? $_POST['server_secdownload_secret'] : '';
        
        if (strlen($server_secdownload_secret) < 10)
        {
            $err = 'You must enter secdownload.secret';
        }
    }
    
    if ($err == '')
    {
        $sql = "UPDATE `servers` SET
               `ip`='" . mysql_clean($_POST['server_ip']) . "',
               `url`='" . mysql_clean($_POST['server_url']) . "',
               `user_name`='" . mysql_clean($_POST['user_name']) . "',
               `password`='" . mysql_clean($_POST['password']) . "',
               `folder`='" . mysql_clean($_POST['folder']) . "',
               `server_type`='" . (int) $_POST['server_type'] . "',
               `server_secdownload_secret`='" . mysql_clean($server_secdownload_secret) . "' WHERE
               `id`='" . (int) $server_id . "'";
        mysql_query($sql) or mysql_die($sql);
        db_close();
        set_message($lang['server_info_updated'], 'success');
        $redirect_url = VSHARE_URL . '/admin/server_manage.php';
        redirect($redirect_url);
    }
    
    db_close();
    set_message($err, 'error');
    $redirect_url = VSHARE_URL . '/admin/server_manage_edit.php?id=' . $server_id;
    redirect($redirect_url);
}

$server_id = isset($_GET['id']) ? $_GET['id'] : 0;

if (! is_numeric($server_id))
{
    $err = $lang['id_numeric'];
}

$sql = "SELECT * FROM `servers` WHERE
       `id`='" . (int) $server_id . "'";

$result = mysql_query($sql) or mysql_die($sql);
$server_info = mysql_fetch_assoc($result);
$smarty->assign('server_info', $server_info);

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/server_manage_edit.tpl');
$smarty->display('admin/footer.tpl');
db_close();
