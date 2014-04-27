<?php

require '../include/config.php';

//video
$sql = "SELECT `video_id`,`video_keywords` FROM `videos`";
$videos_all = DB::fetch($sql);

foreach ($videos_all as $video_info) {
    $new_video_keywords = str_replace(' ', ',', $video_info['video_keywords']);
    $sql = "UPDATE `videos` SET
           `video_keywords`='$new_video_keywords' WHERE
           `video_id`=" . $video_info['video_id'];
    DB::query($sql);
}

//groups
$sql = "SELECT `group_id`,`group_keyword` FROM `groups`";
$groups_all = DB::fetch($sql);

foreach ($groups_all as $group_info) {
    $new_group_keyword = str_replace(' ', ',', $group_info['group_keyword']);
    $sql = "UPDATE `groups` SET
           `group_keyword`='$new_group_keyword' WHERE
           `group_id`='" . (int) $group_info['group_id'] . "'";
    DB::query($sql);
}
