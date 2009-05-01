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
require '../include/language/' . LANG . '/lang_admin_video_delete.php';
require '../include/class.ftp.php';
require '../include/class.video.php';

check_admin_login();

if (isset($_GET['id']) && is_numeric($_GET['id']))
{
    $video_id = $_GET['id'];
    $sql = "SELECT * FROM `videos` WHERE
           `video_id`='" . (int) $video_id . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    
    if (mysql_num_rows($result) == 0)
    {
        $err = str_replace('[VIDEO_ID]', $video_id, $lang['video_not_found']);
    }
    else
    {
        $tmp = mysql_fetch_assoc($result);
        $video_uid = $tmp['video_user_id'];
        $tmp = Video::delete($video_id, $video_uid);
        
        if ($tmp == 1)
        {
            $msg = $lang['video_deleted'];
        }
        else
        {
            $err = $tmp;
        }
    
    }
}
else
{
    $err = $lang['video_id_empty'];
}

if (isset($_SERVER['HTTP_REFERER']) && strstr($_SERVER['HTTP_REFERER'], 'video_user_deleted.php?msg=' . $msg . 'err=' . $err))
{
    $redirect_url = $_SERVER['HTTP_REFERER'];
    redirect($redirect_url);
}

$smarty->assign('msg', $msg);
$smarty->assign('err', $err);
$smarty->display('admin/header.tpl');
$smarty->display('admin/footer.tpl');
db_close();
