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

$video_id = isset($_GET['video_id']) ? (int) $_GET['video_id'] : 0;

if ($video_id == 0)
{
    echo "invalid video id";
    exit();
}

$sql = "SELECT * FROM `videos` WHERE
       `video_id`='$video_id'";
$result = mysql_query($sql) or mysql_die($sql);
$video_info = mysql_fetch_assoc($result);

$video_thumb_url = $servers[$video_info['video_thumb_server_id']];
$logo = IMG_CSS_URL . '/images/watermark.gif';
$image = $video_thumb_url . '/thumb/' . $video_info['video_folder'] . '/' . $video_id . '.jpg';

$file_url = 'file=' . VSHARE_URL . '/xml_playlist.php?id=' . $video_info['video_id'];

$video_flv_player = VSHARE_URL . '/player/player.swf?';
$video_flv_player .= $file_url;
$video_flv_player .= '&logo=' . $logo;

$sql = "UPDATE `videos` SET `video_view_number`=`video_view_number`+1 WHERE `video_id`=$video_id";
$result = mysql_query($sql);

header('Content-Type: video/flv');
Header("Location: $video_flv_player");
