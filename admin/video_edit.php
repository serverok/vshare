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
require '../include/class.video.php';
require '../include/class.tags.php';
require '../include/class.channels.php';
require '../include/language/' . LANG . '/lang_admin_video_edit.php';

check_admin_login();

$video_id = isset($_GET['video_id']) ? $_GET['video_id'] : 0;

if (! is_numeric($video_id))
{
    echo $lang['vid_invalid'];
    exit(0);
}

$num_max_channels = get_config('num_max_channels');

if (isset($_POST['submit']))
{
    $video = new Video();
    $video->video_id = $video_id;
    $video->video_title = $_POST['video_title'];
    $video->video_description = $_POST['video_description'];
    $video->video_keywords = $_POST['video_keywords'];
    $video->video_duration = (int) $_POST['video_duration'];
    $video->video_channels = $_POST['video_channels'];
    $video->video_type = $_POST['video_type'];
    $video->video_featured = $_POST['video_featured'];
    $video->video_active = (int) $_POST['video_active'];
    $video->video_allow_comment = $_POST['video_allow_comment'];
    $video->video_allow_rated = $_POST['video_allow_rated'];
    $video->video_allow_embed = $_POST['video_allow_embed'];
    $video->video_embeded_code = isset($_POST['video_embed_code']) ? $_POST['video_embed_code'] : '';
    $video->video_adult = (int) $_POST['video_adult'];
    $video->is_admin = 1;
    $save = $video->video_update();
    
    if ($save == 1)
    {
        set_message($lang['video_edit_ok'], 'success');
        $redirect_url = VSHARE_URL . '/admin/video_details.php?id=' . $video_id;
        redirect($redirect_url);
    }
    else
    {
        $err = $save;
    }
}

$sql = "SELECT * FROM `videos` WHERE
       `video_id`='" . (int) $video_id . "'";
$result = mysql_query($sql) or mysql_die($sql);
$video = mysql_fetch_assoc($result);

$mych = explode('|', $video['video_channels']);
$ch = channels::get_all();

$ch_checkbox = '';

for ($i = 0; $i < count($ch); $i ++)
{
    if (in_array($ch[$i]['channel_id'], $mych))
    {
        $checked = 'checked="checked"';
    }
    else
    {
        $checked = '';
    }
    
    $ch_checkbox .= '<input type="checkbox" name="video_channels[]" value=' . $ch[$i]['channel_id'] . ' ' . $checked . '>' . htmlspecialchars_uni($ch[$i]['channel_name']) . '</input><br />';
}

$smarty->assign('ch_checkbox', $ch_checkbox);

if ($video['video_type'] == 'public')
{
    $public_select = 'selected="selected"';
    $private_select = '';
}
else
{
    $private_select = 'selected="selected"';
    $public_select = '';
}

$type_box = "
<option value='public' $public_select>Public</option>
<option value='private' $private_select>Private</option>
";

$smarty->assign('type_box', $type_box);

if ($video['video_featured'] == 'yes')
{
    $featured_yes = 'selected="selected"';
    $featured_no = '';
}
else
{
    $featured_no = 'selected="selected"';
    $featured_yes = '';
}

$featured_box = "
<option value='yes' $featured_yes>Yes</option>
<option value='no' $featured_no>No</option>
";

$smarty->assign('featured_box', $featured_box);

if ($video['video_active'] == 1)
{
    $active_yes = 'selected="selected"';
    $active_no = '';
}
else
{
    $active_no = 'selected="selected"';
    $active_yes = '';
}

$active_box = "
<option value='1' $active_yes>Yes</option>
<option value='0' $active_no>No</option>
";

$smarty->assign('active_box', $active_box);

if ($video['video_allow_comment'] == 'yes')
{
    $video_allow_comment_yes = 'selected="selected"';
    $video_allow_comment_no = '';
}
else
{
    $video_allow_comment_no = 'selected="selected"';
    $video_allow_comment_yes = '';
}

$comment_box = "
<option value='yes' $video_allow_comment_yes>Yes</option>
<option value='no' $video_allow_comment_no>No</option>
";

$smarty->assign('comment_box', $comment_box);

if ($video['video_allow_rated'] == 'yes')
{
    $be_rated_yes = 'selected="selected"';
    $be_rated_no = '';
}
else
{
    $be_rated_no = 'selected="selected"';
    $be_rated_yes = '';
}

$rate_box = "
<option value='yes' $be_rated_yes>Yes</option>
<option value='no' $be_rated_no>No</option>
";

$smarty->assign('rate_box', $rate_box);

if ($video['video_allow_embed'] == 'enabled')
{
    $embed_yes = 'selected="selected"';
    $embed_no = '';
}
else
{
    $embed_no = 'selected="selected"';
    $embed_yes = '';
}

$embed_box = "
<option value='1' $embed_yes>Yes</option>
<option value='0' $embed_no>No</option>
";

$smarty->assign('embed_box', $embed_box);
$smarty->assign('video', $video);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('a', $_GET['a']);
$smarty->display('admin/header.tpl');
$smarty->display('admin/video_edit.tpl');
$smarty->display('admin/footer.tpl');
db_close();
