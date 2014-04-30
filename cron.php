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

$current_folder = dirname(__FILE__);

chdir("$current_folder");

require $current_folder . '/include/config.php';
require $current_folder . '/include/youtube.php';

$sql = "SELECT * FROM `process_queue` WHERE
       `status`='0'";
$downloads = DB::fetch($sql);
$num_downloads = count($downloads);

$sql = "SELECT * FROM `process_queue` WHERE
       `status`='2'";
$process = DB::fetch($sql);
$num_process = count($process);

$cron = get_config('cron');

echo 'cronjob started<br />';

if ($cron == 1) {

    $cron = 0;

    if ($num_downloads > 0) {
        $video_info = mysql_fetch_assoc($downloads);
        $video_id = $video_info['id'];
        Upload::downloadVideo($video_id);
    } else if ($num_process > 0) {
        $video_info = mysql_fetch_assoc($process);
        $video_id = $video_info['id'];
        Upload::processVideo($video_id);
    }
} else {

    $cron = 1;

    if ($num_process > 0) {
        $video_info = mysql_fetch_assoc($process);
        $video_id = $video_info['id'];
        Upload::processVideo($video_id);
    } else if ($num_downloads > 0) {
        $video_info = mysql_fetch_assoc($downloads);
        $video_id = $video_info['id'];
        Upload::downloadVideo($video_id);
    }
}

$sql = "UPDATE `config` SET
       `config_value`='" . (int) $cron . "' WHERE
       `config_name`='cron'";
DB::query($sql);
DB::close();
