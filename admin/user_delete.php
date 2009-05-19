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
require '../include/language/' . LANG . '/lang_admin_user_delete.php';
require '../include/class.ftp.php';
require '../include/class.video.php';

check_admin_login();

if (! is_numeric($_GET['uid']))
{
    echo $lang['userid_numeric'];
    exit(0);
}

$user_info = User::get_user_by_id($_GET['uid']);

if ($user_info == 0)
{
    set_message('user not found', 'error');
    $redirect_url = VSHARE_URL . '/admin/users.php';
    redirect($redirect_url);
}

User::delete($user_info['user_id'], 1);

$msg = str_replace('[USERNAME]', $user_info['user_name'], $lang['user_deleted']);
set_message($msg, 'success');

db_close();
$redirect_url = VSHARE_URL . '/admin/users.php';
redirect($redirect_url);
