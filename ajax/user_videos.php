<?php

require '../include/config.php';

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';

if ($user_id == '')
{
	echo "Invalid user.";
	exit(0);
}

$sql = "SELECT `user_name` FROM `users` WHERE
	   `user_id`='" . (int) $user_id . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) == 0)
{
	exit(0);
}

$user_info = mysql_fetch_assoc($result);
$smarty->assign('user_name', $user_info['user_name']);

$sql = "SELECT count(*) AS `total` FROM `videos` WHERE
	   `video_user_id`='" . (int) $user_id . "' AND
	   `video_type`='public' AND
	   `video_active`='1' AND
	   `video_approve`='1'";
$result = mysql_query($sql) or mysql_die($sql);
$total = mysql_fetch_assoc($result);
$video_count = $total['total'];

$sql = "SELECT * FROM `videos` WHERE
	   `video_user_id`='" . (int) $user_id . "' AND
	   `video_type`='public' AND
	   `video_active`='1' AND
	   `video_approve`='1'
	    ORDER BY `video_id` DESC
	    LIMIT 15";
$result = mysql_query($sql) or mysql_die($sql);

if ($video_count > 0)
{
	while ($video = mysql_fetch_assoc($result))
	{
		$video['video_thumb_url'] = $servers[$video['video_thumb_server_id']];
		$user_videos[] = $video;
	}
	
	$smarty->assign('user_videos', $user_videos);
}

$smarty->assign('video_count', $video_count);
$smarty->display('user_videos_ajax.tpl');

