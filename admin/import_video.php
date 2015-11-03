<?php
/******************************************************************************
 *
 * COMPANY: BuyScripts.in
 * PROJECT: vShare Youtube Clone
 * VERSION: VSHARE_VERSION_NUMBER_HERE
 * LICENSE: http://buyscripts.in/vshare-license
 * WEBSITE: http://buyscripts.in/vshare-youtube-clone
 *
 * This program is a commercial software and any kind of using it must agree
 * to vShare license.
 *
 ******************************************************************************/

require 'admin_config.php';
require '../include/config.php';
require '../include/settings/upload.php';
require '../include/language/' . LANG . '/admin/import_video.php';

Admin::auth();

if (isset($_POST['submit'])) {
    $video_url = $_POST['video_url'];
    $video_title = $_POST['video_title'];
    $video_description = $_POST['video_description'];
    $video_keywords = $_POST['video_keywords'];

    # check if user exists

    $user_info = User::getByName($_POST['video_user']);

    if (! $user_info) {
        $err = $lang['user_not_found'];
    }

    if ($err == '') {

        if ($video_url == '') {
            $err = $lang['video_url_empty'];
        } else if (strlen($video_title) < 4) {
            $err = $lang['title_too_short'];
        } else if (strlen($video_description) < 4) {
            $err = $lang['description_too_short'];
        } else if (strlen($video_keywords) < 4) {
            $err = $lang['tags_too_short'];
        } else {
            $file_extn = File::get_extension($video_url);
            if (! in_array($file_extn, $file_types)) {
                $allowed_types = implode(',', $file_types);
                $err = str_replace('[ALLOWED_TYPES]', $allowed_types, $lang['invalid_video_format']);
            } else if ((check_field_exists($video_url, 'url', 'process_queue') == 1)) {
                $err = $lang['import_video_url_exist'];
            }
        }
    }

    if ($err == '') {
        $channel = $_POST['channel'];

        $sql = "INSERT INTO `process_queue`SET
               `user`='" . DB::quote($_POST['video_user']) . "',
               `title`='" . DB::quote($video_title) . "',
               `description`='" . DB::quote($video_description) . "',
               `keywords`='" . DB::quote($video_keywords) . "',
               `process_queue_upload_ip`='" . User::get_ip() . "',
               `type`='" . DB::quote($_POST['video_privacy']) . "',
               `channels`='$channel',
               `status`=0,
               `url`='" . DB::quote($video_url) . "'";
        DB::query($sql);
        $msg = $lang['video_process'];
        $smarty->assign('finished', 1);
    }
}

$smarty->assign('allowed_types', implode(', ', $file_types));
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('channels', Channel::get());
$smarty->display('admin/header.tpl');
$smarty->display('admin/import_video.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
