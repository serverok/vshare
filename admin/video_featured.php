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

check_admin_login();

$result_per_page = get_config('admin_listing_per_page');

if ((isset($_GET['todo'])) && ($_GET['todo'] == 'un_feature'))
{
    $sql = "UPDATE `videos` SET
           `video_featured`='no' WHERE
           `video_id`='" . (int) $_GET['video_id'] . "'";
    mysql_query($sql) or mysql_die($sql);
}

if ((isset($_GET['todo'])) && ($_GET['todo'] == 'un_feature_all'))
{
    $sql = "UPDATE `videos` SET
           `video_featured`='no'";
    mysql_query($sql) or mysql_die($sql);
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$sort_allowed = array(
    'video_id asc',
    'video_id desc'
);

if ((isset($_GET['sort'])) && (in_array($_GET['sort'], $sort_allowed)))
{
    $sort = $_GET['sort'];
}
else
{
    $sort = "`video_id` DESC";
}

$sql = "SELECT count(*) AS `total` FROM `videos` WHERE
       `video_type`='public' AND
       `video_active`='1' AND
       `video_approve`=1 AND
       `video_featured`='yes'
        ORDER BY $sort";
$result = mysql_query($sql) or mysql_die($sql);
$tmp = mysql_fetch_array($result);
$total = $tmp['total'];

$start = ($page - 1) * $result_per_page;

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

$sql = "SELECT * FROM `videos` WHERE
       `video_type`='public' AND
       `video_active`=1 AND
       `video_approve`=1 AND
       `video_featured`='yes'
        ORDER BY $sort
        LIMIT $start, $result_per_page";
$result = mysql_query($sql) or mysql_die($sql);
$num_featured = mysql_num_rows($result);
$featured_videos = mysql_fetch_all($result);

$smarty->assign('links', $links['all']);
$smarty->assign('answers', $featured_videos);
$smarty->assign('total', $total);
$smarty->display('admin/header.tpl');
$smarty->display('admin/video_featured.tpl');
$smarty->display('admin/footer.tpl');
db_close();
