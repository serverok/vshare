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
require '../include/language/' . LANG . '/lang_admin_video_feature_requests.php';

check_admin_login();

$result_per_page = get_config('admin_listing_per_page');

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$sort_allowed = array(
    'feature_request_video_id asc',
    'feature_request_video_id desc',
    'feature_request_count asc',
    'feature_request_count desc',
    'feature_request_date asc',
    'feature_request_date desc'
);

if ((isset($_GET['sort'])) && (in_array($_GET['sort'], $sort_allowed)))
{
    $sort = ' ORDER BY fr.' . $_GET['sort'];
}
else
{
    $sort = ' ORDER BY fr.feature_request_video_id DESC';
}

if ((isset($_GET['action'])) && ($_GET['action'] == 'del'))
{
    if (is_numeric($_GET['vid']))
    {
        $sql = "DELETE FROM `feature_requests` WHERE
               `feature_request_video_id`='" . (int) $_GET['vid'] . "'";
        mysql_query($sql) or mysql_die($sql);
    }
}

if ((isset($_GET['action'])) && ($_GET['action'] == 'delete_all'))
{
    $sql = "DELETE FROM `feature_requests`";
    mysql_query($sql) or mysql_die($sql);
}

if ((isset($_GET['action'])) && ($_GET['action'] == 'approve'))
{
    if (is_numeric($_GET['vid']))
    {
        $sql = "UPDATE `videos` SET
               `video_featured`='yes' WHERE
               `video_id`='" . (int) $_GET['vid'] . "'";
        mysql_query($sql) or mysql_die($sql);
        
        $sql = "DELETE FROM `feature_requests` WHERE
               `feature_request_video_id`='" . (int) $_GET['vid'] . "'";
        mysql_query($sql) or mysql_die($sql);
        
        $msg = $lang['video_featured'];
    }
}

$query = " WHERE fr.feature_request_video_id=v.video_id AND v.video_featured='no'";

$sql = "SELECT count(fr.feature_request_video_id) AS `total` FROM
       `feature_requests` fr,
       `videos` v
        $query";
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

$sql = "SELECT * FROM
       `feature_requests` fr,
       `videos` v
        $query  $sort
        LIMIT $start_from, $result_per_page";
$result = mysql_query($sql) or mysql_die($sql);
$videos = mysql_fetch_all($result);

$smarty->assign('links', $links['all']);
$smarty->assign('total', $total);
$smarty->assign('page', $page + 0);
$smarty->assign('videos', $videos);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/video_feature_requests.tpl');
$smarty->display('admin/footer.tpl');
db_close();
