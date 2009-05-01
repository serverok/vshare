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
require 'include/language/' . LANG . '/lang_group_members.php';

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$sql = "SELECT * FROM `groups` WHERE
       `group_url`='" . mysql_clean($_GET['group_url']) . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) < 1)
{
    redirect(VSHARE_URL);
}

$group_info = mysql_fetch_assoc($result);

$smarty->assign('group_info', $group_info);

if (isset($_SESSION['UID']) && $_SESSION['UID'] == $group_info['group_owner_id'])
{
    if (isset($_POST['approve_mem']))
    {
        $sql = "UPDATE `group_members` SET
               `group_member_approved`='yes' WHERE
               `AID`=" . (int) $_POST['AID'] . " AND
               `group_member_group_id`='" . (int) $group_info['group_id'] . "'";
        mysql_query($sql) or mysql_die();
        $msg = str_replace('[GROUP_NAME]', $group_info['group_name'], $lang['user_approved']);
        set_message($msg, 'success');
        $redirect_url = VSHARE_URL . '/group/' . $_GET['group_url'] . '/members/' . $page;
        redirect($redirect_url);
    }
    
    if (isset($_POST['remove_mem']))
    {
        $sql = "DELETE FROM `group_members` WHERE
               `group_member_user_id`='" . (int) $_POST['member_id'] . "' AND
               `group_member_group_id`='" . (int) $group_info['group_id'] . "'";
        mysql_query($sql) or mysql_die($sql);
        $msg = str_replace('[GROUP_NAME]', $group_info['group_name'], $lang['user_removed']);
        set_message($msg, 'success');
        $redirect_url = VSHARE_URL . '/group/' . $_GET['group_url'] . '/members/' . $page;
        redirect($redirect_url);
    }
}

if (isset($_SESSION['UID']) && ($_SESSION['UID'] != $group_info['group_owner_id']))
{
    $query = "AND `group_member_approved`='yes'";
}
else
{
    $query = '';
}

$sql = "SELECT count(*) AS `total` FROM `group_members` WHERE
       `group_member_group_id`='" . (int) $group_info['group_id'] . "'
        $query";
$result = mysql_query($sql) or mysql_die($sql);
$tmp = mysql_fetch_assoc($result);
$total = $tmp['total'];

$start_from = ($page - 1) * $config['items_per_page'];

$sql = "SELECT * FROM `group_members` WHERE
       `group_member_group_id`='" . (int) $group_info['group_id'] . "'
        $query
        ORDER BY `group_member_since` DESC
        LIMIT $start_from, $config[items_per_page]";
$result = mysql_query($sql) or mysql_die($sql);
$group_members = mysql_fetch_all($result);

$start_num = $start_from + 1;
$end_num = $start_from + mysql_num_rows($result);
$page_links = paginate($total, $config['items_per_page'], '.', '', $page);

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('page', $page);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('page_link', $page_links);
$smarty->assign('total', $total);
$smarty->assign('group_members', $group_members);
$smarty->assign('sub_menu', 'menu_group_members.tpl');
$smarty->display('header.tpl');
$smarty->display('group_members.tpl');
$smarty->display('footer.tpl');
db_close();
