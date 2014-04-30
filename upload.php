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
require 'include/language/' . LANG . '/lang_upload.php';

if (Config::get('guest_upload') != 1) {
    User::is_logged_in();
    if ($config['enable_package'] == 'yes') {
        check_subscriber_space($_SESSION['UID']);
        check_subscriber_videos($_SESSION['UID']);
    }
}

$num_max_channels = Config::get('num_max_channels');
$smarty->assign('num_max_channels', $num_max_channels);

if (isset($_POST['action_upload'])) {

    if (get_magic_quotes_gpc()) {
        $_POST['video_keywords'] = stripslashes($_POST['video_keywords']);
        $_POST['video_title'] = stripslashes($_POST['video_title']);
        $_POST['video_description'] = stripslashes($_POST['video_description']);
    }

    $_POST['chlist'] = isset($_POST['chlist']) ? $_POST['chlist'] : array();

    $channel_arr = array();

    foreach ($_POST['chlist'] as $channel) {
        $channel = (int) $channel;
        if (! in_array($channel, $channel_arr) && check_field_exists($channel, 'channel_id', 'channels')) {
            $channel_arr[] = $channel;
        }
    }

    $_POST['chlist'] = $channel_arr;

    $_POST['video_description'] = Xss::clean($_POST['video_description']);
    $_POST['video_title'] = htmlspecialchars_uni($_POST['video_title']);
    $_POST['video_keywords'] = strip_tags($_POST['video_keywords']);

    if (strlen_uni($_POST['video_title']) < 4) {
        $err = $lang['title_too_short'];
    } else if (strlen_uni($_POST['video_description']) < 4) {
        $err = $lang['description_too_short'];
    } else if (strlen_uni($_POST['video_keywords']) < 4) {
        $err = $lang['tags_too_short'];
    } else if (! isset($_POST['chlist']) || count($_POST['chlist']) < 1 || count($_POST['chlist']) > $num_max_channels) {
        $err = str_replace('[NUM_MAX_CHANNELS]', $num_max_channels, $lang['channel_not_selected']);
    }

    $upload_from = isset($_POST['upload_from']) ? $_POST['upload_from'] : 'local';

    if ($_POST['field_privacy'] != 'public') {
        $_POST['field_privacy'] = 'private';
    }

    $listch = '';

    if (isset($_POST['chlist']) && count($_POST['chlist']) > 0) {
        $listch = implode('|', $_POST['chlist']);
        $listch = htmlspecialchars_uni($listch);
    }

    if ($_POST['video_adult'] != 1) {
        $_POST['video_adult'] = 0;
    }

    $upload_id = md5($_SERVER['REQUEST_TIME'] . rand(1, 2000));
    $upload_info = array();
    $upload_info['title'] = $_POST['video_title'];
    $upload_info['description'] = $_POST['video_description'];
    $upload_info['keywords'] = $_POST['video_keywords'];
    $upload_info['channels'] = $listch;
    $upload_info['field_privacy'] = $_POST['field_privacy'];
    $upload_info['adult'] = $_POST['video_adult'];
    $upload_info['type'] = $_POST['field_privacy'];

    $_SESSION["$upload_id"] = $upload_info;

    if ($err == '') {
        if ($upload_from == 'remote') {
            $redirect_url = VSHARE_URL . '/upload_remote.php?upload_id=' . $upload_id;
        } else {
            $redirect_url = VSHARE_URL . '/upload_file.php?id=' . $upload_id;
        }
        Http::redirect($redirect_url);
    }
}

$channels = Channel::get();

$smarty->assign('channel_info', $channels);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('upload.tpl');
$smarty->display('footer.tpl');
DB::close();
