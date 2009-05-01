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
require 'include/language/' . LANG . '/lang_group_invite_confirm.php';

User::is_logged_in();

$group_url = htmlspecialchars_uni($_GET['group_url']);

$sql = "SELECT * FROM `groups` WHERE
       `group_url`='" . mysql_clean($group_url) . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) == 0)
{
    redirect(VSHARE_URL);
}

if (! isset($_GET['key']))
{
    db_close();
    redirect(VSHARE_URL);
}

$sql = "SELECT * FROM
       `verify_code` AS v,
       `groups` AS g WHERE
        v.vkey='" . mysql_clean($_GET['key']) . "' AND
        v.data1=g.group_id";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) < 1)
{
    db_close();
    set_message($lang['invalid_invite_key'], 'error');
    $redirect_url = VSHARE_URL . '/group/' . $_GET['group_url'] . '/';
    redirect($redirect_url);
}

$tmp = mysql_fetch_assoc($result);
$join_group_id = $tmp['group_id'];

$sql = "SELECT * FROM `group_members` WHERE
       `group_member_group_id`='" . (int) $join_group_id . "' AND
       `group_member_user_id`='" . (int) $_SESSION['UID'] . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) < 1)
{
    $sql = "INSERT INTO `group_members` SET
           `group_member_group_id`='" . (int) $join_group_id . "',
           `group_member_user_id`='" . (int) $_SESSION['UID'] . "',
           `group_member_since`='" . date("Y-m-d H:i:s") . "',
           `group_member_approved`='yes'";
    $result = mysql_query($sql) or mysql_die($sql);
    $msg = $lang['user_added'];
}

$sql = "DELETE FROM `verify_code` WHERE
       `vkey`='" . mysql_clean($_GET['key']) . "'";
mysql_query($sql) or mysql_die($sql);
$smarty->assign('accept_mem', 'true');

db_close();
set_message($msg, 'success');
$redirect_url = VSHARE_URL . '/group/' . $_GET['group_url'] . '/';
redirect($redirect_url);
