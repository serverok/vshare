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

if ($page < 1) {
    $page = 1;
}

if (isset($_POST['submit'])) {
    if (is_numeric($_GET['id']) && ! empty($_POST['comments'])) {
        $sql = "UPDATE `comments` SET
               `comment_text`='" . DB::quote($_POST['comments']) . "' WHERE
               `comment_id`='" . (int) $_GET['id'] . "'";
        DB::query($sql);
        $redirect_url = VSHARE_URL . '/admin/comment.php?page=' . $page;
        Http::redirect($redirect_url);
    }
}

$sql = "SELECT * FROM `comments` WHERE
       `comment_id`='" . (int) $_GET['id'] . "'";
$comment = DB::fetch1($sql);

$smarty->assign('msg', $msg);
$smarty->assign('vid', $comment['comment_video_id']);
$smarty->assign('page', $page);
$smarty->assign('comid', $_GET['id']);
$smarty->assign('comments', $comment['comment_text']);
$smarty->display('admin/header.tpl');
$smarty->display('admin/comment_edit.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
