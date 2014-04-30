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
require '../include/language/' . LANG . '/lang_admin_process_status_edit.php';

Admin::auth();

$err = '';

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

if (isset($_POST['submit'])) {
    $sql = "UPDATE `process_queue` SET
           `status`='" . (int) $_POST['status'] . "' WHERE
           `id`='" . (int) $_POST['id'] . "'";
    DB::query($sql);
    set_message($lang['process_status_updated'], 'success');
    $redirect_url = VSHARE_URL . '/admin/process_queue.php?page=' . $page;
    Http::redirect($redirect_url);
}

if (isset($_GET['id'])) {
    $sql = "SELECT * FROM `process_queue` WHERE
          `id`='" . (int) $_GET['id'] . "'";
    $video_info = DB::fetch1($sql);
    $smarty->assign('video_info', $video_info);
}

$smarty->assign('msg', $msg);
$smarty->assign('page', $page);
$smarty->display('admin/header.tpl');
$smarty->display('admin/process_status_edit.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
