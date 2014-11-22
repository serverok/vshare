<?php
/******************************************************************************
 *
 * COMPANY: BuyScripts.in
 * PROJECT: vShare Youtube Clone
 * VERSION: [VSHARE_VERSION]
 * LICENSE: http://buyscripts.in/vshare-license
 * WEBSITE: http://buyscripts.in/vshare-youtube-clone
 *
 * This program is a commercial software and any kind of using it must agree
 * to vShare license.
 *
 ******************************************************************************/

require '../include/config.php';

Admin::auth();

$smarty->assign('vshare_version', $vshare_version);

# number of videos
$sql = "SELECT count(*) AS `total` FROM `videos` WHERE
       `video_active`='1'";
$total_video = DB::getTotal($sql);
$smarty->assign('total_video', $total_video);

# number of public videos
$sql = "SELECT count(*) AS `total` FROM `videos` WHERE
       `video_active`='1' AND
       `video_type`='public'";
$total_public_video = DB::getTotal($sql);
$smarty->assign('total_public_video', $total_public_video);

# number of private videos
$sql = "SELECT count(*) AS `total` FROM `videos` WHERE
       `video_active`='1' AND
       `video_type`='private'";
$total_private_video = DB::getTotal($sql);
$smarty->assign('total_private_video', $total_private_video);

# number of users
$sql = "SELECT count(*) AS `total` FROM `users`";
$total_users = DB::getTotal($sql);
$smarty->assign('total_users', $total_users);

# number of channels
$sql = "SELECT count(*) AS `total` FROM `channels`";
$total_channel = DB::getTotal($sql);
$smarty->assign('total_channel', $total_channel);

# number of groups
$sql = "SELECT count(*) AS `total` FROM `groups`";
$total_groups = DB::getTotal($sql);
$smarty->assign('total_groups', $total_groups);

# check version
$version_file = VSHARE_DIR . '/templates_c/version.txt';

if (file_exists($version_file)) {
    $last_check = filemtime($version_file);
    $time_now = $_SERVER['REQUEST_TIME'];
    $time_since_last_chek = ($time_now - $last_check) / (60 * 60);
    if ($time_since_last_chek > 48) {
        $check_version_now = 1;
    } else {
        $check_version_now = 0;
    }
} else {
    $check_version_now = 1;
}

$errno = 0;

if ($check_version_now == 1) {
    $errstr = '';
    $version_info = '';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://buyscripts.in/vshare/version.txt');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    $version_info = curl_exec($ch);
    curl_close($ch);

    $fp = fopen($version_file, 'w');
    fwrite($fp, $version_info);
    fclose($fp);
}

unset($version_info);

$version_info = file($version_file);

if (sizeof($version_info) == 2) {
    $latest_version = trim($version_info[0]);
    $latest_release = $version_info[1];
} else {
    $latest_version = 2;
    $latest_release = 2;
}

$smarty->assign('latest_version', $latest_version);
$smarty->assign('latest_release', $latest_release);

if ($errno == 0 && strlen($latest_version) > 2) {
    if ($vshare_version < $latest_version) {
        $smarty->assign('vshare_status', 'old');
    } else {
        $smarty->assign('vshare_status', 'new');
    }
}

$smarty->display('admin/header.tpl');
$smarty->display('admin/home.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
