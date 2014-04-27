<?php

ini_set("max_execution_time", "30000");

require '../include/config.php';
require '../include/class.video_thumb.php';
require '../include/class.video_duration.php';
require '../include/functions_video_thumb.php';

$video_duration_cmd = get_config('video_duration_cmd');
$t_info = array();
$debug =0;

$sql = "SELECT * FROM `videos` WHERE
       `video_vtype`='0' AND
       `video_thumb_server_id`='2'";
$videos_all = DB::fetch($sql);

foreach ($videos_all as $video_info) {
    create_video_thumb($video_info['video_id']);
}

echo '<p>Done</p>';
