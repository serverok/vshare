<?php

ini_set("max_execution_time", "30000");

require '../include/config.php';
require '../include/class.video_thumb.php';
require '../include/class.video_duration.php';
require '../include/class.ftp.php';
require '../include/functions_video_thumb.php';

$video_duration_cmd = get_config('video_duration_cmd');
$t_info = array();
$debug =0;

$sql = "SELECT * FROM `videos` WHERE
       `video_vtype`='0' AND
       `video_thumb_server_id`='2'";
$result = mysql_query($sql) or mysql_die($sql);

while ($video_info = mysql_fetch_assoc($result))
{
    create_video_thumb($video_info['video_id']);    
}

echo '<p>Done</p>';