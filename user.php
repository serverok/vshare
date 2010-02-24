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
require 'include/language/' . LANG . '/lang_user.php';

$user_name = $_GET['user_name'];

$sql = "SELECT * FROM `users` WHERE
       `user_name`='" . mysql_clean($user_name) . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) != 1)
{
    set_message($lang['user_not_found'], 'error');
    $redirect_url = VSHARE_URL . '/index.php';
    redirect($redirect_url);
}

$user_info = mysql_fetch_assoc($result);
$smarty->assign('user_info', $user_info);

if ($user_info['user_birth_date'] != '0000-00-00')
{
    $age = find_age($user_info['user_birth_date']);
    $smarty->assign('age', $age);
}

# increase view count
$sql = "UPDATE `users` SET
       `user_profile_viewed`=`user_profile_viewed`+1 WHERE
       `user_name`='" . mysql_clean($user_name) . "'";
mysql_query($sql) or mysql_die($sql);

# show latest user video
$sql = "SELECT * FROM `videos` WHERE
       `video_user_id`='" . (int) $user_info['user_id'] . "' AND
       `video_type`='public' AND
       `video_approve`='1' AND
       `video_active`='1'
        ORDER BY `video_id` DESC
        LIMIT 8";
$result = mysql_query($sql) or mysql_die($sql);
while ($new_video = mysql_fetch_assoc($result))
{
    $new_video['video_thumb_url'] = $servers[$new_video['video_thumb_server_id']];
    $new_videos[] = $new_video;
}

@mysql_free_result($result);

# show popular user video


$sql = "SELECT * FROM `videos` WHERE
       `video_user_id`='" . (int) $user_info['user_id'] . "' AND
       `video_type`='public' AND
       `video_approve`='1' AND
       `video_active`='1'
        ORDER BY `video_view_number` DESC
        LIMIT 8";
$result = mysql_query($sql) or mysql_die($sql);
while ($popular_video = mysql_fetch_assoc($result))
{
    $popular_video['video_thumb_url'] = $servers[$popular_video['video_thumb_server_id']];
    $popular_videos[] = $popular_video;
}

@mysql_free_result($result);

# show user friends


$sql = "SELECT * FROM `friends` WHERE
       `friend_user_id`='" . (int) $user_info['user_id'] . "' AND
       `friend_status`='Confirmed'
        ORDER BY `friend_invite_date` DESC
        LIMIT 8";
$result = mysql_query($sql) or mysql_die($sql);
$user_friends = mysql_fetch_all($result);
$smarty->assign('user_friends', $user_friends);

$chkuserflag = '';

if (checklogin())
{
    $chkuserflag = 'guest';
}

if (isset($_SESSION['UID']) && $_SESSION['UID'] == $user_info['user_id'])
{
    $chkuserflag = 'self';
}

if ($config['enable_package'] == 'yes' and isset($_SESSION['UID']))
{
    $sql = "SELECT * FROM `subscriber` WHERE
           `UID`='" . (int) $user_info['user_id'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $u_info = mysql_fetch_assoc($result);
    $smarty->assign('u_info', $u_info);
    
    $sql = "SELECT * FROM `packages` WHERE
           `package_id`='" . (int) $u_info['pack_id'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $pack = mysql_fetch_assoc($result);
    $smarty->assign('pack', $pack);
}

$photo_url = User::get_photo($user_info['user_photo'], $user_info['user_id']);

if (isset($_SESSION['UID']))
{
    $sql = "SELECT * FROM `friends` WHERE
           `friend_user_id`='" . (int) $_SESSION['UID'] . "' AND
           `friend_name`='" . mysql_clean($user_name) . "' AND
           `friend_status`='Confirmed'";
    $result = mysql_query($sql) or mysql_die($sql);
    
    if (mysql_num_rows($result) > 0)
    {
        $is_friend = 'yes';
    }
    else
    {
        $is_friend = 'no';
    }
    
    $smarty->assign('is_friend', $is_friend);
}

$sql = "SELECT g.*, gm.group_member_group_id FROM
       `groups` AS g,`group_members` AS gm WHERE
        gm.group_member_group_id=g.group_id AND
        gm.group_member_user_id='" . (int) $user_info['user_id'] . "'
        ORDER BY g.group_create_time DESC
        LIMIT 8";
$result = mysql_query($sql) or mysql_die($sql);
$num_result = mysql_num_rows($result);
$groups = mysql_fetch_all($result);
$smarty->assign('groups', $groups);

if ($user_info['user_style'] == '')
{
    $user_css = '/css/profile/default.css';
}
else
{
    $user_css = '/css/profile/' . $user_info['user_style'] . '.css';
}

$html_head_extra = '<link href="' . IMG_CSS_URL . '/css/profile.css" rel="stylesheet" type="text/css" />' . '<link href="' . IMG_CSS_URL . $user_css . '" rel="stylesheet" type="text/css" />';

$html_extra = '
<script type="text/javascript">
    var user_id = ' . $user_info['user_id'] . ';
    $(function(){
        display_user_comments(1);
    });
</script>

<script type="text/javascript" src="' . VSHARE_URL . '/js/user_comment.js"></script>
<script type="text/javascript" src="' . VSHARE_URL . '/js/user_comment_display.js"></script>
<script type="text/javascript" src="' . VSHARE_URL . '/js/user_rate.js"></script>';

$smarty->assign('html_head_extra', $html_head_extra);
$smarty->assign('html_extra', $html_extra);
$smarty->assign('photo_url', $photo_url);
$smarty->assign('chkuserflag', $chkuserflag);
$smarty->assign('html_title', $user_name);
$smarty->assign('html_keywords', $user_name);
$smarty->assign('html_description', $user_name);

if (isset($profile_comments))
{
    $smarty->assign('profile_comments', $profile_comments);
}

if (isset($new_videos))
{
    $smarty->assign('new_video', $new_videos);
    $smarty->assign('new_video_total', count($new_videos));
    $smarty->assign('videos', $new_videos);
    $smarty->assign('popular', $popular_videos);
    $smarty->assign('popular_total', count($popular_videos));
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);

if ($err == '')
{
    $smarty->assign('sub_menu', 'menu_user.tpl');
}

$smarty->display('header.tpl');

if ($err == '') $smarty->display('user.tpl');
$smarty->display('footer.tpl');
db_close();
