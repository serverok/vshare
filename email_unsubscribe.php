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

$vkey = isset($_GET['vkey']) ? $_GET['vkey'] : 0;
$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';

if (! empty($vkey) && ! empty($user_name))
{
    $sql = "SELECT `user_id` FROM `users` WHERE
           `user_name`='" . mysql_clean($user_name) . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    
    if (mysql_num_rows($result) == 1)
    {
        $user_info = mysql_fetch_assoc($result);
        
        $data1 = 'UNSUBSCRIBE_' . $user_info['user_id'];
        
        $sql = "SELECT * FROM `verify_code` WHERE
               `vkey`='" . mysql_clean($vkey) . "' AND
               `data1`='" . mysql_clean($data1) . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result) == 1)
        {
            $sql = "UPDATE `users` SET `user_subscribe_admin_mail`='0' WHERE
                   `user_id`='" . $user_info['user_id'] . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            
            $sql = "DELETE FROM `verify_code` WHERE
                   `vkey`='" . mysql_clean($vkey) . "' AND
                   `data1`='" . mysql_clean($data1) . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            
            $msg = 'You have successfully unsubscribed.';
            set_message($msg, 'success');
            
            redirect(VSHARE_URL);
        }
    }
}

$err = 'Invalid authentication code';
set_message($err, 'error');

redirect(VSHARE_URL);
