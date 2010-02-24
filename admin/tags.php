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

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

if (isset($_POST['action']))
{
    if ($_POST['action'] == 'Disable')
    {
        $active = 0;
    }
    else
    {
        $active = 1;
    }
    
    $sql = "UPDATE `tags` SET
           `active`='" . (int) $active . "' WHERE
           `id`='" . (int) $_POST['action_tag'] . "'";
    mysql_query($sql) or mysql_die($sql);
    $msg = 'Tag has been ' . $_POST['action'] . 'd.';
}

$sql = "SELECT count(*) AS `total` FROM `tags` WHERE `active`='1'";
$result = mysql_query($sql) or mysql_die($sql);
$total = mysql_fetch_array($result);
$total = $total['total'];

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

$sql = "SELECT * FROM `tags` WHERE
	   `active`='1'
        LIMIT $start, $result_per_page";
$result = mysql_query($sql) or mysql_die($sql);
$tags = mysql_fetch_all($result);

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('tags', $tags);
$smarty->assign('links', $links["all"]);
$smarty->assign('total', $total + 0);
$smarty->display('admin/header.tpl');
$smarty->display('admin/tags.tpl');
$smarty->display('admin/footer.tpl');
db_close();
