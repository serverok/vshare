<?php
include('../include/config.php');
include('../include/functions_seo_name.php');

$sql = "SELECT `video_title`,`video_id` FROM `videos`";
$result = mysql_query($sql);

while($video = mysql_fetch_assoc($result)) {
	$seo_name = seo_name($video['video_title']);
	$sql = "UPDATE `videos` SET `video_seo_name`='$seo_name' WHERE 
           `video_id`='" . $video['video_id'] ."'";
	mysql_query($sql);
}

?>