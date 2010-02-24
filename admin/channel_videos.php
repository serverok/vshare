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
require '../include/language/' . LANG . '/lang_admin_channel_videos.php';

check_admin_login();

$result_per_page = get_config('admin_listing_per_page');

$sql = "SELECT `channel_name` FROM `channels` WHERE
       `channel_id`='" . (int) $_GET['chid'] . "'";
$result = mysql_query($sql) or mysql_die($sql);
$channel = mysql_fetch_assoc($result);
$smarty->assign('channel_name', $channel['channel_name']);

if (isset($_GET['action']) && $_GET['action'] == 'del')
{
    $sql = "SELECT `video_channels` FROM `videos` WHERE
           `video_id`='" . (int) $_GET['video_id'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $tmp = mysql_fetch_assoc($result);
    $ch = explode('|', $tmp['video_channels']);
    
    if (count($ch) <= 3)
    {
        $err = $lang['channel_only_one'];
    }
    else
    {
        $new_type = str_replace("|$_GET[chid]|", '|', $tmp['video_channels']);
        $sql = "UPDATE `videos` SET
               `video_channels`='$new_type' WHERE
               `video_id`='" . (int) $_GET['video_id'] . "'";
        mysql_query($sql) or mysql_die($sql);
    }
}

$query = " WHERE `video_channels` LIKE '%|$_GET[chid]|%'";

if (isset($_GET['sort']))
{
    $query .= " ORDER BY $_GET[sort]";
}
else
{
    $query .= " ORDER BY `video_id` ASC";
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$sql = "SELECT count(*) AS `total` FROM `videos` $query";
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

$pager = new Pager_Sliding($params);
$data = $pager->getPageData();
$links = $pager->getLinks();

$sql = "SELECT * FROM `videos`
       $query
       LIMIT $start_from, $result_per_page";
$result = mysql_query($sql) or mysql_die($sql);
$videos = mysql_fetch_all($result);

$smarty->assign('links', $links["all"]);
$smarty->assign('grandtotal', $total);
$smarty->assign('total', $total);
$smarty->assign('page', $page);
$smarty->assign('videos', $videos);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/channel_videos.tpl');
$smarty->display('admin/footer.tpl');
db_close();
