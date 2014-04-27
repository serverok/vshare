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
require 'include/class.video.php';
require 'include/class.tags.php';
require 'include/class.channels.php';
require 'include/language/' . LANG . '/lang_video_edit.php';

User::is_logged_in();

$video_id = isset($_GET['video_id']) ? (int) $_GET['video_id'] : 0;
$num_max_channels = get_config('num_max_channels');
$smarty->assign('num_max_channels', $num_max_channels);

if (isset($_POST['submit']))
{
    $video_id = $_POST['video_id'];
    $video = new Video();
    $video->video_id = $video_id;
    $video->video_title = $_POST['video_title'];
    $video->video_description = $_POST['video_description'];
    $video->video_keywords = $_POST['video_keywords'];
    $video->video_channels = $_POST['channel_list'];
    $video->video_type = $_POST['video_type'];
    $video->video_allow_comment = $_POST['video_allow_comment'];
    $video->video_allow_rated = $_POST['video_allow_rated'];
    $video->video_allow_embed = $_POST['video_allow_embed'];
    $save = $video->video_update();
    
    if ($save == 1)
    {
        set_message($lang['video_info_update'], 'success');
        $redirect_url = VSHARE_URL . '/view/' . $video_id . '/' . $video->video_info['video_seo_name'] . '/';
        Http::redirect($redirect_url);
    }
    else
    {
        $err = $save;
    }
}

$sql = "SELECT * FROM `videos` WHERE
       `video_id`='" . (int) $video_id . "' AND
       `video_user_id`='" . (int) $_SESSION['UID'] . "' AND
       `video_active`='1' AND
       `video_approve`=1";
$result = mysql_query($sql) or mysql_die($sql);
$num_result = mysql_num_rows($result);

if ($num_result == 0)
{
    $err = $lang['video_owner'];
}
else
{
    $video_info = mysql_fetch_assoc($result);
    $video_info['video_description'] = str_replace(array('<p>', '</p>'), '', $video_info['video_description']);
}

$chid = explode('|', $video_info['video_channels']);

$channels_all = channels::get_all();

$smarty->assign('channels_all', $channels_all);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('chid', $chid);
$smarty->assign('video_info', $video_info);
$smarty->assign('sub_menu', 'menu_home.tpl');
$smarty->display('header.tpl');

if ($num_result == 1)
{
    $smarty->display('video_edit.tpl');
}
$smarty->display('footer.tpl');
DB::close();
