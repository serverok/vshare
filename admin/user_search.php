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
require '../include/language/' . LANG . '/admin/user_search.php';

Admin::auth();

if (isset($_GET['userid']) || isset($_GET['user_name']) || isset($_GET['user_ip'])) {

    if ($_GET['userid'] != null) {

        if (is_numeric($_GET['userid'])) {
            $user_info = User::getById($_GET['userid']);

            if (! $user_info) {
                $err = str_replace('[USER_ID]', $_GET['userid'], $lang['userid_not_found']);
            } else {
                $redirect_url = VSHARE_URL . '/admin/user_view.php?user_id=' . $_GET['userid'];
                Http::redirect($redirect_url);
            }
        } else {
            $err = $lang['userid_invalid'];
        }
    } else if ($_GET['user_name'] != null) {
        $user_info = User::getByName($_GET['user_name']);
        if (! $user_info) {
            $err = str_replace('[USERNAME]', $_GET['user_name'], $lang['user_name_not_found']);
        } else {
            $redirect_url = VSHARE_URL . '/admin/user_view.php?user_id=' . $user_info['user_id'];
            Http::redirect($redirect_url);
        }
    } else if ($_GET['user_ip'] != null) {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        if ($page < 1) {
            $page = 1;
        }

        if (! empty($_GET['sort'])) {
            $query = " ORDER BY " . DB::quote($_GET['sort']);
        } else {
            $query = " ORDER BY `user_id` DESC";
        }

        $sql = "SELECT count(*) AS `total` FROM `users` WHERE
               `user_ip` LIKE '%" . DB::quote($_GET['user_ip']) . "%'";
        $total = DB::getTotal($sql);

        $admin_listing_per_page = Config::get('admin_listing_per_page');
        $start_from = ($page - 1) * $admin_listing_per_page;

        $links = Paginate::getLinks2($total, $admin_listing_per_page, '', $page);

        $sql = "SELECT * FROM `users` WHERE
               `user_ip` LIKE '%" . DB::quote($_GET['user_ip']) . "%'
                $query
                LIMIT $start_from, $admin_listing_per_page";
        $users = DB::fetch($sql);

        $smarty->assign('links', $links);
        $smarty->assign('total', $total + 0);
        $smarty->assign('page', $page + 0);
        $smarty->assign('users', $users);
    }
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/user_search.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
