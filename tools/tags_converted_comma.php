<?php

require '../include/config.php';

//video
$sql = "SELECT `video_id`,`video_keywords` FROM `videos`";
$result = mysql_query($sql) or mysql_die($sql);

while ( $video_info = mysql_fetch_assoc($result) )
{
    $new_video_keywords = str_replace(' ', ',', $video_info['video_keywords']);
    $sql = "UPDATE `videos` SET
           `video_keywords`='$new_video_keywords' WHERE
           `video_id`=" . $video_info['video_id'];
    mysql_query($sql) or mysql_die($sql);
}

//groups
$sql = "SELECT `group_id`,`group_keyword` FROM `groups`";
$result = mysql_query($sql) or mysql_die($sql);

while ( $group_info = mysql_fetch_assoc($result) )
{
    $new_group_keyword = str_replace(' ', ',', $group_info['group_keyword']);
    $sql = "UPDATE `groups` SET
           `group_keyword`='$new_group_keyword' WHERE
           `group_id`='" . (int) $group_info['group_id'] . "'";
    mysql_query($sql) or mysql_die($sql);
}

