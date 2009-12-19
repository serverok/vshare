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
require '../include/language/' . LANG . '/lang_admin_process_status_edit.php';

check_admin_login();

$err = '';

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

if (isset($_POST['submit']))
{
    $sql = "UPDATE `process_queue` SET
           `status`='" . (int) $_POST['status'] . "' WHERE
           `id`='" . (int) $_POST['id'] . "'";
    mysql_query($sql) or mysql_die();
    set_message($lang['process_status_updated'], 'success');
    $redirect_url = VSHARE_URL . '/admin/process_queue.php?page=' . $page;
    redirect($redirect_url);
}

if (isset($_GET['id']))
{
    $sql = "SELECT * FROM `process_queue` WHERE
          `id`='" . (int) $_GET['id'] . "'";
    $result = mysql_query($sql);
    $video_info = mysql_fetch_assoc($result);
    $smarty->assign('video_info', $video_info);
}

$smarty->assign('msg', $msg);
$smarty->assign('page', $page);
$smarty->display('admin/header.tpl');
$smarty->display('admin/process_status_edit.tpl');
$smarty->display('admin/footer.tpl');
db_close();
