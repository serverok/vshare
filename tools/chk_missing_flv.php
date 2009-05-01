<?php

include("../include/config.php");
$dir = "/home/video/public_html/flvideo/";

$video_ok = 0;
$video_nf = 0;

$sql = "SELECT * FROM `videos`";
$result = mysql_query($sql);
while($videoinfo = mysql_fetch_assoc($result)){
	$VID = $videoinfo['video_id'];
	$video_flv_name = $videoinfo['video_flv_name'];
	$filename = $dir . $video_flv_name;

	if (file_exists($filename)) {
	    echo "The file $filename exists<br />";
	    $video_ok++;
	} else {
	    echo "<font color=red>The file $filename does not exist</font><br />";
	    $video_nf++;
	}

}

echo "Total video : " . mysql_num_rows($result) . "<br />";
echo "Video Found $video_ok <br />";
echo "Video Missing: $video_nf <br />";

