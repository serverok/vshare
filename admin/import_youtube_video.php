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

Admin::auth();

if (Config::get('youtube_api_key') == '') {
    $err = 'You must set <strong>Youtube API Key</strong> at Configuration -> Miscellaneous -> Youtube API Key:';
}

if (isset($_POST['submit'])) {
    $video_url = trim($_POST['url']);
    $user = trim($_POST['user']);
    $privacy = trim($_POST['privacy']);
    $privacy = ($privacy == 'private') ? 'private' : 'public';
    $channel = isset($_POST['channel']) ? $_POST['channel'] : '';

    if (filter_var($video_url, FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED) === false) {
        $err = 'Invalid Youtube video url.';
    } else {
        $youtube_video_id = BulkImport::getYoutubeVideoId($video_url);
        if (BulkImport::checkImported($youtube_video_id, 'youtube')) {
            $err = 'Video already imported.';
        }
    }

    if ($err == '') {
        if (! check_field_exists($user, 'user_name', 'users')) {
            $err = 'User not found.';
        } else if (empty($channel)) {
            $err = 'Please select atleast one channel.';
        }
    }

    if ($err == '') {
        $video_info = Youtube::getVideoInfo($youtube_video_id);
        $user_info = User::getByName($user);
        $seo_name = Url::seoName($video_info['video_title']);

        $sql = "INSERT INTO `videos` SET
               `video_user_id`='" . (int) $user_info['user_id'] . "',
               `video_title`='" . DB::quote($video_info['video_title']) . "',
               `video_description`='" . DB::quote($video_info['video_description']) . "',
               `video_keywords`='" . DB::quote($video_info['video_keywords']) . "',
               `video_seo_name`='" . DB::quote($seo_name) . "',
               `video_channels`='0|" . DB::quote($channel) . "|0',
               `video_type`='" . DB::quote($privacy) . "',
               `video_duration`='" . (int) $video_info['video_duration'] . "',
               `video_length`='" . DB::quote($video_info['video_length']) . "',
               `video_add_time`='" . $_SERVER['REQUEST_TIME'] . "',
               `video_add_date`='" . date('Y-m-d') . "',
               `video_active`='1',
               `video_approve`='$config[approve]'";
        $vid = DB::insertGetId($sql);

        $upload = new UploadRemote();
        $upload->vid = $vid;
        $upload->url = $video_url;
        $upload->debug = 1;
        $upload->youtube();

        if ($config['approve'] == 1) {
            if (! empty($video_info['video_keywords'])) {
                $tags = new Tag($video_info['video_keywords'], $vid, $user_id, "0|$channel|0");
                $tags->add();
                $video_tags = $tags->get_tags();
                $sql = "UPDATE `videos` SET
                       `video_keywords`='" . DB::quote(implode(' ', $video_tags)) . "' WHERE
                       `video_id`='" . (int) $vid . "'";
                DB::query($sql);
            }
        }

        $sql = "INSERT INTO `import_track` SET
               `import_track_unique_id`='" . DB::quote($youtube_video_id) . "' ,
               `import_track_video_id`=" . (int) $vid . ",
               `import_track_site`='youtube'";
        $import_track_id = DB::insertGetId($sql);

        User::updateVideoCount($user_info['user_id']);

        $msg = 'Video has been imported successfully.';
        set_message($msg, 'success');
        DB::close();
        Http::redirect('video_details.php?id=' . $vid);
    }

} else {
    $video_url = '';
    $user = '';
}

$smarty->assign(array(
    'err' => $err,
    'msg' => $msg,
    'video_url' => $video_url,
    'user' => $user,
));
$smarty->display('admin/header.tpl');
$smarty->display('admin/import_youtube_video.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
