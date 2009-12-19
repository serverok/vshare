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
require '../include/class.channels.php';

check_admin_login();

if (isset($_POST['submit']))
{
    $video_keywords = isset($_POST['video_keywords']) ? $_POST['video_keywords'] : '';
    $user_name = isset($_POST['video_user_name']) ? $_POST['video_user_name'] : '';
    $channel_id = isset($_POST['video_channel']) ? $_POST['video_channel'] : 0;
    $import_auto_download = isset($_POST['import_auto_download']) ? $_POST['import_auto_download'] : 0;
    
    if (! check_field_exists($user_name, 'user_name', 'users'))
    {
        $err = 'User not found - ' . $_POST['video_user_name'];
    }
    
    if (! check_field_exists($channel_id, 'channel_id', 'channels'))
    {
        $err = 'Select a channel';
    }
    
    if (strlen($_POST['video_keywords']) < 2)
    {
        $err = 'Please enter keyword';
    }
    
    if ($err == '')
    {
        $sql = "SELECT * FROM `import_auto` WHERE
			   `import_auto_keywords`='" . mysql_clean($video_keywords) . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result) == 0)
        {
            $sql = "INSERT INTO `import_auto` SET
					`import_auto_keywords`='" . mysql_clean($video_keywords) . "',
					`import_auto_user`='" . mysql_clean($user_name) . "',
					`import_auto_channel`='" . (int) $channel_id . "',
					`import_auto_download`='" . (int) $import_auto_download . "'";
            mysql_query($sql) or mysql_die($sql);
            $msg = 'Keywords successfully added';
            set_message($msg, 'success');
            $redirect_url = VSHARE_URL . '/admin/import_auto.php';
            redirect($redirect_url);
        }
        else
        {
            $err = 'Keywords Already Added.';
        }
    }
    
    $smarty->assign('video_keywords', $video_keywords);
    $smarty->assign('video_user_name', htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8'));
    $smarty->assign('video_channel', (int) $channel_id);
    $smarty->assign('import_auto_download', (int) $import_auto_download);
}

$sql = "SELECT * FROM `import_auto`";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) > 0)
{
    $import_auto_info = mysql_fetch_all($result);
    $smarty->assign('import_auto_info', $import_auto_info);
}

$channels = channels::get_all();
$smarty->assign('channel_info', $channels);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/import_auto.tpl');
$smarty->display('admin/footer.tpl');
db_close();
