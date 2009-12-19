<?php
/******************************************************************************
 *
 *   COMPANY: BuyScripts.in
 *   PROJECT: vShare Youtube Clone
 *   VERSION: 2.8
 *   LISENSE: http://buyscripts.in/vshare-license.html
 *   WEBSITE: http://buyscripts.in/youtube_clone.html
 *
 *   This program is a commercial software and any kind of using it must agree 
 *   to vShare license.
 *
 ******************************************************************************/

require 'include/config.php';
require 'include/language/' . LANG . '/lang_user_groups.php';

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$sql = "SELECT * FROM `users` WHERE
       `user_name`='" . mysql_clean($_GET['user_name']) . "'";
$result = mysql_query($sql) or mysql_die($sql);
$num_result = mysql_num_rows($result);

if ($num_result != 1)
{
    set_message($lang['user_not_found'], 'error');
    $redirect_url = VSHARE_URL . '/index.php';
    redirect($redirect_url);
}

$user_info = mysql_fetch_assoc($result);

$sql = "SELECT count(gm.group_member_group_id) AS `total` FROM
       `groups` AS g,
       `group_members` AS gm WHERE
        gm.group_member_group_id=g.group_id AND
        gm.group_member_user_id='" . (int) $user_info['user_id'] . "'";
$result = mysql_query($sql) or mysql_die($sql);
$tmp = mysql_fetch_array($result);
$total = $tmp['total'];

$start_from = ($page - 1) * $config['items_per_page'];

$sql = "SELECT g.*, gm.group_member_group_id FROM
       `groups` AS g,`group_members` AS gm WHERE
        gm.group_member_group_id=g.group_id AND
        gm.group_member_user_id='" . (int) $user_info['user_id'] . "'
        ORDER BY g.group_create_time DESC
        LIMIT $start_from, $config[items_per_page]";
$result = mysql_query($sql) or mysql_die($sql);
$num_result = mysql_num_rows($result);

$user_group_keywords_all = '';

$groups = array();

while ($group_row = mysql_fetch_assoc($result))
{
    $groups[] = $group_row;
    $user_group_keywords_all .= $group_row['group_keyword'] . ' ';
}

$user_group_keywords_array = split(' ', $user_group_keywords_all);

$view = array();
$view['user_group_keywords_array'] = array_remove_duplicate($user_group_keywords_array);
$smarty->assign('view', $view);

$start_num = $start_from + 1;
$end_num = $start_from + $num_result;
$page_links = paginate($total, $config['items_per_page'], '.', '', $page);

$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('page_links', $page_links);
$smarty->assign('total', $total);
$smarty->assign('groups', $groups);
$smarty->assign('user_info', $user_info);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('page', $page);
$smarty->assign('sub_menu', 'menu_user.tpl');
$smarty->display('header.tpl');
$smarty->display('user_groups.tpl');
$smarty->display('footer.tpl');
db_close();
