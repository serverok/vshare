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
require '../include/language/' . LANG . '/admin/settings.php';

Admin::auth();

if (isset($_POST['submit']))
{
    if (is_numeric($_POST['process_upload'])) {
        $sql = "UPDATE `config` SET
               `config_value`='" . (int) $_POST['process_upload'] . "' WHERE
               `config_name`='process_upload'";
        DB::query($sql);
    }

    if (in_array($_POST['tool_video_thumb'], array('ffmpeg', 'ffmpeg-php', 'mplayer'))) {
        $sql = "UPDATE `config` SET
               `config_value`='" . $_POST['tool_video_thumb'] . "' WHERE
               `config_name`='tool_video_thumb'";
        DB::query($sql);
    }

    if (is_numeric($_POST['video_flv_delete'])) {
        $sql = "UPDATE `config` SET
               `config_value`='" . (int) $_POST['video_flv_delete'] . "' WHERE
               `config_name`='video_flv_delete'";
        DB::query($sql);
    }

    if (isset($_POST['flv_metadata'])) {
        if ($_POST['flv_metadata'] == 'yamdi' || $_POST['flv_metadata'] == 'flvtool' || $_POST['flv_metadata'] == 'none') {
            $sql = "UPDATE `config` SET
                   `config_value`='" . DB::quote($_POST['flv_metadata']) . "' WHERE
                   `config_name`='flv_metadata'";
            DB::query($sql);
        }
    }

    if (is_numeric($_POST['process_notify_user'])) {
        $sql = "UPDATE `config` SET
               `config_value`='" . (int) $_POST['process_notify_user'] . "' WHERE
               `config_name`='process_notify_user'";
        DB::query($sql);
    }

    if (is_numeric($_POST['guest_upload'])) {
        $sql = "UPDATE `config` SET
               `config_value`='" . (int) $_POST['guest_upload'] . "' WHERE
               `config_name`='guest_upload'";
        DB::query($sql);
    }

    if (! empty($_POST['guest_upload_user']) && $_POST['guest_upload'] == 1) {
        $sql = "UPDATE `config` SET
               `config_value`='" . DB::quote($_POST['guest_upload_user']) . "' WHERE
               `config_name`='guest_upload_user'";
        DB::query($sql);
    }

    $msg = $lang['settings_updated'];
}

$smarty->assign('process_upload', Config::get('process_upload'));
$smarty->assign('tool_video_thumb', Config::get('tool_video_thumb'));
$smarty->assign('video_flv_delete', Config::get('video_flv_delete'));
$smarty->assign('flv_metadata', Config::get('flv_metadata'));
$smarty->assign('process_notify_user', Config::get('process_notify_user'));
$smarty->assign('guest_upload', Config::get('guest_upload'));
$smarty->assign('guest_upload_user', Config::get('guest_upload_user'));
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/settings_video.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
