<?php 

require '../include/config.php';
require '../include/class.tags.php';

$sql = "SELECT * FROM `videos` WHERE 
		`video_type`='public'";
$result = mysql_query($sql) or die($sql);

while ($video_row = mysql_fetch_assoc($result)) 
{
	$video_id = $video_row['video_id'];
	$video_keywords = $video_row['video_keywords'];
	$video_title = $video_row['video_title'];
	$video_description = $video_row['video_description'];
	$video_channels = $video_row['video_channels'];
	$video_user_id = $video_row['video_user_id'];
	
	$tags = new Tags($video_keywords,$video_id,$video_user_id,$video_channels);
	echo "<p>Tags Delete($video_keywords,$video_id,$video_user_id,$video_channels)</p>";
	$tags->delete();
	unset($tags);
	
	if (mb_strlen($video_title)>20)
	{
		$video_title = preg_replace('/\s+/', ',', $video_title);
	}
	
	if (mb_strlen($video_description)>20)
	{
		$video_description = preg_replace('/\s+/', ',', $video_description);
	}
	
	$video_keywords_all = $video_keywords . ',' . $video_title . ',' . $video_description;
	$tags = new Tags($video_keywords_all,$video_id,$video_user_id,$video_channels);
	echo "<p>Tags Add($video_keywords_all,$video_id,$video_user_id,$video_channels)</p>";
	$tags->add();
}

echo '<h1>' . Finished . '</h1>';
