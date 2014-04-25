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

User::is_logged_in();

$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$add_list = isset($_GET['add_list']) ? $_GET['add_list'] : '';
$add_list = trim($add_list);

if ($add_list != '') {
    Friend::add('users', 'user_friends_type', 'user_id=' . (int) $_SESSION['UID'], $add_list);
    Http::redirect(VSHARE_URL . '/friends/');
}

if (isset($_GET['del_list'])) {
    Friend::remove('users', 'user_friends_type', 'user_id=' . (int) $_SESSION['UID'], $_GET['del_list']);
    $sql = "SELECT `friend_friend_id` FROM `friends` WHERE
           `friend_user_id`='" . (int) $_SESSION['UID'] . "'";
    $result = DB::fetch($sql);
    foreach ($resul as $tmp) {
        Friend::remove('friends', 'friend_type', 'friend_id=' . $tmp['friend_friend_id'], $_GET['del_list']);
    }
    Http::redirect(VSHARE_URL . '/friends/');
}

if (isset($_POST['action_name'])) {
    if ($_POST['action_name'] == 'delete') {
        while (list($k, $v) = @each($_POST['AID'])) {
            $sql = "DELETE FROM `friends` WHERE
                   `friend_id`='" . (int) $v . "'";
            DB::query($sql);
        }
        Http::redirect(VSHARE_URL . '/friends/');
    } else {
        $sql = "SELECT `user_friends_type` FROM `users` WHERE
               `user_id`='" . (int) $_SESSION['UID'] . "'";
        $friends_tmp = DB::fetch1($sql);
        $type = explode('|', $friends_tmp['user_friends_type']);
        $cmd = explode('_', $_POST['action_name']);

        if ($cmd[0] == 'add' && is_numeric($cmd[1])) {
            while (list($k, $v) = @each($_POST['AID'])) {
                Friend::add('friends', 'friend_type', 'friend_id=' . (int) $v, $type[$cmd[1]]);
            }
        } else if ($cmd[0] == 'delete' && is_numeric($cmd[1])) {
            while (list($k, $v) = @each($_POST['AID'])) {
                Friend::remove('friends', 'friend_type', 'friend_id=' . (int) $v, $type[$cmd[1]]);
            }
        }
        Http::redirect(VSHARE_URL . '/friends/');
    }
}

if (isset($_GET['view']) && $_GET['view'] != 'All') {
    $query = "AND `friend_type` LIKE '%" . mysql_clean($_GET['view']) . "%'";
} else {
    $query = '';
}

if (isset($_GET['sort']) && $_GET['sort'] == 'name') {
    $sort = "ORDER BY `friend_name`";
} else {
    $sort = "ORDER BY `friend_invite_date` DESC";
}

$sql = "SELECT count(*) AS `total` FROM `friends` WHERE
       `friend_user_id`='" . (int) $_SESSION['UID'] . "'
        $query";
$total = DB::getTotal($sql);

$page_links = paginate($total, $config['items_per_page'], '.', '', $page);

$start_from = ($page - 1) * $config['items_per_page'];
$start = $start_from + 1;
$last = ($start_from + $config['items_per_page'] > $total) ? $total : $start_from + $config['items_per_page'];
$link = "<b>$start - $last of $total</b>&nbsp;&nbsp;";

$sql = "SELECT DISTINCT * FROM `friends` WHERE
       `friend_user_id`='" . (int) $_SESSION['UID'] . "' $query $sort
        LIMIT $start_from, $config[items_per_page]";
$friends = DB::fetch($sql);
$total = count($friends);

$smarty->assign('friends', $friends);
$smarty->assign('total', $total);

$sql = "SELECT DISTINCT * FROM `friends` WHERE
       `friend_user_id`='" . (int) $_SESSION['UID'] . "'";
$result = DB::fetch($sql);
$total_friends = count($result);

$smarty->assign('total_friends', $total_friends);

$sql = "SELECT `user_friends_type` FROM `users` WHERE
       `user_id`='" . (int) $_SESSION['UID'] . "'";
$friends_type = DB::fetch1($sql);

$ftype = explode('|', $friends_type['user_friends_type']);
sort($ftype);

$ftype_ops = '';

for ($i = 0; $i < count($ftype); $i ++) {
    if ($ftype[$i] != '') {
        if (isset($_GET['view']) && $_GET['view'] == $ftype[$i]) {
            $sel = 'selected';
        } else {
            $sel = '';
        }
        $ftype_ops .= "<option value='" . $ftype[$i] . "' $sel>" . $ftype[$i] . "</option>";
    }
}

$smarty->assign('ftype_ops', $ftype_ops);

$type = explode('|', $friends_type['user_friends_type']);
$type = array_splice($type, 1 - count($type));
$action_ops = '<option value="" selected="selected">--- Select Action ---</option>' . '<option disabled="disabled">Add to list:</option>';

for ($i = 0; $i < count($type); $i ++) {
    if (trim($type[$i]) != '') {
        $action_ops .= '<option value="add_' . ($i + 1) . '">&nbsp;&nbsp;&nbsp;&nbsp;' . $type[$i] . '</option>';
    }
}

$action_ops .= '<option disabled="disabled">delete from list:</option>';

for ($i = 0; $i < count($type); $i ++) {
    if (trim($type[$i]) != '') {
        $action_ops .= "<option value='delete_" . ($i + 1) . "'>&nbsp;&nbsp;&nbsp;&nbsp;$type[$i]</option>";
    }
}

$action_ops .= '<option value="delete">Delete Selected</option>';

$smarty->assign('action_ops', $action_ops);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('page_links', $page_links);
$smarty->assign('sub_menu', 'menu_friends.tpl');
$smarty->display('header.tpl');
$smarty->display('friends.tpl');
$smarty->display('footer.tpl');
DB::close();
