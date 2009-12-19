<?php
/******************************************************************************
 *
 *   COMPANY: BuyScripts.in
 *   PROJECT: vShare Youtube Clone
 *   VERSION: 2.8
 *   LISENSE: http://buyscripts.in/vshare-license.html
 *   WEBSITE: http://buyscripts.in/youtube_clone.html
 *
 *   This program is a commercial software and any kind of using it must agree 
 *   to vShare license.
 *
 ******************************************************************************/

require '../include/config.php';
require '../include/class.ftp.php';
require '../include/class.video.php';

check_admin_login();

$num_videos_per_refresh = 10;

$sql = "SELECT * FROM `videos` WHERE
	   `video_user_id`=0
	    ORDER BY `video_id` ASC
	    LIMIT $num_videos_per_refresh";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) > 0)
{
    while ($video = mysql_fetch_assoc($result))
    {
        Video::delete($video['video_id'], $video['video_user_id'], 1);
    }
    
    echo "<script language=\"JavaScript\">
         <!--
         var randomnumber = Math.random() * 1000000;
         document.write('Files Deleting...');
         setTimeout('window.location.href = \"?x=' + randomnumber + '\"',2000);
         -->
         </script>";
}
else
{
    echo "All Files Deleted.";
}