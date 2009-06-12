<?php
/******************************************************************************
 *
 *   COMPANY: BuyScripts.in
 *   PROJECT: vShare Youtube Clone
 *   VERSION: 2.7
 *   LISENSE: http://buyscripts.in/vshare-license.html
 *   WEBSITE: http://buyscripts.in/youtube_clone.html
 *
 *   This program is a commercial software and any kind of using it must agree 
 *   to vShare license.
 *
 ******************************************************************************/

require '../include/config.php';
require '../include/language/' . LANG . '/lang_admin_subscription_edit.php';

check_admin_login();

if (isset($_POST['todo']))
{
    $todo = $_POST['todo'];
}
else
{
    $todo = 'get_username';
}

if (isset($_POST['edit']))
{
    $user_name = $_POST['username'];
    
    if ($user_name == '')
    {
        $err = $lang['user_name_null'];
    }
    else
    {
        $sql = "SELECT * FROM `users` WHERE
               `user_name`='" . mysql_clean($user_name) . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        $num_result = mysql_num_rows($result);
        
        if ($num_result == 1)
        {
            $tmp = mysql_fetch_assoc($result);
            $user_id = $tmp['user_id'];
        }
        else
        {
            $err = $lang['user_not_found'];
        }
    }
    
    if ($err == '')
    {
        $todo = "show_edit_form";
        $sql = "SELECT * FROM `packages`";
        $result = mysql_query($sql) or mysql_die($sql);
        
        while ($tmp = mysql_fetch_assoc($result))
        {
            $packages[] = $tmp["package_name"];
        }
        
        $sql = "SELECT * FROM `subscriber` WHERE
               `UID`=$user_id";
        $result = mysql_query($sql) or mysql_die($sql);
        $subscriber_info = mysql_fetch_assoc($result);
        $expired_time = $subscriber_info['expired_time'];
        $pack_id = $subscriber_info['pack_id'];
        $used_space = $subscriber_info['used_space'];
        $total_video = $subscriber_info['total_video'];
        
        $sql = "SELECT `package_name` FROM `packages` WHERE
               `package_id`='" . (int) $pack_id . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        $tmp = mysql_fetch_assoc($result);
        $pack_name = $tmp['package_name'];
        
        $year = date("Y", strtotime($expired_time));
        $month = date("m", strtotime($expired_time));
        $date = date("d", strtotime($expired_time));
        
        $year_expire = date('Y');
        
        for ($y = $year_expire; $y <= $year_expire + 10; $y ++)
        {
            $expire_year[] = $y;
        }
        
        for ($m = 1; $m <= 12; $m ++)
        {
            $expire_month[] = $m;
        }
        
        for ($d = 1; $d <= 30; $d ++)
        {
            $expire_date[] = $d;
        }
        
        $smarty->assign('uid', $user_id);
        $smarty->assign('expire_year', $expire_year);
        $smarty->assign('year', $year);
        $smarty->assign('expire_month', $expire_month);
        $smarty->assign('month', $month);
        $smarty->assign('expire_date', $expire_date);
        $smarty->assign('date', $date);
        $smarty->assign('expired_time', $expired_time);
        $smarty->assign('packages', $packages);
        $smarty->assign('pack_name', $pack_name);
        $smarty->assign('username', $user_name);
        $smarty->assign('used_space', $used_space);
        $smarty->assign('total_video', $total_video);
    }

}
else if (isset($_POST['save_subscription']))
{
    $new_expired_time = $_POST['expire_year'] . '-' . $_POST['expire_month'] . '-' . $_POST['expire_date'] . ' 00:00:00';
    $sql_pack_name = mysql_clean($_POST['package']);
    $sql = "SELECT `package_id` FROM `packages` WHERE
           `package_name`='$sql_pack_name'";
    $result = mysql_query($sql) or mysql_die($sql);
    $myobj = mysql_fetch_object($result);
    $pack_id = $myobj->package_id;
    
    $sql = "UPDATE `subscriber` SET `pack_id`=$pack_id,
           `expired_time`='$new_expired_time',
           `used_space`='" . (float) $_POST['used_space'] . "',
           `total_video`='" . (int) $_POST['total_video'] . "' WHERE
           `UID`='" . (int) $_POST['uid'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $todo = 'saved';
    $smarty->assign('new_expired_time', $new_expired_time);
    $smarty->assign('username', $_POST['username']);
    $smarty->assign('package', $_POST['package']);
}

$smarty->assign('todo', $todo);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/subscription_edit.tpl');
$smarty->display('admin/footer.tpl');
db_close();
