<?php

ini_set("max_execution_time", "30000");

require '../include/config.php';

$video_duration_cmd = get_config('video_duration_cmd');
$t_info = array();
$debug =0;

$sql = "SELECT * FROM `videos` WHERE
       `video_vtype`='0' AND
       `video_thumb_server_id`='2'";
$videos_all = DB::fetch($sql);

foreach ($videos_all as $video_info) {
    VideoThumb::createVideoThumb($video_info['video_id']);
}

echo '<p>Done</p>';
