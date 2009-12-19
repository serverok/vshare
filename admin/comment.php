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

include '../include/config.php';

check_admin_login();

$result_per_page = get_config('admin_listing_per_page');

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

if (isset($_GET['action']) && $_GET['action'] == 'del')
{
    if (is_numeric($_GET['id']))
    {
        $sql = "DELETE FROM `comments` WHERE
               `comment_id`='" . (int) $_GET['id'] . "'";
        $result = mysql_query($sql) or mysql_die($sql);
    }
}

$sql = "SELECT count(*) AS `total` FROM `comments`";
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

$pager = new Pager_Sliding($params);
$data = $pager->getPageData();
$links = $pager->getLinks();

$sql = "SELECT * FROM
       `comments` AS c,
       `users` AS u WHERE
        c.comment_user_id=u.user_id
        ORDER BY c.comment_id DESC
        LIMIT $start_from, $result_per_page";
$result = mysql_query($sql) or mysql_die($sql);
$comments = mysql_fetch_all($result);

$smarty->assign('links', $links['all']);
$smarty->assign('page', $page);
$smarty->assign('total', $total);
$smarty->assign('comments', $comments);
$smarty->display('admin/header.tpl');
$smarty->display('admin/comment.tpl');
$smarty->display('admin/footer.tpl');
db_close();
