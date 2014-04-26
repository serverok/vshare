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

check_admin_login();

if (isset($_POST['submit'])) {
    for ($i = 0; $i < count($_POST['delete_log']); $i ++) {
        $sql = "DELETE FROM `admin_log` WHERE
			   `admin_log_id`='" . (int) $_POST['delete_log'][$i] . "'";
        DB::query($sql);
    }
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if (isset($_GET['delete_all'])) {
    $sql = "DELETE FROM `admin_log`";
    DB::query($sql);
    $page = 1;
}

DB::close();

if ($page < 1) {
    $page = 1;
}

$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

$redirect_url = VSHARE_URL . '/admin/admin_log.php?page=' . $page . '&sort=' . $sort;
Http::redirect($redirect_url);
