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
require 'include/language/' . LANG . '/lang_friend_accept.php';

User::is_logged_in();

if (isset($_GET['id']) && (is_numeric($_GET['key'])))
{
    $id = base64_decode($_GET['id']);
    $key = $_GET['key'];
    
    $sql = "SELECT * FROM `verify_code` WHERE
           `id`='" . (int) $id . "' AND
           `vkey`='" . mysql_clean($key) . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    
    if (mysql_num_rows($result) == 1)
    {
        $tmp = mysql_fetch_assoc($result);
        $fid = $tmp['data1'];
        
        $sql = "SELECT * FROM `friends` WHERE
               `friend_id`='" . (int) $fid . "'";
        $result = mysql_query($sql) or mysql_die();
        $tmp = mysql_fetch_assoc($result);
        $invite_for = $tmp['friend_friend_id'];
        
        if ($_SESSION['UID'] == $tmp['friend_user_id'])
        {
            
            $sql = "DELETE FROM `friends` WHERE
                    `friend_id`='$fid'";
            mysql_query($sql) or mysql_die($sql);
            
            set_message('You cannot invite yourself as a friend', 'error');
            $redirect_url = VSHARE_URL . '/friends.php';
            redirect($redirect_url);
        }
        
        if (empty($invite_for))
        {
            $sql = "UPDATE `friends` SET
                   `friend_friend_id`='" . (int) $_SESSION['UID'] . "',
                   `friend_name`='" . mysql_clean($_SESSION['USERNAME']) . "' WHERE
                   `friend_id`='" . (int) $fid . "'";
            mysql_query($sql) or mysql_die($sql);
        }
        else
        {
            if ($invite_for != $_SESSION['UID'])
            {
                set_message($lang['invitation_is_not_for_you'], 'error');
                $redirect_url = VSHARE_URL . '/friend_accept.php';
                redirect($redirect_url);
            }
        }
        
        $smarty->assign('AID', $fid);
        $smarty->assign('id', $id);
        $smarty->assign('UID', $tmp['friend_user_id']);
        $smarty->assign('user_name', User::get_user_name_by_id($tmp['friend_user_id']));
    }
    else
    {
        $err = $lang['invalid_invite_key'];
    }
}

# accept friend request


if (isset($_POST['friend_accept']) && $_POST['friend_accept'] != '')
{
    
    $id = $_POST['id'];
    $fid = $_POST['AID'];
    
    if ((! is_numeric($id)) || (! is_numeric($fid)))
    {
        exit();
    }
    
    $sql = "SELECT * FROM `verify_code` WHERE
           `id`='" . (int) $id . "' AND
           `data1`='" . (int) $fid . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    
    if (mysql_num_rows($result) == 1)
    {
        
        $sql = "SELECT * FROM `friends` WHERE
               `friend_id`=" . (int) $fid . " AND
               `friend_status`='Pending'";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result) == 1)
        {
            $tmp = mysql_fetch_assoc($result);
            $friend_id = $tmp['friend_user_id'];
            
            $sql = "SELECT * FROM `users` WHERE
                   `user_id`='" . (int) $friend_id . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            $tmp = mysql_fetch_assoc($result);
            $friend_user_name = $tmp['user_name'];
            
            $sql = "UPDATE `friends` SET
                   `friend_friend_id`='" . (int) $_SESSION['UID'] . "',
                   `friend_name`='" . mysql_clean($_SESSION['USERNAME']) . "',
                   `friend_status`='Confirmed' WHERE
                   `friend_id`='" . (int) $fid . "'";
            mysql_query($sql) or mysql_die($sql);
            
            $sql = "INSERT INTO `friends` SET
                   `friend_user_id`='" . (int) $_SESSION['UID'] . "',
                   `friend_friend_id`='" . (int) $friend_id . "',
                   `friend_name`='" . mysql_clean($friend_user_name) . "',
                   `friend_type`='All|Friends',
                   `friend_invite_date`='" . date("Y-m-d") . "',
                   `friend_status`='Confirmed'";
            mysql_query($sql) or mysql_die($sql);
            
            $sql = "DELETE FROM `verify_code` WHERE
                   `id`='" . (int) $id . "'";
            mysql_query($sql) or mysql_die($sql);
            set_message($lang['friend_added'], 'success');
            $redirect_url = VSHARE_URL . '/index.php';
            redirect($redirect_url);
        }
    
    }
    else
    {
        $err = $lang['invalid_add_request'];
    }
}

# deny friend request


if (isset($_POST['friend_deny']) && $_POST['friend_deny'] != '')
{
    $id = $_POST['id'];
    $fid = $_POST['AID'];
    $sql = "DELETE FROM `verify_code` WHERE
           `id`='" . (int) $id . "'";
    mysql_query($sql) or mysql_die($sql);
    $sql = "DELETE FROM `friends` WHERE
           `friend_id`='" . (int) $fid . "'";
    mysql_query($sql) or mysql_die($sql);
    set_message($lang['friend_deny'], 'success');
    $redirect_url = VSHARE_URL . '/index.php';
    redirect($redirect_url);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('friend_accept.tpl');
$smarty->display('footer.tpl');
db_close();
