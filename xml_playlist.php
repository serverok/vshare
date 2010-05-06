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
    
    if ($video_info['video_server_id'] > 0)
    {
        $url = get_file_url($video_info['video_server_id'], $video_info['video_folder'], $video_info['video_flv_name']);
    }
    else if ($video_info['video_vtype'] == '7')
    {
        $url = $video_info['video_youtube_url'];
    }
    else
    {
        $url = VSHARE_URL . '/flvideo/' . $video_info['video_folder'] . $video_info['video_flv_name'];
    }
    
    header('content-type:text/xml;charset=utf-8');
    echo '<playlist version="1" xmlns="http://xspf.org/ns/0/">';
    echo '<tracklist>';
    echo '<track>';
    echo '<title>' . $video_info['video_title'] . '</title>';
    echo '<annotation>' . $video_info['video_description'] . '</annotation>';
    echo '<location>' . $url . '</location>';
    echo '<image>' . $servers[$video_info['video_thumb_server_id']] . '/thumb/' . $video_info['video_folder'] . $id . '.jpg</image>';
    echo '</track>';
    echo '</tracklist>';
    echo '</playlist>';
}

db_close();
