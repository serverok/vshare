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
require '../include/language/' . LANG . '/lang_admin_settings_home.php';

check_admin_login();

if (isset($_POST['submit']))
{
    $sql = "UPDATE `sconfig` SET
           `svalue`='" . mysql_clean($_POST['user_poll']) . "' WHERE
           `soption`='user_poll'";
    $result = mysql_query($sql) or mysql_die($sql);
    $smarty->assign('user_poll', $_POST['user_poll']);
    
    if (is_numeric($_POST['home_num_tags']))
    {
        $sql = "UPDATE `config` SET
               `config_value` ='" . (int) $_POST['home_num_tags'] . "' WHERE
               `config_name`='home_num_tags'";
        mysql_query($sql) or mysql_die($sql);
    }
    
    if (is_numeric($_POST['num_last_users_online']))
    {
        $sql = "UPDATE `config` SET
               `config_value`='" . (int) $_POST['num_last_users_online'] . "' WHERE
               `config_name`='num_last_users_online'";
        mysql_query($sql) or mysql_die($sql);
    }
    
    if (is_numeric($_POST['num_new_videos']))
    {
        $sql = "UPDATE `sconfig` SET
               `svalue`='" . (int) $_POST['num_new_videos'] . "' WHERE
               `soption`='num_new_videos'";
        mysql_query($sql) or mysql_die($sql);
        $smarty->assign('num_new_videos', $_POST['num_new_videos']);
    }
    
    if (is_numeric($_POST['recently_viewed_video']))
    {
        $sql = "UPDATE `sconfig` SET
               `svalue`='" . (int) $_POST['recently_viewed_video'] . "' WHERE
               `soption`='recently_viewed_video'";
        mysql_query($sql) or mysql_die($sql);
        $smarty->assign('recently_viewed_video', $_POST['recently_viewed_video']);
    }
    
    $sql = "UPDATE `sconfig` SET
           `svalue`='" . (int) $_POST['show_stats'] . "' WHERE
           `soption`='show_stats'";
    mysql_query($sql) or mysql_die($sql);
    $smarty->assign('show_stats', $_POST['show_stats']);
    
    $msg = $lang['settings_updated'];
}

$smarty->assign('home_num_tags', get_config('home_num_tags'));
$smarty->assign('num_last_users_online', get_config('num_last_users_online'));
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/settings_home.tpl');
$smarty->display('admin/footer.tpl');
db_close();
