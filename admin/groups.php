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
require '../include/class.channels.php';

check_admin_login();

$result_per_page = get_config('admin_listing_per_page');

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$_GET['a'] = isset($_GET['a']) ? $_GET['a'] : 'all';

if ($_GET['a'] == '')
{
    $_GET['a'] = 'all';
}

if (isset($_GET['action']) && $_GET['action'] == 'del')
{
    $sql = "DELETE FROM `groups` WHERE
           `group_id`='" . (int) $_GET['gid'] . "'";
    mysql_query($sql) or mysql_die($sql);
    
    $sql = "DELETE FROM `group_videos` WHERE
           `group_video_group_id`='" . (int) $_GET['gid'] . "'";
    mysql_query($sql) or mysql_die($sql);
    
    $sql = "DELETE FROM `group_topics` WHERE
           `group_topic_group_id`='" . (int) $_GET['gid'] . "'";
    mysql_query($sql) or mysql_die($sql);
}

if (($_GET['a'] == 'all') || ($_GET['a'] == 'public') || ($_GET['a'] == 'private') || ($_GET['a'] == 'protected'))
{
    
    if ($_GET['a'] != 'all')
    {
        $query = "WHERE `group_type`='$_GET[a]'";
    }
    else
    {
        $query = '';
    }
    
    $_GET['sort'] = isset($_GET['sort']) ? $_GET['sort'] : '';
    
    if ($_GET['sort'] != '')
    {
        $sort = $_GET['sort'];
    }
    else
    {
        $sort = " `group_id` DESC";
    }
    
    $sql = "SELECT count(*) AS `total` FROM `groups`
            $query";
    $result = mysql_query($sql) or mysql_die($sql);
    $tmp = mysql_fetch_array($result);
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
    
    $sql = "SELECT * FROM `groups`
            $query
            ORDER BY $sort
            LIMIT  $start_from, $result_per_page";
    $result = mysql_query($sql) or mysql_die($sql);
    $groups = mysql_fetch_all($result);
    
    $smarty->assign('sort', $sort);
    $smarty->assign('links', $links['all']);
    $smarty->assign('total', $total);
    $smarty->assign('page', $page);
    $smarty->assign('groups', $groups);

}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/groups.tpl');
$smarty->display('admin/footer.tpl');
db_close();
