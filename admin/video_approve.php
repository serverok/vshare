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

check_admin_login();

$result_per_page = get_config('admin_listing_per_page');

if (isset($_GET['sort']) && ! empty($_GET['sort']))
{
    $query = "WHERE `video_approve`=0 ORDER BY $_GET[sort]";
}
else
{
    $query = "WHERE `video_approve`=0 ORDER BY `video_id` DESC";
}

if (isset($_GET['action']) && $_GET["action"] == 'approve')
{
    $sql = "UPDATE `videos` SET
           `video_approve`='1',
           `video_active`='1' WHERE
           `video_id`='" . (int) $_GET['video_id'] . "'";
    mysql_query($sql) or mysql_die($sql);
    
    $msg = 'Video [VID: <a href="' . VSHARE_URL . '/show.php?id=' . $_GET['video_id'] . '" target=_blank>' . $_GET['video_id'] . '</a>] Approved';
    
    $sql = "SELECT * FROM `videos` WHERE
           `video_id`='" . (int) $_GET['video_id'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $tmp = mysql_fetch_assoc($result);
    $type = $tmp['video_type'];
    $keyword = $tmp['video_keywords'];
    $channel = $tmp['video_channels'];
    $keyword = mysql_clean($keyword);
    
    if ($type == 'public')
    {
        require VSHARE_DIR . '/include/class.tags.php';
        $tags = new Tags($keyword, $_GET['video_id'], 'user_id_not_used', $channel);
        $tags->add();
        $video_tags = $tags->get_tags();
        $sql = "UPDATE `videos` SET
               `video_keywords`='" . mysql_clean(implode(' ',$video_tags)) . "' WHERE,
               `video_id`='" . (int) $_GET['video_id'] . "'";
        mysql_query($sql) or mysql_die($sql);
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'approve_all')
{
    $sql = "UPDATE `videos` SET
           `video_approve`='1'";
    mysql_query($sql) or mysql_die($sql);
    $msg = 'All Videos Approved';
}

$sql = "SELECT count(*) AS `total` FROM `videos` WHERE
       `video_approve`='0'";
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

$pager = & new Pager_Sliding($params);
$data = $pager->getPageData();
$links = $pager->getLinks();

$sql = "SELECT * FROM `videos`
       $query
       LIMIT $start_from, $result_per_page";
$result = mysql_query($sql) or mysql_die($sql);
$videos = mysql_fetch_all($result);

$smarty->assign('links', $links['all']);
$smarty->assign('total', $total);
$smarty->assign('page', $page);
$smarty->assign('videos', $videos);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/video_approve.tpl');
$smarty->display('admin/footer.tpl');
db_close();
