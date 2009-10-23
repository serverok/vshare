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
require '../include/language/' . LANG . '/lang_admin_channel_sort.php';

check_admin_login();

$result_per_page = get_config('admin_listing_per_page');

if (isset($_POST['submit']))
{
    
    $id = $_POST['id'];
    $sortorder = $_POST['sortorder'];
    
    for ($i = 0; $i < count($id); $i ++)
    {
        $sql = "UPDATE `channels` SET
               `channel_sort_order`='" . (int) $sortorder[$i] . "'
                WHERE `channel_id`='" . (int) $id[$i] . "'";
        mysql_query($sql) or mysql_die($sql);
    }
    $smarty->assign('msg', $lang['channel_sort_updated']);
}

$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'asc';

if ($sort != 'asc')
{
    $sort = 'desc';
}

$query = "ORDER BY `channel_sort_order` $sort";

$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$sql = "SELECT count(*) AS `total` FROM `channels` $query";
$result = mysql_query($sql) or mysql_die($sql);
$tmp = mysql_fetch_assoc($result);
$total = $tmp['total'];
$start_from = ($page - 1) * $result_per_page;

require 'Pager/Pager.php';
require 'Pager/Sliding.php';

$params = array();
$params['mode'] = 'Sliding';
$params['perPage'] = $result_per_page;
$params['linkClass'] = 'pager';
$params['delta'] = 2;
$params['totalItems'] = $total;
$params['urlVar'] = 'page';

$pager = new Pager_Sliding($params);
$data = $pager->getPageData();
$links = $pager->getLinks();

$sql = "SELECT * FROM `channels`
       $query
       LIMIT $start_from, $result_per_page";
$result = mysql_query($sql) or mysql_die($sql);

$channels = array();

while ($tmp = mysql_fetch_assoc($result))
{
    $tmp['channel_name'] = htmlspecialchars_uni($tmp['channel_name']);
    $channels[] = $tmp;
}

$smarty->assign('link', $links['all']);
$smarty->assign('page', $page);
$smarty->assign('channels', $channels);
$smarty->display('admin/header.tpl');
$smarty->display('admin/channel_sort.tpl');
$smarty->display('admin/footer.tpl');
db_close();
