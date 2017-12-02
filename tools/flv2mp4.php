<?php

$current_folder = dirname(__FILE__);

require $current_folder . '/include/config.php';

if (php_sapi_name()  != "cli") {
    echo "<pre>";
}

print_log(date('Y-m-d H:i:s'));

$lock_file = $current_folder . '/flv2mp4_processing.lock';

if (file_exists($lock_file)) {
    print_log('ERROR: another video conversion running. Please try later.');
    exit();
}

$sql = "SELECT `video_id`,`video_name`,`video_flv_name`,`video_folder` FROM `videos`
        WHERE `video_flv_name` LIKE '%.flv' AND `flv2mp4`='0'
        ORDER BY `video_id` DESC
        LIMIT 1";
$video = DB::fetch1($sql);

if (! $video) exit();

print_log('Convert Video ID = ' . $video['video_id']);

$sql = "UPDATE `videos` SET `flv2mp4`='1' WHERE `video_id`='" . $video['video_id'] . "'";
DB::query($sql);

$video_src = $current_folder . '/flvideo/' . $video['video_flv_name'];

if (! file_exists($video_src)) {
    $email_body = '';
    $email_body .= '<p>ID: ' . $video['video_id'] . '</p>';
    $email_body .= '<p>Source: ' . $video_src . '</p>';

    sendMail('Source video not found.', $email_body);

    print_log('Source not found: ' . $video_src);
    exit;
}

$sourceVideoSize = filesize($video_src);

print_log("FLV = $video_src (size = " . bytes2MB($sourceVideoSize) . "MB)");

if (! touch($lock_file)) {
    print_log('Lock file creation failed: ' . $lock_file);
    exit();
}

$output_video_name = str_replace('flv', 'mp4', $video['video_flv_name']);

$video_flv = $current_folder . '/flvideo/' . $output_video_name;

require $current_folder . '/include/settings/video_conversion.php';
$cmd_convert = $cmd_mp4;

print_log("$cmd_convert");

$tmp = exec($cmd_convert . " 2>&1", $exec_result);

$outputVideoSize = filesize($video_flv);

print_log('MP4 = '. $video_flv . ' (size = ' . bytes2MB($outputVideoSize) . 'MB)');

$filesizeDeference = findDeference($sourceVideoSize, $outputVideoSize);

print_log('File size deference = ' . $filesizeDeference . '%');

$allowedSizeChangePercentage = 60;

if ($filesizeDeference > $allowedSizeChangePercentage) {
    $email_body = '';
    $email_body .= '<p>ID: ' . $video['video_id'] . '</p>';
    $email_body .= '<p>Source: ' . $video_src . ': ' . bytes2MB($sourceVideoSize) . 'MB</p>';
    $email_body .= '<p>Output: ' . $video_flv . ': ' . bytes2MB($outputVideoSize) . 'MB</p>';
    $email_body .= '<p>Conversion failed as output file size is too small.</p>';

    sendMail('Conversion failed', $email_body);

    print_log('ERROR: mp4 and flv file size diff more than ' . $allowedSizeChangePercentage . '%.');
    print_log('');

    unlink($lock_file);
    if (!isset($_GET["force"])) {
        exit;
    }
}

Media::mp4Metadata($output_video_name, '', '', 0);

$sql = "UPDATE `videos` SET `video_flv_name`='$output_video_name' WHERE `video_id`='" . $video['video_id'] . "'";
DB::query($sql);

print_log($sql);

$video_processed_path = $current_folder . '/flvideo-processed';
$videoDestination = $video_processed_path . '/' . $video['video_flv_name'];

if (!rename($video_src, $videoDestination)) {
    print_log("ERROR: failed to move $video_src to $videoDestination");
    exit;
}

unlink($lock_file);

$videoUrl = 'https://www.adult-share.net/view/' . $video['video_id'] . '/1/';
print_log('Done. URL = ' . $videoUrl);
print_log("-------------------------------------------------");

function print_log($string='') {
    echo "$string \n";
}

function bytes2MB($size) {
    $sizeKB = $size/1024;
    return round($sizeKB/1024, 2);
}

function findDeference($x, $y) {
    $d = $y/$x*100;
    return round(100 - $d, 2);
}

function sendMail($subject, $body) {
    global $config;

    $msg = array();
    $msg['from_email'] = $config['admin_email'];
    $msg['from_name'] = $config['site_name'];
    $msg['to_email'] = 'suneesh@hostonnet.com';
    $msg['to_name'] = 'Suneesh';
    $msg['subject'] = $subject;
    $msg['body'] = $body;
    $mail = new Mail();
    $mail->send($msg);
}


