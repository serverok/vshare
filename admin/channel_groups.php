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
require '../include/language/' . LANG . '/lang_admin_channel_groups.php';

check_admin_login();

$result_per_page = get_config('admin_listing_per_page');

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$sql = "SELECT `channel_name` FROM `channels` WHERE
       `channel_id`='" . (int) $_GET['chid'] . "'";
$result = mysql_query($sql) or mysql_die($sql);
$tmp = mysql_fetch_assoc($result);
$smarty->assign('channel_name', $tmp['channel_name']);

if (isset($_GET['action']) && $_GET['action'] == 'del')
{
    $sql = "SELECT `group_channels` FROM `groups` WHERE
           `group_id`='" . (int) $_GET['gid'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $channel = mysql_fetch_assoc($result);
    $ch = explode("|", $channel['channel']);
    
    if (count($ch) <= 3)
    {
        $err = $lang['group_channel_last'];
    }
    else
    {
        $new_type = str_replace("|$_GET[chid]|", '|', $channel['channel']);
        $sql = "UPDATE `groups` SET `channel`='$new_type' WHERE
           `group_id`='" . (int) $_GET['gid'] . "'";
        $result = mysql_query($sql) or mysql_die($sql);
    }
}

$query = " WHERE `group_channels` LIKE '%|" . (int) $_GET['chid'] . "|%'";

if (isset($_GET['sort']) && $_GET['sort'] != '')
{
    $query .= " ORDER BY $_GET[sort]";
}
else
{
    $query .= " ORDER BY `group_id` ASC";
}

$sql = "SELECT count(*) AS `total` FROM `groups` $query";
$result = mysql_query($sql) or mysql_die($sql);
$tmp = mysql_fetch_assoc($result);
$total = $tmp['total'];

$start_from = ($page - 1) * $result_per_page;

require 'Pager/Pager.php';
require 'Pager/Sliding.php';

$params = array(
    'mode' => 'Sliding',
    'perPage' => $result_per_page,
    'linkClass' => 'pager',
    'delta' => 2,
    'totalItems' => $total,
    'urlVar' => 'page'
);

$pager = & new Pager_Sliding($params);
$data = $pager->getPageData();
$links = $pager->getLinks();

$sql = "SELECT * FROM `groups` $query
        LIMIT $start_from, $result_per_page";
$result = mysql_query($sql) or mysql_die($sql);
$groups = mysql_fetch_all($result);

$smarty->assign('link', $links["all"]);
$smarty->assign('grandtotal', $total);
$smarty->assign('total', $total);
$smarty->assign('page', $page);
$smarty->assign('groups', $groups);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/channel_groups.tpl');
$smarty->display('admin/footer.tpl');
db_close();
