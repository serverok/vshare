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
require '../include/language/' . LANG . '/admin/video_add_flv_2.php';

Admin::auth();

$success = 0;

if (isset($_SESSION['keywords'])) {
    $upload_video_keywords = $_SESSION['keywords'];
} else {
    $err = $lang['keywords_empty'];
}

if (isset($_SESSION['title'])) {
    $video_title = $_SESSION['title'];
} else {
    $err = $lang['title_empty'];
}

if (isset($_SESSION['description'])) {
    $video_description = $_SESSION['description'];
} else {
    $err = $lang['description_empty'];
}

if (isset($_SESSION['channels'])) {
    $video_channels = $_SESSION['channels'];
} else {
    $err = $lang['channels_empty'];
}

if (isset($_SESSION['video_privacy'])) {
    $video_type = $_SESSION['video_privacy'];
} else {
    $err = $lang['type_empty'];
}

if (isset($_SESSION['user_id'])) {
    $video_user_id = $_SESSION['user_id'];
} else {
    $err = $lang['userid_not_set'];
}

if ($err != '') {
    set_message($err, 'error');
    $redirect_url = VSHARE_URL . '/admin/video_add_flv.php';
    Http::redirect($redirect_url);
}

if (isset($_POST['submit'])) {
    $video_adult = isset($_SESSION['adult']) ? $_SESSION['adult'] : 0;
    $embed_code = isset($_POST['embed_code']) ? $_POST['embed_code'] : '';
    $flv_url = isset($_POST['flv_url']) ? $_POST['flv_url'] : '';

    if ($embed_code == '' && $flv_url == '') {
        $err = $lang['url_embed_empty'];
    } else if (empty($_POST['embedded_code_image'][0]) && empty($_POST['embedded_code_image_local'][0])) {
        $err = $lang['specify_image'];
    }

    if ($err == '') {
        if (strlen($flv_url) > 20) {
            $vtype = 2;
            $embed_code = $flv_url;
        } else {
            $vtype = 6;
        }

        $video_duration = '1';
        $video_length = '01:00';

        if (preg_match("/youtube/i", $embed_code)) {
            $youtube_video_id = BulkImport::getYoutubeVideoId($embed_code);
            if (! empty($youtube_video_id)) {
                $video_duration = Youtube::getVideoDuration($youtube_video_id);
                $video_length = sec2hms($video_duration);
            }
        }

        $sql = "INSERT INTO `videos` SET
               `video_user_id`=" . (int) $video_user_id . ",
               `video_title`='" . DB::quote($video_title) . "',
               `video_description`='" . DB::quote($video_description) . "',
               `video_keywords`='" . DB::quote($upload_video_keywords) . "',
               `video_seo_name`='" . Url::seoName($video_title) . "',
               `video_embed_code`='" . DB::quote($embed_code) . "',
               `video_channels`='0|$video_channels|0',
               `video_type`='$video_type',
               `video_vtype`=$vtype,
               `video_adult`='$video_adult',
               `video_duration`='" . (int) $video_duration . "',
               `video_length`='" . DB::quote($video_length) . "',
               `video_add_time`='" . time() . "',
               `video_add_date`='" . date("Y-m-d") . "',
               `video_active`='1',
               `video_approve`='$config[approve]'";

        $video_id = DB::insertGetId($sql);

        if ($video_type == 'public' && $config['approve'] == 1) {
            $current_keyword = DB::quote($upload_video_keywords);
            $tags = new Tag($current_keyword, $video_id, $video_user_id, $video_channels);
            $tags->add();
        }

        if (! empty($_POST['embedded_code_image'][0])) {
            // Make player image
            $embedded_image = $_POST['embedded_code_image'];
            $filename = basename($embedded_image[0]);

            $destination_tmp = VSHARE_DIR . '/templates_c/' . $filename;
            $source = $embedded_image[0];
            Http::download($source, $destination_tmp);

            $destination = VSHARE_DIR . '/thumb/' . $video_id . '.jpg';
            $source = $destination_tmp;
            $maxwidth = 500;
            $maxheight = 300;
            Image::createThumb($source, $destination, $maxwidth, $maxheight);

            unlink($destination_tmp);

            // Make thumbs
            $j = 0;

            for ($i = 0; $i < 3; $i ++) {
                $j ++;
                if (! empty($embedded_image[$i])) {
                    $filename = basename($embedded_image[$i]);
                    $destination_tmp = VSHARE_DIR . '/templates_c/' . $filename;
                    $source = $embedded_image[$i];
                    Http::download($source, $destination_tmp);

                    $destination = VSHARE_DIR . '/thumb/' . $j . '_' . $video_id . '.jpg';
                    $source = $destination_tmp;
                    Image::createThumb($source, $destination, $config['img_max_width'], $config['img_max_height']);

                    unlink($destination_tmp);
                } else {
                    $destination = VSHARE_DIR . '/thumb/' . $j . '_' . $video_id . '.jpg';
                    copy(VSHARE_DIR . '/themes/default/images/no_thumbnail.gif', $destination);
                }
            }
        } else if (! empty($_FILES['embedded_code_image_local']['tmp_name'][0])) {
            // Make player image
            $destination = VSHARE_DIR . '/thumb/' . $video_id . '.jpg';
            $source = $_FILES['embedded_code_image_local']['tmp_name'][0];
            $maxwidth = 500;
            $maxheight = 300;
            Image::createThumb($source, $destination, $maxwidth, $maxheight);

            // Make thumbs
            $j = 0;
            for ($i = 0; $i < 3; $i ++) {
                $j ++;
                if (! empty($_FILES['embedded_code_image_local']['name'][$i])) {
                    $destination = VSHARE_DIR . '/thumb/' . $j . '_' . $video_id . '.jpg';
                    Image::createThumb($_FILES['embedded_code_image_local']['tmp_name'][$i], $destination, $config['img_max_width'], $config['img_max_height']);
                } else {
                    copy(VSHARE_DIR . '/themes/default/images/no_thumbnail.gif', VSHARE_DIR . '/thumb/' . $j . '_' . $video_id . '.jpg');
                }
            }
        }

        $msg = $lang['video_added'];
        $success = 1;
    }
} else {
    $embed_code = $flv_url = '';
}

$smarty->assign('embed_code', $embed_code);
$smarty->assign('flv_url', $flv_url);
$smarty->assign('success', $success);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/video_add_flv_2.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
