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

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$sql = "SELECT * FROM `users` WHERE
       `user_name`='" . mysql_clean($_GET['user_name']) . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) != 1)
{
    $redirect_url = VSHARE_URL . '/index.php';
    redirect($redirect_url);
}

$user_info = mysql_fetch_assoc($result);

$sql = "SELECT count(*) AS `total` FROM `friends` WHERE
       `friend_user_id`='" . (int) $user_info['user_id'] . "' AND
       `friend_status`='Confirmed'";
$result = mysql_query($sql) or mysql_die($sql);
$tmp = mysql_fetch_assoc($result);
$total = $tmp['total'];

$start_from = ($page - 1) * $config['items_per_page'];

$sql = "SELECT * FROM `friends` WHERE
       `friend_user_id`='" . (int) $user_info['user_id'] . "' AND
       `friend_status`='Confirmed'
        ORDER BY `friend_invite_date` DESC
        LIMIT $start_from, $config[items_per_page]";
$result = mysql_query($sql) or mysql_die($sql);
$friends_count = mysql_num_rows($result);
$friends = mysql_fetch_all($result);

$start_num = $start_from + 1;
$end_num = $start_from + $friends_count;

$page_links = paginate($total, $config['items_per_page'], ".", "", $page);

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('page', $page);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('page_links', $page_links);
$smarty->assign('total', $total);
$smarty->assign('user_info', $user_info);
$smarty->assign('friends', $friends);
$smarty->assign('sub_menu', 'menu_user.tpl');
$smarty->display('header.tpl');
$smarty->display('user_friends.tpl');
$smarty->display('footer.tpl');
db_close();
