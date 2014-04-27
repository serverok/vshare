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

$group_url = isset($_GET['group_url']) ? $_GET['group_url'] : '';
$group_url = htmlspecialchars_uni($group_url);

if (check_field_exists($group_url, 'group_url', 'groups') == 0)
{
    Http::redirect(VSHARE_URL);
}

$smarty->assign('group_url', $group_url);

$topic_id = isset($_GET['topic_id']) ? (int) $_GET['topic_id'] : 0;

if (($topic_id < 1) || (! check_field_exists($topic_id, 'group_topic_id', 'group_topics')))
{
    $redirect_url = VSHARE_URL . '/group/' . $group_url . '/';
    Http::redirect($redirect_url);
}

$smarty->assign('group_topic_id', $topic_id);

if (isset($_POST['add_topic']) && isset($_SESSION['UID']))
{
    $topic_title = (isset($_POST['topic_title'])) ? $_POST['topic_title'] : '';
    $topic_title = htmlspecialchars_uni($topic_title);
    
    if ($topic_title != '')
    {
        $sql = "INSERT `group_topic_posts` SET
               `group_topic_post_topic_id`='" . (int) $_GET['topic_id'] . "',
               `group_topic_post_user_id`='" . (int) $_SESSION['UID'] . "',
               `group_topic_post_date`='" . $_SERVER['REQUEST_TIME'] . "',
               `group_topic_post_description`='" . DB::quote($topic_title) . "',
               `group_topic_post_video_id`='" . (int) $_POST['topic_video'] . "'";
        mysql_query($sql) or mysql_die($sql);
    }
    
    $redirect_url = VSHARE_URL . '/group/' . $group_url . '/topic/' . (int) $_GET['topic_id'];
    Http::redirect($redirect_url);

}

$sql = "SELECT * FROM `groups` WHERE
       `group_url`='" . DB::quote($group_url) . "'";
$result = mysql_query($sql) or mysql_die($sql);
$group_info = mysql_fetch_assoc($result);
$group_id = $group_info['group_id'];

$smarty->assign('group_info', $group_info);

$sql = "SELECT * FROM `group_topics` WHERE
       `group_topic_id`='" . (int) $_GET['topic_id'] . "'";
$result = mysql_query($sql) or mysql_die($sql);
$topic = mysql_fetch_assoc($result);

if ($topic['group_topic_video_id'] != 0)
{
    $sql = "SELECT video_folder,video_thumb_server_id FROM `videos` WHERE
			`video_id`=" . $topic['group_topic_video_id'];
    $result = mysql_query($sql) or mysql_die($sql);
    $tmp = mysql_fetch_assoc($result);
    $topic['video_folder'] = $tmp['video_folder'];
    $topic['video_thumb_url'] = $servers[$tmp['video_thumb_server_id']];

}

$smarty->assign('topic', $topic);

$sql = "SELECT * FROM `group_topic_posts` WHERE
       `group_topic_post_topic_id`='" . (int) $_GET['topic_id'] . "'
        ORDER BY `group_topic_post_id` ASC";
$result = mysql_query($sql) or mysql_die($sql);

while ($tmp = mysql_fetch_assoc($result))
{
    if ($tmp['group_topic_post_video_id'] != 0)
    {
        $sql = "SELECT video_folder,video_thumb_server_id FROM `videos` WHERE
				`video_id`=" . $tmp['group_topic_post_video_id'];
        $result_1 = mysql_query($sql) or mysql_die($sql);
        $tmp_1 = mysql_fetch_assoc($result_1);
        $tmp['video_folder'] = $tmp_1['video_folder'];
        $tmp['video_thumb_url'] = $servers[$tmp_1['video_thumb_server_id']];
    }
    
    $post[] = $tmp;
}

$smarty->assign('post', $post);
$smarty->assign('total_post', count($post));

if (isset($_SESSION['UID']))
{
    $sql = "SELECT `video_id`,`video_title` FROM `videos` WHERE
           `video_user_id`='" . (int) $_SESSION['UID'] . "' AND
           `video_approve`='1' AND
           `video_active`='1'
            ORDER BY `video_id` DESC";
    $result = mysql_query($sql) or mysql_die($sql);
    
    $video_ops = '<option value="" selected>- Your Videos -</option>';
    while ($tmp = mysql_fetch_assoc($result))
    {
        $video_ops .= '<option value=' . $tmp['video_id'] . '>' . $tmp['video_title'] . '</option>';
    }
    
    $smarty->assign('video_ops', $video_ops);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('sub_menu', 'menu_group_members.tpl');
$smarty->display('header.tpl');
$smarty->display('group_posts.tpl');
$smarty->display('footer.tpl');
db_close();
