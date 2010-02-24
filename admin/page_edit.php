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

if (isset($_POST['submit']))
{
    $sql = "UPDATE `pages` SET
           `page_content`='" . mysql_clean($_POST['content']) . "',
           `page_title`='" . mysql_clean($_POST['title']) . "',
           `page_description`='" . mysql_clean($_POST['description']) . "',
           `page_keywords`='" . mysql_clean($_POST['keywords']) . "',
           `page_members_only`='" . mysql_clean($_POST['members_only']) . "' WHERE
           `page_id`='" . (int) $_POST['page_id'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $redirect_url = VSHARE_URL . '/admin/page.php?name=' . $_POST['page_name'];
    redirect($redirect_url);
}

$sql = "SELECT * FROM `pages` WHERE
       `page_id`='" . (int) $_GET['id'] . "'";
$result = mysql_query($sql) or mysql_die($sql);
$page_edit = mysql_fetch_assoc($result);
$page_edit['page_content'] = htmlspecialchars($page_edit['page_content'], ENT_QUOTES, 'UTF-8');

$smarty->assign('page_edit', $page_edit);
$smarty->assign('editor_wysiwyg_admin', get_config('editor_wysiwyg_admin'));
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/page_edit.tpl');
$smarty->display('admin/footer.tpl');
db_close();
