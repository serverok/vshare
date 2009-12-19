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

require '../include/config.php';
require '../include/language/' . LANG . '/lang_admin_process_queue.php';

check_admin_login();

$result_per_page = get_config('admin_listing_per_page');

if (isset($_GET['action']) && $_GET['action'] == 'delete')
{
    $id = $_GET['id'];
    $sql = "SELECT * FROM `process_queue` WHERE
           `id`='" . (int) $id . "'";
    $result = mysql_query($sql) or mysql_die();
    $tmp = mysql_fetch_assoc($result);
    $sql = "DELETE FROM `process_queue` WHERE
           `id`='" . (int) $id . "'";
    mysql_query($sql) or mysql_die();
    
    $video_path = VSHARE_DIR . '/video/' . $tmp['file'];
    
    if (file_exists($video_path) && is_file($video_path))
    {
        $vid = $tmp['vid'];
        if ($vid == 0)
        {
            unlink($video_path);
        }
    }
    $msg = $lang['process_q_deleted'];
}

if ((isset($_GET['action'])) && ($_GET['action'] == 'delete_all'))
{
    $sql = "SELECT * FROM `process_queue`";
    $result = mysql_query($sql) or mysql_die($sql);
    
    while ($tmp = mysql_fetch_assoc($result))
    {
        $video_path = VSHARE_DIR . '/video/' . $tmp['file'];
        
        if (file_exists($video_path) && is_file($video_path))
        {
            $vid = $tmp['vid'];
            
            if ($vid == 0)
            {
                if (! unlink($video_path))
                {
                    echo str_replace('[VIDEO_PATH]', $video_path, $lang['unable_to_delete']);
                    exit(0);
                }
            }
        }
    }
    
    $sql = "DELETE  FROM  `process_queue`";
    $result = mysql_query($sql) or mysql_die($sql);
    $msg = $lang['process_q_deleted'];
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$result_per_page = get_config('admin_listing_per_page');

$sql = "SELECT count(*) AS `total` FROM
       `process_queue` AS p,
       `users` AS u WHERE
        p.user=u.user_name ORDER BY
       `status` ASC";
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

$sql = "SELECT * FROM
       `process_queue` AS p,
       `users` AS u WHERE
        p.user=u.user_name
        ORDER BY `id` DESC
        LIMIT $start, $result_per_page";
$result = mysql_query($sql) or mysql_die($sql);
$process_queue_info = mysql_fetch_all($result);

$smarty->assign('msg', $msg);
$smarty->assign('page', $page);
$smarty->assign('links', $links['all']);
$smarty->assign('process_queue', $process_queue_info);
$smarty->display('admin/header.tpl');
$smarty->display('admin/process_queue.tpl');
$smarty->display('admin/footer.tpl');
db_close();
