<?php

require("../include/config.php");

$uid = '1';
$channel = "0|11|16|22|0";
$new_line = "<br />";

$sql = "SELECT * FROM `import_video`";

$result = DB::query($sql);

$total = mysqli_num_rows($result);
echo "Totial Videos: $total" . $new_line . $new_line;

while($myobj = mysqli_fetch_object($result)) {

$video_id = $myobj->VID;
$video_title = DB::quote($myobj->title);
$video_keyword = DB::quote($myobj->keyword);
$video_description = DB::quote($myobj->description);
$video_src = $myobj->video_flv_name;

echo "Importing Video: $video_id => $myobj->title" . $new_line;


$video_src_path = VSHARE_DIR . '/templates_c/video_import/' . $video_src;

if (file_exists($video_src_path))
{

	$upfile_size =filesize($video_src_path);
	$upfile_size = round($upfile_size/(1024*1024));

	$sql = "INSERT INTO `videos` SET
           `video_user_id`='$uid',
           `video_title`='$video_title',
           `video_description`='$video_description',
           `video_keywords`='$video_keyword',
           `video_channels`='$channel',
           `video_space`='$upfile_size',
           `video_add_time`='".time()."',
           `video_add_date`='".date("Y-m-d")."',
           `video_type`='public',
           `video_active`=1";

	DB::query($sql);
	$vid = DB::insertGetId($sql);

	copy($video_src_path,VSHARE_DIR . '/flvideo/' . $vid . '.flv');
	copy($video_src_path,VSHARE_DIR . '/video/' . $vid . '.flv');

	$mov = new ffmpeg_movie($video_src_path);
	$duration = $mov->getDuration();
	video_to_frame($video_src_path,$vid,&$mov,$channel);

	$flv_name = $vid. '.flv';

	$sql = "UPDATE `videos` SET
           `video_name`='$flv_name',
           `video_flv_name`='$flv_name',
           `video_duration`='$duration' WHERE
           `video_id`='$vid'";
	DB::query($sql);
	$sql="DELETE FROM `import_video` WHERE `VID`='$video_id'";
	DB::query($sql);
	if(!unlink($video_src_path)) {
		echo "Unable to delete the file: $video_src_path";
		exit(0);
	}

} else {

	echo "$video_src_path ** NOT FOUND ** $new_line";

}

}

echo "$new_line $new_line Finished $new_line $new_line";


?>
