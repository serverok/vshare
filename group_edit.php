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

require 'include/config.php';
require 'include/class.channels.php';
require 'include/language/' . LANG . '/lang_group_edit.php';

User::is_logged_in();

if (isset($_POST['submit']))
{
    $_POST['group_name'] = htmlspecialchars_uni($_POST['group_name']);
    $_POST['group_name'] = trim($_POST['group_name']);
    $_POST['group_keyword'] = strip_tags($_POST['group_keyword']);
    $_POST['group_keyword'] = trim($_POST['group_keyword']);
    $_POST['group_description'] = htmlspecialchars_uni($_POST['group_description']);
    $_POST['group_description'] = trim($_POST['group_description']);
    
    if ($_POST['group_name'] == '')
    {
        $err = $lang['group_name_empty'];
    }
    else if (strlen($_POST['group_name']) < 2)
    {
        $err = $lang['group_name_short'];
    }
    else if ($_POST['group_keyword'] == '')
    {
        $err = $lang['group_tags_empty'];
    }
    else if ($_POST['group_description'] == '')
    {
        $err = $lang['group_description_empty'];
    }
    
    $group_type_all = array(
        'public',
        'protected',
        'private'
    );
    
    if (! in_array($_POST['group_type'], $group_type_all))
    {
        $_POST['group_type'] = 'public';
    }
    
    $group_options_all = array(
        'immediate',
        'owner_approve',
        'owner_only'
    );
    
    if (! in_array($_POST['group_upload'], $group_options_all))
    {
        $_POST['group_upload'] = 'immediate';
    }
    
    if (! in_array($_POST['group_posting'], $group_options_all))
    {
        $_POST['group_posting'] = 'immediate';
    }
    
    if (! in_array($_POST['group_image'], $group_options_all))
    {
        $_POST['group_image'] = 'immediate';
    }
    $_POST['group_keyword'] = preg_replace('/[\,\s]+/',' ',$_POST['group_keyword']); 
    
    if ($err == '')
    {
        $sql = "UPDATE `groups` SET
               `group_name`= '" . mysql_clean($_POST['group_name']) . "',
               `group_keyword`= '" . mysql_clean($_POST['group_keyword']) . "',
               `group_description`= '" . mysql_clean($_POST['group_description']) . "',
               `group_type`= '" . mysql_clean($_POST['group_type']) . "',
               `group_upload`= '" . mysql_clean($_POST['group_upload']) . "',
               `group_posting`= '" . mysql_clean($_POST['group_posting']) . "',
               `group_image`= '" . mysql_clean($_POST['group_image']) . "' WHERE
               `group_owner_id`='" . (int) $_SESSION['UID'] . "' AND
               `group_url`='" . mysql_clean($_GET['group_url']) . "'";
        mysql_query($sql) or mysql_die($sql);
    }
    
    if (! isset($_POST['group_channels']) || count($_POST['group_channels']) < 1 || count($_POST['group_channels']) > 3)
    {
        $err = $lang['group_channel_empty'];
    }
    else
    {
        $channels = implode('|', $_POST['group_channels']);
        
        $sql = "UPDATE `groups` SET
               `group_channels`='0|" . mysql_clean($channels) . "|0' WHERE
               `group_owner_id`='" . (int) $_SESSION['UID'] . "' AND
               `group_url`='" . mysql_clean($_GET['group_url']) . "'";
        mysql_query($sql) or mysql_die($sql);
    }
    
    if ($err == '')
    {
        set_message($lang['group_updated'], 'success');
        $redirect_url = VSHARE_URL . '/group/' . $_GET['group_url'] . '/';
        redirect($redirect_url);
    }
}

$sql = "SELECT * FROM `groups` WHERE
       `group_url`='" . mysql_clean($_GET['group_url']) . "' AND
       `group_owner_id`='" . (int) $_SESSION['UID'] . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) < 1)
{
    redirect(VSHARE_URL . '/' . $_SESSION['USERNAME'] . '/groups/');
}

$group_info = mysql_fetch_assoc($result);

$myChannels = explode('|', $group_info['group_channels']);
$channelsAll = channels::get_all();
$ch_checkbox = '';

for ($i = 0; $i < count($channelsAll); $i ++)
{
    if (in_array($channelsAll[$i]['channel_id'], $myChannels))
    {
        $checked = 'checked="checked"';
    }
    else
    {
        $checked = '';
    }
    
    $ch_checkbox .= '<input type="checkbox" name="group_channels[]" value="' . $channelsAll[$i]['channel_id'] . '" ' . $checked . '>' . $channelsAll[$i]['channel_name_html'] . '</input><br />';
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('group_info', $group_info);
$smarty->assign('ch_checkbox', $ch_checkbox);
$smarty->assign('sub_menu', 'menu_group_members.tpl');
$smarty->display('header.tpl');
$smarty->display('group_edit.tpl');
$smarty->display('footer.tpl');
db_close();
