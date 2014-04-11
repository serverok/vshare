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
require '../include/language/' . LANG . '/lang_admin_user_search.php';

check_admin_login();

if (isset($_GET['userid']) || isset($_GET['user_name']) || isset($_GET['user_ip']))
{

    if ($_GET['userid'] != null)
    {
        if (is_numeric($_GET['userid']))
        {
            $sql = "SELECT * FROM `users` WHERE
                   `user_id`='" . (int) $_GET['userid'] . "'";
            $result = mysql_query($sql) or mysql_die($sql);

            if (mysql_num_rows($result) == 0)
            {
                $err = str_replace('[USER_ID]', $_GET['userid'], $lang['userid_not_found']);
            }
            else
            {
                $redirect_url = VSHARE_URL . '/admin/user_view.php?user_id=' . $_GET['userid'];
                redirect($redirect_url);
            }
        }
        else
        {
            $err = $lang['userid_invalid'];
        }
    }
    else if ($_GET['user_name'] != null)
    {
        $sql = "SELECT `user_id` FROM `users` WHERE
               `user_name`='" . mysql_clean($_GET['user_name']) . "'";
        $result = mysql_query($sql) or mysql_die($sql);

        if (mysql_num_rows($result) == 0)
        {
            $err = str_replace('[USERNAME]', $_GET['user_name'], $lang['user_name_not_found']);
        }
        else
        {
            $user = mysql_fetch_assoc($result);
            $redirect_url = VSHARE_URL . '/admin/user_view.php?user_id=' . $user['user_id'];
            redirect($redirect_url);
        }
    }
    else if ($_GET['user_ip'] != null)
    {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        if ($page < 1)
        {
            $page = 1;
        }

        if (! empty($_GET['sort']))
        {
            $query = " ORDER BY " . mysql_clean($_GET['sort']);
        }
        else
        {
            $query = " ORDER BY `user_id` DESC";
        }

        $sql = "SELECT count(*) AS `total` FROM `users` WHERE
               `user_ip`='" . mysql_clean($_GET['user_ip']) . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        $tmp = mysql_fetch_array($result);
        $total = $tmp['total'];

        $admin_listing_per_page = get_config('admin_listing_per_page');
        $start_from = ($page - 1) * $admin_listing_per_page;

        require 'Pager/Pager.php';
        require 'Pager/Sliding.php';

        $params = array();
        $params['mode'] = 'Sliding';
        $params['perPage'] = $admin_listing_per_page;
        $params['linkClass'] = 'pager';
        $params['delta'] = 2;
        $params['totalItems'] = $total;
        $params['urlVar'] = 'page';

        $pager = new Pager_Sliding($params);
        $data = $pager->getPageData();
        $links = $pager->getLinks();

        $sql = "SELECT * FROM `users` WHERE
               `user_ip`='" . mysql_clean($_GET['user_ip']) . "'
                $query
                LIMIT $start_from, $admin_listing_per_page";
        $result = mysql_query($sql) or mysql_die($sql);
        $users = mysql_fetch_all($result);

        $smarty->assign('links', $links['all']);
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
db_close();