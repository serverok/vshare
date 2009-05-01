<?php
/******************************************************************************
 *
 *   COMPANY: BuyScripts.in
 *   PROJECT: vShare Youtube Clone
 *   VERSION: 2.7
 *   LISENSE: http://buyscripts.in/vshare-license.html
 *   WEBSITE: http://buyscripts.in/youtube_clone.html
 *
 *   This program is a commercial software and any kind of using it must agree 
 *   to vShare license.
 *
 ******************************************************************************/

require '../include/config.php';
require '../include/language/' . LANG . '/lang_admin_group_posts.php';

check_admin_login();

$TID = $_GET['TID'];
$gid = $_GET['gid'];

$sql = "SELECT `group_name` FROM `groups` WHERE
       `group_id`='" . (int) $gid . "'";
$result = mysql_query($sql) or mysql_die($sql);
$tmp = mysql_fetch_assoc($result);

$smarty->assign('group_name', $tmp['group_name']);

if (isset($_POST['update']))
{
    if ($_POST['title'] == '')
    {
        $err = $lang['title_null'];
    }
    else
    {
        $sql = "UPDATE `group_topics` SET
               `group_topic_title`='" . mysql_clean($_POST['title']) . "',
               `group_topic_approved`='" . mysql_clean($_POST['approved']) . "' WHERE
               `group_topic_id`=" . (int) $TID;
        mysql_query($sql) or mysql_die($sql);
        $redirect_url = VSHARE_URL . '/admin/group_posts.php?gid=' . $gid . '&TID=' . $TID;
        redirect($redirect_url);
    }
}

if (isset($_POST['pupdate']))
{
    if ($_POST['post'] == '')
    {
        $err = $lang['post_null'];
    }
    else
    {
        $sql = "UPDATE `group_topic_posts` SET
               `group_topic_post_description`='" . mysql_clean($_POST['post']) . "' WHERE
               `group_topic_post_id`=" . (int) $_GET['PID'];
        mysql_query($sql) or mysql_die($sql);
        $redirect_url = VSHARE_URL . '/admin/group_posts.php?gid=' . $gid . '&TID=' . $TID;
        redirect($redirect_url);
    }
}

if ((isset($_GET['action']) && $_GET['action'] == 'pdel') && (isset($_GET['PID']) && $_GET['PID'] != ''))
{
    $sql = "DELETE FROM `group_topic_posts` WHERE
           `group_topic_post_id`='" . (int) $_GET['PID'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $redirect_url = VSHARE_URL . '/admin/group_posts.php?gid=' . $gid . '&TID=' . $TID;
    redirect($redirect_url);
}

$sql = "SELECT * FROM `group_topics` WHERE
       `group_topic_id`='" . (int) $TID . "'";
$result = mysql_query($sql) or mysql_die($sql);
$topic = mysql_fetch_assoc($result);

if ($topic['group_topic_video_id'] != 0)
{
    $sql = "SELECT video_folder,video_thumb_server_id FROM `videos` WHERE
			`video_id`=" . $topic['group_topic_video_id'];
    $result = mysql_query($sql) or mysql_die($sql);
    $tmp = mysql_fetch_assoc($result);
    $topic['video_thumb_url'] = $servers[$tmp['video_thumb_server_id']];
    $topic['video_folder'] = $tmp['video_folder'];
}

$smarty->assign('topic', $topic);

$sql = "SELECT * FROM `group_topic_posts` WHERE
       `group_topic_post_topic_id`='" . (int) $TID . "'
        ORDER BY `group_topic_post_id` ASC";
$result = mysql_query($sql) or mysql_die($sql);

$posts = array();

while ($tmp = mysql_fetch_assoc($result))
{
    if ($tmp['group_topic_post_video_id'] != 0)
    {
        $sql = "SELECT video_folder,video_thumb_server_id FROM `videos` WHERE
				`video_id`=" . $tmp['group_topic_post_video_id'];
        $result_1 = mysql_query($sql) or mysql_die($sql);
        $tmp_1 = mysql_fetch_assoc($result_1);
        $tmp['video_thumb_url'] = $servers[$tmp_1['video_thumb_server_id']];
        $tmp['video_folder'] = $tmp_1['video_folder'];
    }
    
    $posts[] = $tmp;
}

$smarty->assign('post', $posts);
$smarty->assign('total_post', count($posts));

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/group_posts.tpl');
$smarty->display('admin/footer.tpl');
db_close();
