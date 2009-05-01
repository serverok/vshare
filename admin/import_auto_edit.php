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
require '../include/class.channels.php';

check_admin_login();

$id = isset($_GET['id']) ? $_GET['id'] : $_POST['import_auto_id'];

$sql = "SELECT * FROM `import_auto` WHERE
        `import_auto_id`='" . (int) $id . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) > 0)
{
    $import_auto_info = mysql_fetch_assoc($result);
}
else
{
    $msg = 'Keyword not found';
    set_message($msg, 'success');
    $redirect_url = VSHARE_URL . '/admin/import_auto.php';
    redirect($redirect_url);
}

if (isset($_POST['submit']))
{
    if ($_POST['video_keywords'] != '')
    {
        $video_keywords = htmlspecialchars($_POST['video_keywords'], ENT_QUOTES, 'UTF-8');
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
        
        if ($video_keywords != $import_auto_info['import_auto_keywords'])
        {
            if (check_field_exists($video_keywords, 'import_auto_keywords', 'import_auto'))
            {
                $err = 'This keyword already exist';
            }
        }
        
        if ($err == '')
        {
            $sql = "UPDATE `import_auto` SET
				   `import_auto_keywords`='" . mysql_clean($video_keywords) . "',
        		   `import_auto_user`='" . mysql_clean($user_name) . "',
        		   `import_auto_channel`='" . (int) $channel_id . "',
        		   `import_auto_download`='" . (int) $_POST['import_auto_download'] . "' WHERE
        		   `import_auto_id`='" . (int) $id . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            
            $msg = 'Keyword updated successfully';
            set_message($msg, 'success');
            $redirect_url = VSHARE_URL . '/admin/import_auto.php';
            redirect($redirect_url);
        }
    }
    else
    {
        $msg = 'Please enter keyword';
    }
}

$smarty->assign('import_auto_info', $import_auto_info);
$smarty->assign('import_auto_id', $id);
$smarty->assign('channel_info', channels::get_all());
$smarty->assign('msg', $msg);
$smarty->assign('err', $err);
$smarty->display('admin/header.tpl');
$smarty->display('admin/import_auto_edit.tpl');
$smarty->display('admin/footer.tpl');
db_close();
