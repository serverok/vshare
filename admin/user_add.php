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
require '../include/class.validate.php';
require '../include/class.friends.php';
require '../include/language/' . LANG . '/lang_admin_user_add.php';

check_admin_login();

if (isset($_POST['submit'])) {
    if (strlen($_POST['user_name']) < 4) {
        $err = $lang['user_name_short'];
    } else if (disallow_user_names($_POST['user_name'])) {
        $err = $lang['user_name_reserved'];
    } else if (check_field_exists($_POST['user_name'], 'user_name', 'users') == 1) {
        $err = $lang['user_name_exist'];
    } else if (empty($_POST['user_email']) || ! validate::email($_POST['user_email'])) {
        $err = $lang['email_invalid'];
    } else if (check_field_exists($_POST['user_email'], "user_email", "users") == 1) {
        $err = $lang['email_exist'];
    } else if (strlen($_POST['user_password']) < 4) {
        $err = $lang['password_short'];
    }

    if ($err == '') {

        $request_password = $_POST['user_password'];
        $request_password = md5($request_password);

        $sql = "INSERT INTO `users` SET
               `user_email`='" . DB::quote($_POST['user_email']) . "',
               `user_name`='" . DB::quote($_POST['user_name']) . "',
               `user_password`='" . DB::quote($request_password) . "',
               `user_join_time`='" . $_SERVER['REQUEST_TIME'] . "',
               `user_last_login_time`='" . $_SERVER['REQUEST_TIME'] . "',
               `user_email_verified`='yes'";
        $user_id = DB::insertGetId($sql);

        if ($config['enable_package'] == 'yes') {

            $package_duration = (int) $_POST['user_package_duration'];
            $package_duration_type = $_POST['user_package_duration_type'];

            $sql = "SELECT * FROM `packages` WHERE
                   `package_id`='" . (int) $_POST['user_package_id'] . "'";
            $tmp = DB::fetch1($sql);

            $expired_time = date("Y-m-d H:i:s", strtotime("+ $package_duration $package_duration_type"));

            $sql = "INSERT INTO `subscriber` SET
                   `pack_id`='" . (int) $_POST['user_package_id'] . "',
                   `subscribe_time`='" . date("Y-m-d H:i:s") . "',
                   `expired_time`='$expired_time',
                   `UID`='" . (int) $user_id . "'";
            DB::query($sql);
        }

        $auto_friend = get_config('signup_auto_friend');

        if ((strlen($auto_friend) > 1) && (check_field_exists($auto_friend, 'user_name', 'users'))) {
            $friend = new Friends();
            $friend->make_friends($auto_friend, $_POST['user_name']);
        }

        set_message($lang['user_add_success'], 'success');
        $redirect_url = VSHARE_URL . '/admin/user_view.php?user_id=' . $user_id;
        Http::redirect($redirect_url);
    }
}

if ($config['enable_package'] == 'yes') {
    $sql = "SELECT * FROM `packages` WHERE
           `package_status`='Active'
            ORDER BY `package_price` DESC";
    $packages = DB::fetch($sql);
    $smarty->assign('package', $packages);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/user_add.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
