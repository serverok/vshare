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
require 'include/class.group.php';
require 'include/language/' . LANG . '/lang_group_join.php';

User::is_logged_in();

$group_id = isset($_GET['group_id']) ? $_GET['group_id'] : 0;

$uer_info = User::get_user_by_id($_SESSION['UID']);

if ($uer_info == 0)
{
    set_message($lang['group_security_error'], 'error');
    $redirect_url = VSHARE_URL . '/index.php';
    Http::redirect($redirect_url);
}

$group_info = Groups::get_group_by_id($group_id);

if ($group_info == 0)
{
    set_message($lang['group_security_error'], 'error');
    $redirect_url = VSHARE_URL . '/index.php';
    Http::redirect($redirect_url);
}

$_GET['action'] = isset($_GET['action']) ? $_GET['action'] : '';

if ($_GET['action'] == 'join')
{
    if ($group_info['group_type'] == 'protected')
    {
        $approved = 'no';
    }
    else
    {
        $approved = 'yes';
    }
    
    $sql = "SELECT * FROM `group_members` WHERE
           `group_member_group_id`='" . (int) $group_info['group_id'] . "' AND
           `group_member_user_id`='" . (int) $_SESSION['UID'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    
    if (mysql_num_rows($result) > 0)
    {
        $group_member_info = mysql_fetch_assoc($result);
        
        if ($group_info['group_type'] == 'protected' && $group_member_info['group_member_approved'] == 'no')
        {
            $msg = $lang['group_membership_requested'];
        }
        else
        {
            $msg = $lang['group_join_ok'];
        }
    }
    else
    {
        $sql = "INSERT INTO `group_members` SET
               `group_member_group_id`='" . (int) $group_info['group_id'] . "',
               `group_member_user_id`='" . (int) $_SESSION['UID'] . "',
               `group_member_since`='" . date("Y-m-d H:i:s") . "',
               `group_member_approved`='" . DB::quote($approved) . "'";
        mysql_query($sql) or mysql_die($sql);
        
        if ($group_info['group_type'] == 'protected')
        {
            $msg = $lang['group_membership_requested'];
        }
        else
        {
            $msg = $lang['group_join_ok'];
        }
    }
}

if ($_GET['action'] == 'remove')
{
    $sql = "DELETE FROM `group_members` WHERE
           `group_member_group_id`='" . (int) $group_info['group_id'] . "' AND
           `group_member_user_id`='" . (int) $_SESSION['UID'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $msg = $lang['group_membership_revoked'];
}

db_close();
set_message($msg, 'success');
$redirect_url = VSHARE_URL . '/group/' . $group_info['group_url'] . '/';
Http::redirect($redirect_url);
