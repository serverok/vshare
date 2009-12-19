<?php
/******************************************************************************
 *
 *   COMPANY: BuyScripts.in
 *   PROJECT: vShare Youtube Clone
 *   VERSION: 2.8
 *   LISENSE: http://buyscripts.in/vshare-license.html
 *   WEBSITE: http://buyscripts.in/youtube_clone.html
 *
 *   This program is a commercial software and any kind of using it must agree 
 *   to vShare license.
 *
 ******************************************************************************/

require '../include/config.php';
require '../include/class.mail.php';
require '../include/class.validate.php';
require '../include/language/' . LANG . '/lang_admin_mail_users.php';

check_admin_login();

if (isset($_POST['submit']))
{
    if (get_magic_quotes_gpc())
    {
        $_POST['htmlCode'] = stripslashes($_POST['htmlCode']);
        $_POST['subj'] = stripslashes($_POST['subj']);
    }
    
    if ($_GET['a'] == 'user')
    {
        if ($_POST['UID'] == "0" || $_POST['UID'] == '')
        {
            $err = $lang['select_user'];
        }
        else if ($_POST['subj'] == '')
        {
            $err = $lang['subject_null'];
        }
        else if ($_POST['htmlCode'] == '')
        {
            $err = $lang['message_null'];
        }
        else
        {
            if ($_POST['UID'] == 'All')
            {
                $sql = "SELECT `user_email` FROM `users` WHERE
                       `user_account_status`='Active'";
                $result = mysql_query($sql) or mysql_die($sql);
                
                while ($tmp = mysql_fetch_assoc($result))
                {
                    mail2user($tmp['user_email'], $config['site_name'], $config['admin_email'], $_POST['subj'], $_POST['htmlCode']);
                }
                
                set_message($lang['mail_all_ok'], 'success');
                $redirect_url = VSHARE_URL . '/admin/mail_users.php?a=user';
                redirect($redirect_url);
            
            }
            else
            {
                $sql = "SELECT `user_name`, `user_email` FROM `users` WHERE
                       `user_id`='" . (int) $_POST['UID'] . "'";
                $result = mysql_query($sql) or mysql_die($sql);
                $tmp = mysql_fetch_assoc($result);
                mail2user($tmp['user_email'], $config['site_name'], $config['admin_email'], $_POST['subj'], $_POST['htmlCode']);
                $msg = str_replace('[USERNAME]', $tmp['user_name'], $lang['mail_user_ok']);
                set_message($msg, 'success');
                $redirect_url = VSHARE_URL . '/admin/mail_users.php?a=user';
                redirect($redirect_url);
            }
        }
    
    }
    else if ($_GET['a'] == 'group')
    {
        
        if (isset($_POST['GID']) && $_POST['GID'] == '0' || $_POST['GID'] == '')
        {
            $err = $lang['select_group'];
        }
        else if ($_POST['subj'] == '')
        {
            $err = $lang['subject_null'];
        }
        else if ($_POST['htmlCode'] == '')
        {
            $err = $lang['message_null'];
        }
        else
        {
            $sql = "SELECT `group_name` FROM `groups` WHERE
                   `group_id`='" . (int) $_POST['GID'] . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            $tmp = mysql_fetch_assoc($result);
            $group_name = $tmp['group_name'];
            
            $sql = "SELECT `group_member_user_id` FROM `group_members` WHERE
                   `group_member_group_id`='" . (int) $_POST['GID'] . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            
            while ($tmp = mysql_fetch_assoc($result))
            {
                $member_ids[] = $tmp['group_member_user_id'];
            }
            
            $sql = "SELECT `user_email` FROM `users` WHERE
                   `user_id` in (" . implode(', ', $member_ids) . ")";
            $result = mysql_query($sql) or mysql_die($sql);
            
            while ($tmp = mysql_fetch_assoc($result))
            {
                mail2user($tmp['user_email'], $config['site_name'], $config['admin_email'], $_POST['subj'], $_POST['htmlCode']);
            }
            
            $msg = str_replace("[GROUPNAME]", $group_name, $lang['mail_group_ok']);
            set_message($msg, 'success');
            $redirect_url = VSHARE_URL . '/admin/mail_users.php?a=group';
            redirect($redirect_url);
        }
    
    }
    else
    {
        
        if ($_POST['email'] == '')
        {
            $err = $lang['email_null'];
        }
        else if (! validate::email($_POST['email']))
        {
            $err = $lang['email_invalid'];
        }
        else if ($_POST['subj'] == '')
        {
            $err = $lang['subject_null'];
        }
        else if ($_POST['htmlCode'] == '')
        {
            $err = $lang['message_null'];
        }
        
        if ($err == '')
        {
            mail2user($_POST['email'], $config['site_name'], $config['admin_email'], $_POST['subj'], $_POST['htmlCode']);
            $msg = str_replace("[EMAIL]", $_POST['email'], $lang['mail_ok']);
            set_message($msg, 'success');
            $redirect_url = VSHARE_URL . '/admin/mail_users.php?email=' . $email . '&uname=' . $uname;
            redirect($redirect_url);
        }
    }
}

if (isset($_GET['a']) && $_GET['a'] == 'user')
{
    $sql = "SELECT `user_id`, `user_name` FROM `users` WHERE
           `user_account_status`='Active'
           ORDER BY `user_name`";
    $result = mysql_query($sql) or mysql_die($sql);
    $user_ops = "<option value='0'>-- Select a user --</option>";
    
    while ($tmp = mysql_fetch_assoc($result))
    {
        if (isset($_POST['UID']) && $_POST['UID'] == $tmp['user_id'])
        {
            $sel = "selected";
        }
        else
        {
            $sel = '';
        }
        $user_ops .= "<option value='" . $tmp['user_id'] . "' $sel>" . $tmp['user_name'] . "</option>";
    }
    
    $user_ops .= "<option value='All'>(Send to All)</option>";
    
    $smarty->assign('user_ops', $user_ops);

}
else if (isset($_GET['a']) && $_GET['a'] == 'group')
{
    
    $sql = "SELECT `group_id`, `group_name` FROM `groups` ORDER BY `group_name`";
    $result = mysql_query($sql) or mysql_die($sql);
    
    $group_ops = "<option value='0'>-- Select a group --</option>";
    
    while ($tmp = mysql_fetch_assoc($result))
    {
        if (isset($_POST['GID']) && $_POST['GID'] == $tmp['group_id'])
        {
            $sel = "selected";
        }
        else
        {
            $sel = "";
        }
        
        $group_ops .= "<option value='" . $tmp['group_id'] . "' $sel>" . $tmp['group_name'] . "</option>";
    }
    
    $smarty->assign('group_ops', $group_ops);
}

function mail2user($email, $site_name, $admin_email, $subj, $htmlCode)
{
    $mail_detailes = array();
    $mail_detailes['from_email'] = $admin_email;
    $mail_detailes['from_name'] = $site_name;
    $mail_detailes['to_email'] = $email;
    $mail_detailes['to_name'] = "";
    $mail_detailes['subject'] = $subj;
    $mail_detailes['body'] = $htmlCode;
    $mail = new Mail();
    $mail->send($mail_detailes);
}

$smarty->assign('msg', $msg);
$smarty->assign('err', $err);
$smarty->display('admin/header.tpl');
$smarty->display('admin/mail_users.tpl');
$smarty->display('admin/footer.tpl');
db_close();
