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
require '../include/class.channels.php';
require '../include/settings/upload.php';
require '../include/language/' . LANG . '/lang_admin_video_add_flv.php';

check_admin_login();

$num_max_channels = get_config('num_max_channels');
$smarty->assign('num_max_channels', $num_max_channels);

if (isset($_POST['submit']))
{

    $user_info = User::getByName($_POST['video_user']);

    if (! $user_info) {
        $err = $lang['user_not_found'];
    } else if (strlen($_POST['video_title']) < 4) {
        $err = $lang['title_too_short'];
    } else if (strlen($_POST['video_description']) < 4) {
        $err = $lang['description_too_short'];
    } else if (strlen($_POST['video_keywords']) < 4) {
        $err = $lang['tags_too_short'];
    } else if (! isset($_POST['channel'])) {
        $err = str_replace('[NUM_MAX_CHANNELS]', $num_max_channels, $lang['channel_not_selected']);
    } else if ((count($_POST['channel']) < 1) || (count($_POST['channel']) > $num_max_channels)) {
        $err = str_replace('[NUM_MAX_CHANNELS]', $num_max_channels, $lang['channel_not_selected']);
    }
    if (empty($err)) {
        $listch = implode('|', $_POST['channel']);

        if ($_POST['video_privacy'] != 'public') {
            $_POST['video_privacy'] = 'private';
        }

        $_SESSION['video_privacy'] = $_POST['video_privacy'];
        $_SESSION['description'] = $_POST['video_description'];
        $_SESSION['title'] = $_POST['video_title'];
        $_SESSION['keywords'] = $_POST['video_keywords'];
        $_SESSION['channels'] = $listch;
        $_SESSION['user_id'] = $user_info['user_id'];
        $_SESSION['adult'] = 0;
        $redirect_url = VSHARE_URL . '/admin/video_add_flv_2.php';
        Http::redirect($redirect_url);
    }
}

$ch = Channel::get();

$channel_checkbox = '';

for ($i = 0; $i < count($ch); $i ++) {
    $channel_checkbox .= '<input type="checkbox" name="channel[]" value="' . $ch[$i]['channel_id'] . '" />' . $ch[$i]['channel_name_html'] . '<br />';
}

$smarty->assign('ch_checkbox', $channel_checkbox);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/video_add_flv.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
