<?php
/******************************************************************************
 *
 * COMPANY: BuyScripts.in
 * PROJECT: vShare Youtube Clone
 * VERSION: [VSHARE_VERSION]
 * LISENSE: http://buyscripts.in/vshare-license.html
 * WEBSITE: http://buyscripts.in/youtube_clone.html
 *
 * This program is a commercial software and any kind of using it must agree
 * to vShare license.
 *
 ******************************************************************************/

require 'include/config.php';
require 'include/functions_file.php';

$count_real_video_views = 1;

$id = isset($_GET['id']) ? $_GET['id'] : '';

$sql = "SELECT * FROM `videos` WHERE
       `video_id`='" . (int) $id . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) > 0)
{
    $video_info = mysql_fetch_assoc($result);
    
    if ($count_real_video_views == 1)
    {
        $user_ip = User::get_ip();
        $time = $_SERVER['REQUEST_TIME'];
        $time_x_min_ago = $time - 86400; # 1 day
        

        $sql = "SELECT * FROM `view_log` WHERE
               `view_log_video_id`='" . (int) $id . "' AND
               `view_log_ip`='" . mysql_clean($user_ip) . "' AND
               `view_log_time` > '" . mysql_clean($time_x_min_ago) . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result) == 0)
        {
            $sql = "UPDATE `videos` SET
                   `video_view_number`=`video_view_number`+1,
                   `video_view_time`='" . mysql_clean($_SERVER['REQUEST_TIME']) . "' WHERE
                   `video_id`='" . (int) $id . "'";
            mysql_query($sql) or mysql_die($sql);
        }
        
        $sql = "INSERT INTO `view_log` SET
               `view_log_video_id`='" . (int) $id . "',
               `view_log_ip`='" . mysql_clean($user_ip) . "',
               `view_log_time`='" . mysql_clean($_SERVER['REQUEST_TIME']) . "'";
        mysql_query($sql) or mysql_query($sql);
    }
    else
    {
        $sql = "UPDATE `videos` SET
               `video_view_number`=`video_view_number`+1,
               `video_view_time`='" . mysql_clean($_SERVER['REQUEST_TIME']) . "' WHERE
               `video_id`='" . (int) $id . "'";
        mysql_query($sql) or mysql_die($sql);
    }
}

if ($video_info['video_server_id'] > 0)
{
    $url = get_file_url($video_info['video_server_id'], $video_info['video_folder'], $video_info['video_flv_name']);
}
else
{
    $url = VSHARE_URL . '/flvideo/' . $video_info['video_folder'] . $video_info['video_flv_name'];
}

header('content-type:text/xml;charset=utf-8');
echo '<playlist version="1" xmlns="http://xspf.org/ns/0/">';
echo '<trackList>';
echo '<track>';
echo '<title>' . $video_info['video_title'] . '</title>';
echo '<location>' . $url . '</location>';
echo '<image>' . $servers[$video_info['video_thumb_server_id']] . '/thumb/' . $video_info['video_folder'] . $id . '.jpg</image>';
echo '</track>';
echo '</trackList>';
echo '</playlist>';
db_close();
