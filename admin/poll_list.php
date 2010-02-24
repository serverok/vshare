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
require '../include/class.poll.php';
require '../include/language/' . LANG . '/lang_admin_poll_list.php';

check_admin_login();

$poll = new Poll();

if (isset($_GET['action']) && $_GET['action'] == 'delete' && is_numeric($_GET['poll_id']))
{
    $poll->poll_id = $_GET['poll_id'];
    $poll->poll_delete();
    $msg = $lang['poll_deleted'];
}

$sql = "SELECT * FROM `poll_question`";
$result = mysql_query($sql) or mysql_die($sql);

while ($tmp = mysql_fetch_assoc($result))
{
    $poll_info[] = $poll->poll_display($tmp['poll_id']);
    $poll_list[] = $tmp;
}

$smarty->assign('pollArray', $poll_list);
$smarty->assign('poll_info', $poll_info);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/poll_list.tpl');
$smarty->display('admin/footer.tpl');
db_close();
