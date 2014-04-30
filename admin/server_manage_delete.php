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

require '../include/config.php';
require '../include/language/' . LANG . '/lang_admin_server_manage_delete.php';

Admin::auth();

$serverId = isset($_GET['id']) ? $_GET['id'] : 0;

$sql = "SELECT * FROM `servers` WHERE
        `id`='" . (int) $serverId . "'";
$server_info = DB::fetch1($sql);

if (! $server_info) {
    $err = $lang['server_not_found'];
    set_message($err, 'error');
}

if ($err == '') {
    if ($server_info['server_type'] == 1) {
        $sql = "SELECT count(*) AS `total` FROM `videos` WHERE
    		   `video_thumb_server_id`='" . (int) $serverId . "'";
    } else {
        $sql = "SELECT count(*) AS `total` FROM `videos` WHERE
    		   `video_server_id`='" . (int) $serverId . "'";
    }

    $total_medias = DB::getTotal($sql);

    if ($total_medias == 0) {
        $sql = "DELETE FROM `servers` WHERE
                `id`='" . (int) $serverId . "'";
        DB::query($sql);
        $msg = $lang['server_deleted'];
    } else {
        if ($server_info['server_type'] == 1) {
            $msg = $lang['cannot_delete_thumb_server'];
        } else {
            $msg = $lang['cannot_delete_video_server'];
        }
    }
    set_message($msg, 'success');
}

DB::close();
$redirect_url = VSHARE_URL . '/admin/server_manage.php';
Http::redirect($redirect_url);
