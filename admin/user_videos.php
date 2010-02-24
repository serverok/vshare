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
require '../include/language/' . LANG . '/lang_admin_user_videos.php';

check_admin_login();

if (! is_numeric($_GET['uid']))
{
    echo $lang['user_id_invalid'];
    exit(0);
}

$result_per_page = get_config('admin_listing_per_page');

$sql = "SELECT `user_name` FROM `users` WHERE
       `user_id`='" . (int) $_GET['uid'] . "'";
$result = mysql_query($sql) or mysql_die($sql);
$tmp = mysql_fetch_assoc($result);
$smarty->assign('user_name', $tmp['user_name']);

$query = " WHERE `video_user_id`='" . (int) $_GET['uid'] . "'";

if (isset($_GET['sort']))
{
    $query .= " ORDER BY $_GET[sort]";
}
else
{
    $query .= " ORDER BY `video_id` ASC";
}

$sql = "SELECT count(*) AS `total` FROM `videos`
        $query";
$result = mysql_query($sql) or mysql_die($sql);
$tmp = mysql_fetch_array($result);
$total = $tmp['total'];

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

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

$smarty->assign('links', $links['all']);
$smarty->assign('total', $total + 0);
$smarty->assign('page', $page + 0);
$smarty->assign('videos', $videos);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/user_videos.tpl');
$smarty->display('admin/footer.tpl');
db_close();
