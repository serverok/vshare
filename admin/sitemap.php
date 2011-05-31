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
require '../include/class.sitemap.php';

check_admin_login();

$sitemap_action = isset($_GET['action']) ? $_GET['action'] : '';
$sitemap_id = isset($_GET['sitemap_id']) ? $_GET['sitemap_id'] : 0;

$sitemap = new sitemap();

if (isset($_POST['generate_sitemap']))
{
    $msg = $sitemap->generate();
}

if ($sitemap_action == 'update')
{
    $msg =  $sitemap->updateSitemap($sitemap_id);
}
else if ($sitemap_action == 'delete')
{
    $sitemap->deleteSitemap($sitemap_id);
}

$smarty->assign('msg', $msg);
$smarty->assign('sitemap', $sitemap->getSitemapInfo());
$smarty->display('admin/header.tpl');
$smarty->display('admin/sitemap.tpl');
$smarty->display('admin/footer.tpl');
db_close();
