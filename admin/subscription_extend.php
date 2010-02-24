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
require '../include/language/' . LANG . '/lang_admin_subscription_extend.php';

check_admin_login();

if (isset($_POST['submit']))
{
    
    $duration = $_POST['duration'];
    $duration_type = $_POST['duration_type'];
    
    if ($duration == '')
    {
        $err = $lang['duration_null'];
    }
    else if (! is_numeric($duration))
    {
        $err = $lang['duration_numeric'];
    }
    else if ($duration_type == '')
    {
        $err = $lang['duration_type_null'];
    }
    else
    {
        $period = "$duration $duration_type";
        
        /* Specific Users  */
        
        if ($_POST['extend_for'] == 'specific_user')
        {
            $user_name = trim($_POST['username']);
            
            if ($user_name == '')
            {
                $err = $lang['user_name_null'];
            }
            else
            {
                $extend = extend_subscription($user_name, $period);
                
                if ($extend == 1)
                {
                    $msg = str_replace('[USERNAME]', $user_name, $lang['specific_user_ok']);
                }
                else if ($extend == 2)
                {
                    $err = $lang['user_name_not_found'];
                }
            }
        
        }
        else if ($_POST['extend_for'] == 'expired_users')
        {
            
            $sql = "SELECT * FROM
                   `subscriber` AS s,
                   `users` AS u WHERE
                    s.UID=u.user_id";
            $result = mysql_query($sql) or mysql_die($sql);
            
            $user_list = '';
            
            while ($myobj = mysql_fetch_object($result))
            {
                $pack_id = $myobj->pack_id;
                $my_expired_time = $myobj->expired_time;
                $user_name = $myobj->user_name;
                
                // check for expired users
                if (strtotime($my_expired_time) < strtotime(date('Y-m-d H:i:s')))
                {
                    $extend = extend_subscription($user_name, $period);
                    $user_list .= $user_name . '<br />';
                }
            }
            
            $msg = str_replace('[USER_LIST]', $user_list, $lang['expired_users_ok']);
        
        }
        else if ($_POST['extend_for'] == 'all_users')
        {
            
            $sql = "SELECT * FROM `users`";
            $result = mysql_query($sql) or mysql_die($sql);
            
            while ($myobj = mysql_fetch_object($result))
            {
                $user_name = $myobj->user_name;
                $extend = extend_subscription($user_name, $period);
            }
            
            if ($extend == 1)
            {
                $msg = $lang['all_users_ok'];
            }
        }
    }
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/subscription_extend.tpl');
$smarty->display('admin/footer.tpl');

##############################################  FUNCTIONS #############################################


function extend_subscription($user_name, $period)
{
    global $conn;
    $sql_user_name = mysql_clean($user_name);
    $sql = "SELECT `user_id` FROM `users` WHERE
           `user_name`='$sql_user_name'";
    $result = mysql_query($sql) or mysql_die($sql);
    
    if (mysql_num_rows($result))
    {
        $myobj = mysql_fetch_object($result);
        $user_id = $myobj->user_id;
        
        $sql = "SELECT * FROM `subscriber` WHERE
               `UID`=$user_id";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result))
        {
            $subscription = mysql_fetch_object($result);
            $my_pack_id = $subscription->pack_id;
            $my_expired_time = $subscription->expired_time;
            
            if ($my_pack_id != 0)
            {
                
                # check if expired
                if (strtotime($my_expired_time) < strtotime(date('Y-m-d H:i:s')))
                {
                    $new_expired_time = date('Y-m-d H:i:s', strtotime("+$period"));
                }
                else
                {
                    $new_expired_time = strtotime($my_expired_time);
                    $i = strtotime("+$period", $new_expired_time);
                    $new_expired_time = date('Y-m-d H:i:s', $i);
                }
                
                $sql = "UPDATE `subscriber` SET `expired_time`='$new_expired_time' WHERE
                       `UID`=$user_id";
                $result = mysql_query($sql) or mysql_die($sql);
                
                $return = 1; //Subscription Extended For User: $user_name<br />Expiry Date: $new_expired_time
            

            }
            else
            {
                $sql = "SELECT * FROM `packages` WHERE
                       `package_trial`='yes'";
                $result = mysql_query($sql) or mysql_die($sql);
                $pack_obj = mysql_fetch_object($result);
                $pack_id = $pack_obj->pack_id;
                $subscribe_time = date('Y-m-d H:i:s');
                $new_expired_time = date('Y-m-d H:i:s', strtotime("+$period"));
                
                $sql = "UPDATE `subscriber` SET
                       `pack_id`='$pack_id',
                       `subscribe_time`='$subscribe_time',
                       `expired_time`='$new_expired_time' WHERE
                       `UID`=$user_id";
                $result = mysql_query($sql) or mysql_die($sql);
                $return = 1; // Subscription Extended For User: $user_name
            }
        
        }
        else
        {
            
            $sql = "SELECT * FROM `packages` WHERE
                   `package_trial`='yes'";
            $result = mysql_query($sql) or mysql_die($sql);
            $myobj = mysql_fetch_object($result);
            $pack_id = $myobj->pack_id;
            
            $subscribe_time = date('Y-m-d H:i:s');
            $new_expired_time = date('Y-m-d H:i:s', strtotime("+$period"));
            
            $sql = "INSERT INTO `subscriber` SET
                   `UID`=$user_id,
                   `pack_id`=$pack_id,
                   `subscribe_time`='$subscribe_time',
                   `expired_time`='$new_expired_time'";
            $result = mysql_query($sql) or mysql_die($sql);
            $return = 1; // Subscription Extended
        }
    }
    else
    {
        $return = 2; // user not found
    }
    
    return $return;
}

db_close();
