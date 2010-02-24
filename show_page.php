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

require './include/config.php';

$sql = "SELECT * FROM `pages` WHERE
       `page_name`='" . mysql_clean($_GET['name']) . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) != 1)
{
    show_page_not_found();
}

$page_info = mysql_fetch_assoc($result);

if ($page_info['page_members_only'] == 1)
{
    User::is_logged_in();
}

function show_page_not_found()
{
    header("HTTP/1.0 404 Not Found");
    echo "<html><head><title>Page Not Found</title></head><body>Page Not Found</body></html>";
    exit(0);
}

$smarty->assign('err', $err);
$smarty->assign('html_title', $page_info['page_title']);
$smarty->assign('content', $page_info['page_content']);
$smarty->assign('html_description', $page_info['page_description']);
$smarty->assign('html_keywords', $page_info['page_keywords']);
$smarty->display('header.tpl');
$smarty->display('show_page.tpl');
$smarty->display('footer.tpl');
db_close();
