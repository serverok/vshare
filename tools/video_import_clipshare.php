<?php

$username = "bizhat";
$channel = "0|3|0";

/*

Works with : vshare 2.6

To import video from clipshare, backup clipshare database.
Delete everything from the sql file other than sql for table
video.

Rename the video table to "import_video" in table structure and in insert statements.

backup vshare database.

Import the "import_video" table to your vshare database, you can delete it after import finished.

Put all flv files from clipshare flvideos folder to templates_c/import folder.

*/

require("../include/config.php");
require("../include/functions_seo_name.php");
require("../include/class.tags.php");


$new_line = "<br />>";

$sql = "SELECT * FROM `import_video`";

$result = mysql_query($sql) or die ("Unable to execute query: $sql<br />>" . mysql_error());

echo "Totial Videos: " .  mysql_num_rows($result) . $new_line . $new_line;

while($myobj = mysql_fetch_object($result)) {

$video_id = $myobj->VID;
$video_title = $myobj->title;
$video_keywords = $myobj->keyword;
$video_description = $myobj->description;
$video_src = $myobj->video_flv_name;

echo "Importing Video: $video_id => $video_title" . $new_line;


$video_src_path = VSHARE_DIR . "/templates_c/import/$video_src";

if (file_exists($video_src_path)) {

	$upfile_size =filesize($video_src_path);
	$upfile_size = round($upfile_size/(1024*1024));

	$seo_name = $video_title;
	$seo_name_org = $seo_name;
	$i = 1;

	while(check_field_exists($seo_name,'seo_name','video')) {
		$seo_name = $seo_name_org . '-' . $i;
		$i++;
	}

	$file_name = basename($video_src);
	$pos = strrpos($file_name,".");
	$file_extn = strtolower(substr($file_name,$pos+1,strlen($file_name)-$pos));
	$file_no_extn = basename($file_name,".$file_extn");
	$file_no_extn = ereg_replace("[&$#]+"," ",$file_no_extn);
	$file_no_extn = ereg_replace("[ ]+","-",$file_no_extn);
	$file_name = $file_no_extn . "." . $file_extn;
	$file_path = VSHARE_DIR . "/video/" . $file_name;

	$i = 0;

	while(file_exists($file_path)){
		$i++;
		$file_name = $file_no_extn . "_" . $i . "." . $file_extn;
		$file_path = VSHARE_DIR . "/video/" . $file_name;
	}

	copy($video_src_path,$file_path);

	$sql = "INSERT INTO `process_queue` SET
           `file`='$file_name',
           `title`='" . mysql_clean($video_title) . "',
           `description`='" . mysql_clean($video_description) . "',
           `keywords`='" . mysql_clean($video_keywords) ."',
           `channels`='$channel',
           `type`='public',
           `user`='$username',
           `user_ip`='127.0.0.1',
           `status`=2";

	echo "<p>$sql</p>";

	$result_2 = mysql_query($sql) or die("Unable to execute query: $sql<br />>" . mysql_error());
	$vid = mysql_insert_id();

	$sql="DELETE FROM `import_video` WHERE `VID`=$video_id";
	$result_2 = mysql_query($sql) or die("Unable to execute query: $sql<br />>" . mysql_error());

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