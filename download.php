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
require 'include/class.video.php';

if ($config['allow_download'] != 1)
{
    echo 'Video download disabled';
    exit();
}

User::is_logged_in();

$video_info = Video::get_video_info($_GET['video_id']);
$video_name = $video_info['video_name'];

$file_path = VSHARE_DIR . '/video/' . $video_name;

if (($video_name == '') || (! is_file($file_path)) || (! file_exists($file_path)))
{
    echo 'File not found.';
    exit();
}

if (ini_get('zlib.output_compression'))
{
    ini_set('zlib.output_compression', 'Off');
}

header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private', false);
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . basename($video_name) . '";');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($video_name));
readfile("$file_path");
exit();
