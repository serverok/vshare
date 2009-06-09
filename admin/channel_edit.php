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
require '../include/functions_seo_name.php';
require '../include/language/' . LANG . '/lang_admin_channel_edit.php';

check_admin_login();

$result_per_page = get_config('admin_listing_per_page');

if (isset($_POST['edit_channel']))
{
    
    if ($_POST['name'] == '')
    {
        $err = $lang['channel_name_null'];
    }
    else if ($_POST['descrip'] == '')
    {
        $err = $lang['channel_description_null'];
    }

    $_POST['name'] = trim($_POST['name']);
    $seo_name = seo_name($_POST['name']);
    
    $sql = "SELECT * FROM `channels` WHERE 
    	   `channel_seo_name`='" . $seo_name . "' AND
    	   `channel_id`!='" . (int) $_POST['id'] . "'";
    $result = mysql_query($sql);
    
    if (mysql_num_rows($result)) 
    {
        $err =  'Channel with the name already exists';
    }
    
    $sql = "SELECT * FROM `channels` WHERE 
    	   `channel_name`='" . mysql_clean($_POST['name']) . "' AND
    	   `channel_id`!='" . (int) $_POST['id'] . "'";
    $result = mysql_query($sql);
    
    if (mysql_num_rows($result))
    {
        $err =  'Channel with the name already exists';
    }
    
    if ($err == '')
    {
        
        $sql = "UPDATE `channels` SET
               `channel_name` = '" . mysql_clean($_POST['name']) . "',
               `channel_seo_name` = '" . mysql_clean($seo_name) . "',
               `channel_description` = '" . mysql_clean($_POST['descrip']) . "'
                WHERE `channel_id`='" . (int) $_POST['id'] . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if ($_FILES['picture'] != '')
        {
            $err = upload_jpg($_FILES, 'picture', "{$_POST['id']}.jpg", 120, VSHARE_DIR . '/chimg/');
        }
        
        if ($err == '')
        {
            set_message($lang['channel_updated'], 'success');
            $redirect_url = VSHARE_URL . '/admin/channel_search.php?id=' . $_POST['id'] . '&action=search';
            redirect($redirect_url);
        }
    }
    else
    {
        $_GET['chid'] = $_POST['id'];
    }
}

if (isset($_GET['chid']) && $_GET['chid'] != '')
{
    $sql = "SELECT * FROM `channels` WHERE
         `channel_id`='" . (int) $_GET['chid'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $channel_info = mysql_fetch_assoc($result);
    $smarty->assign('channel', $channel_info);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/channel_edit.tpl');
$smarty->display('admin/footer.tpl');
db_close();