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
require 'include/functions_seo_name.php';
require 'include/class.channels.php';
require 'include/class.xss.php';
require 'include/language/' . LANG . '/lang_group_new.php';

User::is_logged_in();

if (isset($_POST['submit']))
{
    $group_name = htmlspecialchars_uni($_POST['group_name']);
    $group_name = trim($group_name);
    
    $tags = strip_tags($_POST['tags']);
    $tags = trim($tags);
    $tags = preg_replace('/[\,\s]+/', ' ', $tags);
    
    $description = htmlspecialchars_uni($_POST['description']);
    $description = trim($description);
    
    $short_name = strip_tags($_POST['short_name']);
    $short_name = trim($short_name);
    $short_name = seo_name($short_name);
    
    $smarty->assign('group_name', $group_name);
    $smarty->assign('tags', $tags);
    $smarty->assign('description', $description);
    $smarty->assign('short_name', $short_name);
    
    $chlist = $_POST['chlist'];
    
    if (strlen_uni($group_name) < 4)
    {
        $err = $lang['group_name_empty'];
    }
    else if (strlen_uni($tags) < 4)
    {
        $err = $lang['tags_empty'];
    }
    else if ($description == '')
    {
        $err = $lang['description_empty'];
    }
    else if ($short_name == '' || mb_strlen($short_name) < 3)
    {
        $err = $lang['group_url_invalid'];
    }
    else if (check_field_exists($short_name, 'group_url', 'groups') == 1)
    {
        $err = $lang['group_url_exist'];
    }
    else if (! isset($chlist))
    {
        $err = $lang['channel_select'];
    }
    else if (count($chlist) < 1 || count($chlist) > 3)
    {
        $err = $lang['channel_select'];
    }
    
    if ($err == '')
    {
        $group_type_arr = array(
            'public',
            'private',
            'protected'
        );
        
        $group_type = $_POST['group_type'];
        
        if (! in_array($_POST['group_type'], $group_type_arr))
        {
            $group_type = 'public';
        }
        
        $sql = "SELECT * FROM `videos` WHERE
			   `video_user_id`='" . (int) $_SESSION['UID'] . "'
				ORDER BY `video_id` DESC";
        $result = mysql_query($sql) or mysql_die();
        
        if (mysql_num_rows($result) > 1)
        {
            $tmp = mysql_fetch_assoc($result);
            $group_image_video = $tmp['video_id'];
        }
        else
        {
            $group_image_video = 0;
        }
        
        $listch = implode('|', $chlist);
        
        $sql = "INSERT INTO `groups` SET
			   `group_owner_id`='" . (int) $_SESSION['UID'] . "',
			   `group_name`='" . mysql_clean($group_name) . "',
			   `group_keyword`='" . mysql_clean($tags) . "',
			   `group_description`='" . mysql_clean($description) . "',
			   `group_url`='" . mysql_clean($short_name) . "',
			   `group_channels`='0|" . mysql_clean($listch) . "|0',
			   `group_type`='" . mysql_clean($group_type) . "',
			   `group_upload`='" . mysql_clean($_POST['video_upload_type']) . "',
			   `group_posting`='" . mysql_clean($_POST['forum_upload_type']) . "',
			   `group_image`='" . mysql_clean($_POST['group_icon']) . "',
			   `group_image_video`= '" . (int) $group_image_video . "',
			   `group_create_time`='" . mysql_clean($_SERVER['REQUEST_TIME']) . "'";
        $result = mysql_query($sql) or mysql_die();
        $id = mysql_insert_id();
        
        $sql = "INSERT INTO `group_members` SET
			   `group_member_group_id`='" . (int) $id . "',
			   `group_member_user_id`='" . (int) $_SESSION['UID'] . "',
			   `group_member_since`='" . date("Y-m-d") . "'";
        $result = mysql_query($sql) or mysql_die();
        
        $redirect_url = VSHARE_URL . '/group/' . $short_name . '/';
        redirect($redirect_url);
    }
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('chinfo', channels::get_all());
$smarty->assign('sub_menu', 'menu_groups.tpl');
$smarty->display('header.tpl');
$smarty->display('group_new.tpl');
$smarty->display('footer.tpl');
db_close();
