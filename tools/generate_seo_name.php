<?php
include('../include/config.php');

$sql = "SELECT `video_title`,`video_id` FROM `videos`";
$result = DB::query($sql);

while($video = mysqli_fetch_assoc($result)) {
	$seo_name = Url::seoName($video['video_title']);
	$sql = "UPDATE `videos` SET `video_seo_name`='" . DB::quote($seo_name) . "' WHERE
           `video_id`='" . (int) $video['video_id'] ."'";
	DB::query($sql);
}

?>
