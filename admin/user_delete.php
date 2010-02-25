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

$_GET['a'] = isset($_GET['a']) ? $_GET['a'] : 'All';

if ($_GET['a'] == '')
{
    $_GET['a'] = 'All';
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

$redirect_url = VSHARE_URL . '/admin/users.php?a=' . $_GET['a'] . '&sort=' . $sort . '&page=' . $page;
redirect($redirect_url);
