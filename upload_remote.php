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

require 'include/config.php';
require 'include/functions_seo_name.php';
require 'include/class.tags.php';
require 'include/language/' . LANG . '/lang_upload_remote.php';

$guest_upload = get_config('guest_upload');

if ($guest_upload == 0) {
    User::is_logged_in();
    $user_id = $_SESSION['UID'];
} else {
    $user_name = get_config('guest_upload_user');
    $sql = "SELECT * FROM `users` WHERE
           `user_name`='" . DB::quote($user_name) . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $user_info = mysql_fetch_assoc($result);
    $user_id = $user_info['user_id'];
}

$upload_id = $_GET['upload_id'];

/*

--------------------------
VTYPE
--------------------------
LOCAL              0
YOUTUBE            1
FLV FILE           2
STAGE6.COM         3
REVVER.COM         4
METACAFE.COM       5
ENBEDDED           6
--------------------------
*/

if (isset($_SESSION["$upload_id"]['keywords'])) {
    $upload_video_keywords = $_SESSION["$upload_id"]['keywords'];
} else {
    $err = 1;
}

if (isset($_SESSION["$upload_id"]['title'])) {
    $upload_video_title = $_SESSION["$upload_id"]['title'];
} else {
    $err = 1;
}

if (isset($_SESSION["$upload_id"]['description'])) {
    $upload_video_descr = $_SESSION["$upload_id"]['description'];
} else {
    $err = 1;
}

if (isset($_SESSION["$upload_id"]['channels'])) {
    $channels = $_SESSION["$upload_id"]['channels'];
} else {
    $err = 1;
}

if (isset($_SESSION["$upload_id"]['field_privacy'])) {
    $type = $_SESSION["$upload_id"]['field_privacy'];
} else {
    $err = 1;
}

if ($err == 1) {
    $redirect_url = VSHARE_URL . '/upload.php';
    Http::redirect($redirect_url);
}

if (isset($_POST['submit'])) {
    $adult = isset($_SESSION["$upload_id"]['adult']) ? $_SESSION["$upload_id"]['adult'] : 0;
    $url = $_POST['url'];

    if ($url == '') {
        $err = $lang['url_empty'];
    }

    if ($err == '' && preg_match("/youtube/i", $url) || preg_match("/revver/i", $url) || preg_match("/metacafe/i", $url)) {
        # TO CREATE SEO NAME
        $seo_name = seo_name($upload_video_title);

        $video_duration = '1';
        $video_length = '01:00';

        if (preg_match("/youtube/i", $url)) {
            require 'include/class.bulk_import.php';

            $youtube_video_id = BulkImport::getYoutubeVideoId($url);

            if (! empty($youtube_video_id)) {
                require 'Zend/Loader.php';
                Zend_Loader::loadClass('Zend_Gdata_YouTube');

                $youtube_video_info = BulkImport::getYoutubeVideoInfo($youtube_video_id);
                $video_duration = $youtube_video_info['video_duration'];
                $video_length = sec2hms($youtube_video_info['video_duration']);
            }
        }

        if ($config['approve'] == 1 && get_config('moderate_video_links') == 1) {
            if (preg_match('{\b(?:http://)?(www\.)?([^\s]+)*(\.[a-z]{2,3})\b}mi', $upload_video_descr)) {
                $config['approve'] = 0;
            }
        }

        # INSERT VIDEO TABLE VALUES


        $sql = "INSERT INTO `videos` SET
                   `video_user_id`='" . (int) $user_id . "',
                   `video_title`='" . DB::quote($upload_video_title) . "',
                   `video_description`='" . DB::quote($upload_video_descr) . "',
                   `video_keywords`='" . DB::quote($upload_video_keywords) . "',
                   `video_seo_name`='" . DB::quote($seo_name) . "',
                   `video_channels`='0|" . DB::quote($channels) . "|0',
                   `video_type`='" . DB::quote($type) . "',
                   `video_adult`='" . (int) $adult . "',
                   `video_duration`='" . (int) $video_duration . "',
                   `video_length`='" . DB::quote($video_length) . "',
                   `video_add_time`='" . $_SERVER['REQUEST_TIME'] . "',
                   `video_add_date`='" . date('Y-m-d') . "',
                   `video_active`='1',
                   `video_approve`='$config[approve]'";

        $result = mysql_query($sql) or mysql_die($sql);
        $video_id = mysql_insert_id();

        require 'include/class.upload_remote.php';
        $upload_remote = new upload_remote();
        $upload_remote->vid = $video_id;
        $upload_remote->url = $url;
        $upload_remote->debug = 1;

        if ($type == 'public' && $config['approve'] == 1) {
            $current_keyword = DB::quote($upload_video_keywords);
            $tags = new Tags($current_keyword, $video_id, $_SESSION['UID'], "0|$channels|0");
            $tags->add();
        }

        # CREATE THUMBNAILS


        if (preg_match("/youtube/i", $url)) {
            $err = $upload_remote->youtube();
        } else if (preg_match("/revver/i", $url)) {
            $err = $upload_remote->revver();
        } else if (preg_match("/metacafe/i", $url)) {
            $err = $upload_remote->metacafe();
        } else {
            $err = 'url not supported';
        }

        if ($err == '') {
            $sql = "UPDATE `subscriber` SET
                       `total_video`=`total_video`+1 WHERE
                       `UID`='" . (int) $user_id . "'";
            mysql_query($sql) or mysql_die($sql);
            $redirect_url = VSHARE_URL . '/upload/success/' . $video_id . '/remote/';
            Http::redirect($redirect_url);
        }
    } else {
        $err = $lang['invalid_url'];
    }
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('upload_remote.tpl');
$smarty->display('footer.tpl');
DB::close();
