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
require '../include/language/' . LANG . '/lang_admin_video_inactive.php';

check_admin_login();

$todo = isset($_GET['todo']) ? $_GET['todo'] : '';
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

if ($todo == 'activate')
{
    if (is_numeric($_GET['video_id']))
    {
        $sql = "UPDATE `videos` SET
               `video_active`='1' WHERE
               `video_id`='" . (int) $_GET['video_id'] . "'";
        mysql_query($sql) or mysql_die();
        $msg = $lang['activate_video'];
    }
}

if ($todo == 'activate_all')
{
    $sql = "UPDATE `videos` SET
           `video_active`='1'";
    mysql_query($sql) or mysql_die();
    $msg = $lang['activate_all_video'];
}

if (isset($_GET['sort']))
{
    $sort = $_GET['sort'];
}
else
{
    $sort = " `video_id` DESC";
}

$sql = "SELECT count(*) AS `total` FROM `videos` WHERE
       `video_active`='0' AND
       `video_user_id`!='0'
        ORDER BY $sort";
$result = mysql_query($sql) or mysql_die();
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
       `video_active`='0' AND
       `video_user_id`!='0'
        ORDER BY $sort
        LIMIT $start, $result_per_page";
$result = mysql_query($sql) or mysql_die();

if (mysql_num_rows($result) > 0)
{
    $inactive_videos = mysql_fetch_all($result);
    $smarty->assign('answers', $inactive_videos);
}

$smarty->assign('msg', $msg);
$smarty->assign('links', $links['all']);
$smarty->assign('total', $total);
$smarty->display('admin/header.tpl');
$smarty->display('admin/video_inactive.tpl');
$smarty->display('admin/footer.tpl');
db_close();
