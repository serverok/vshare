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
require '../include/class.channels.php';

check_admin_login();

$group_id = isset($_GET['group_id']) ? $_GET['group_id'] : 0;

$sql = "SELECT * FROM `groups` WHERE
       `group_id`='" . (int) $group_id . "'";
$result = mysql_query($sql) or mysql_die($sql);
$group_info = mysql_fetch_assoc($result);
$smarty->assign('group', $group_info);

$mych = explode('|', $group_info['group_channels']);
$ch = channels::get_all();

$ch_checkbox = '';

for ($i = 0; $i < count($ch); $i ++)
{
    if (in_array($ch[$i]['channel_id'], $mych))
    {
        $ch_checkbox .= htmlspecialchars($ch[$i]['channel_name'], ENT_QUOTES, 'UTF-8') . '<br />';
    }
}

$smarty->assign('ch_checkbox', $ch_checkbox);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/group_view.tpl');
$smarty->display('admin/footer.tpl');
db_close();