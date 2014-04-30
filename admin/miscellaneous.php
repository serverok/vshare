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
require '../include/language/' . LANG . '/lang_admin_miscellaneous.php';

Admin::auth();

if (isset($_POST['submit'])) {
    if ($_POST['guest_upload'] == 1) {
        if ($_POST['guest_upload_user'] == '') {
            $err = $lang['guest_user_name_empty'];
        } else if (! check_field_exists($_POST['guest_upload_user'], 'user_name', 'users')) {
            $err = $lang['user_name_invalid'];
        }
    }

    if ($err == '') {
        $sql = "UPDATE `sconfig` SET
               `svalue`='" . DB::quote($_POST['video_rating']) . "' WHERE
               `soption`='video_rating'";
        DB::query($sql);
        $smarty->assign('video_rating', $_POST['video_rating']);

        if (is_numeric($_POST['allow_download'])) {
            $sql = "UPDATE `sconfig` SET
                   `svalue`='" . (int) $_POST['allow_download'] . "' WHERE
                   `soption`='allow_download'";
            DB::query($sql);
            $smarty->assign('allow_download', $_POST['allow_download']);
        }

        if (is_numeric($_POST['admin_listing_per_page'])) {
            $sql = "UPDATE `config` SET
                   `config_value`='" . (int) $_POST['admin_listing_per_page'] . "' WHERE
                   `config_name`='admin_listing_per_page'";
            DB::query($sql);
        }

        if (is_numeric($_POST['process_upload'])) {
            $sql = "UPDATE `config` SET
                   `config_value`='" . (int) $_POST['process_upload'] . "' WHERE
                   `config_name`='process_upload'";
            DB::query($sql);
        }

        if (is_numeric($_POST['video_duration_cmd'])) {
            $sql = "UPDATE `config` SET
                   `config_value`='" . (int) $_POST['video_duration_cmd'] . "' WHERE
                   `config_name`='video_duration_cmd'";
            DB::query($sql);
        }

        if (is_numeric($_POST['process_notify_user'])) {
            $sql = "UPDATE `config` SET
                   `config_value`='" . (int) $_POST['process_notify_user'] . "' WHERE
                   `config_name`='process_notify_user'";
            DB::query($sql);
        }

        if (is_numeric($_POST['video_flv_delete'])) {
            $sql = "UPDATE `config` SET
                   `config_value`='" . (int) $_POST['video_flv_delete'] . "' WHERE
                   `config_name`='video_flv_delete'";
            DB::query($sql);
        }

        if (is_numeric($_POST['recommend_all'])) {
            $sql = "UPDATE `config` SET
                   `config_value`='" . (int) $_POST['recommend_all'] . "' WHERE
                   `config_name`='recommend_all'";
            DB::query($sql);
        }

        $sql = "UPDATE `config` SET
               `config_value`='" . DB::quote($_POST['php_path']) . "' WHERE
               `config_name`='php_path'";
        DB::query($sql);

        if (is_numeric($_POST['video_comments_per_page'])) {
            $sql = "UPDATE `sconfig` SET
                   `svalue`='" . (int) $_POST['video_comments_per_page'] . "' WHERE
                   `soption`='video_comments_per_page'";
            DB::query($sql);
            $smarty->assign('video_comments_per_page', $_POST['video_comments_per_page']);
        }

        if (is_numeric($_POST['video_comment_notify'])) {
            $sql = "UPDATE `config` SET
                   `config_value`='" . (int) $_POST['video_comment_notify'] . "' WHERE
                   `config_name`='video_comment_notify'";
            DB::query($sql);
            $smarty->assign('video_comment_notify', $_POST['video_comment_notify']);
        }

        if (is_numeric($_POST['user_comments_per_page'])) {
            $sql = "UPDATE `sconfig` SET
                   `svalue`='" . (int) $_POST['user_comments_per_page'] . "' WHERE
                   `soption`='user_comments_per_page'";
            DB::query($sql);
            $smarty->assign('user_comments_per_page', $_POST['user_comments_per_page']);
        }

        if (is_numeric($_POST['editor_wysiwyg_admin'])) {
            $sql = "UPDATE `config` SET
                   `config_value`='" . (int) $_POST['editor_wysiwyg_admin'] . "' WHERE
                   `config_name`='editor_wysiwyg_admin'";
            DB::query($sql);
        }

        if (is_numeric($_POST['editor_wysiwyg_email'])) {
            $sql = "UPDATE `config` SET
                   `config_value`='" . (int) $_POST['editor_wysiwyg_email'] . "' WHERE
                   `config_name`='editor_wysiwyg_email'";
            DB::query($sql);
        }

        if (is_numeric($_POST['mail_abuse_report'])) {
            $sql = "UPDATE `config` SET
                   `config_value`='" . (int) $_POST['mail_abuse_report'] . "' WHERE
                   `config_name`='mail_abuse_report'";
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

        if (is_numeric($_POST['num_channel_video'])) {
            $sql = "UPDATE `config` SET
                   `config_value`='" . (int) $_POST['num_channel_video'] . "' WHERE
                   `config_name`='num_channel_video'";
            DB::query($sql);
        }

        if (is_numeric($_POST['num_max_channels'])) {
            $sql = "UPDATE `config` SET
                   `config_value`='" . intval($_POST['num_max_channels']) . "' WHERE
                   `config_name`='num_max_channels'";
            DB::query($sql);
        }

        if (is_numeric($_POST['user_daily_mail_limit'])) {
            $sql = "UPDATE `config` SET
                   `config_value`='" . intval($_POST['user_daily_mail_limit']) . "' WHERE
                   `config_name`='user_daily_mail_limit'";
            DB::query($sql);
        }

        if (isset($_POST['dailymotion_api_key']))
        {
            $sql = "UPDATE `config` SET
                   `config_value`='" . DB::quote($_POST['dailymotion_api_key']) . "' WHERE
                   `config_name`='dailymotion_api_key'";
            DB::query($sql);
        }

        if (isset($_POST['dailymotion_api_secret']))
        {
            $sql = "UPDATE `config` SET
                   `config_value`='" . DB::quote($_POST['dailymotion_api_secret']) . "' WHERE
                   `config_name`='dailymotion_api_secret'";
            DB::query($sql);
        }

        $msg = $lang['settings_updated'];
    }
}

$smarty->assign('dailymotion_api_key', Config::get('dailymotion_api_key'));
$smarty->assign('dailymotion_api_secret', Config::get('dailymotion_api_secret'));
$smarty->assign('video_comment_notify', Config::get('video_comment_notify'));
$smarty->assign('user_daily_mail_limit', Config::get('user_daily_mail_limit'));
$smarty->assign('flv_metadata', Config::get('flv_metadata'));
$smarty->assign('video_duration_cmd', Config::get('video_duration_cmd'));
$smarty->assign('num_channel_video', Config::get('num_channel_video'));
$smarty->assign('guest_upload', Config::get('guest_upload'));
$smarty->assign('guest_upload_user', Config::get('guest_upload_user'));
$smarty->assign('video_flv_delete', Config::get('video_flv_delete'));
$smarty->assign('enable_flvtool', Config::get('enable_flvtool'));
$smarty->assign('mail_abuse_report', Config::get('mail_abuse_report'));
$smarty->assign('recommend_all', Config::get('recommend_all'));
$smarty->assign('php_path', Config::get('php_path'));
$smarty->assign('item_per_page', Config::get('admin_listing_per_page'));
$smarty->assign('process_upload', Config::get('process_upload'));
$smarty->assign('process_notify_user', Config::get('process_notify_user'));
$smarty->assign('editor_wysiwyg_admin', Config::get('editor_wysiwyg_admin'));
$smarty->assign('editor_wysiwyg_email', Config::get('editor_wysiwyg_email'));
$smarty->assign('num_max_channels', Config::get('num_max_channels'));
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/miscellaneous.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
