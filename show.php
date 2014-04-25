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
require 'include/class.video_player.php';

if (! is_numeric($_GET['id'])) {
    echo "id must be numeric";
    exit(0);
}

$vid = $_GET['id'];

$sql = "SELECT * FROM `videos` WHERE
       `video_active`='1' AND
       `video_approve`='1' AND
       `video_id`='" . (int) $vid . "'";
$video_info = DB::fetch1($sql);

if ($video_info) {
    $video_id = $vid;
    $video_video_flv_name = $video_info['video_flv_name'];
    $player = new video_player();
    $vshare_player = $player->get_player_code($video_id);
} else {
    $err = 1;
}

$smarty->assign('err', $err);
$smarty->assign('VSHARE_PLAYER', $vshare_player);
$smarty->display('show.tpl');
DB::close();
