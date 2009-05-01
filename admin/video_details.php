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
require '../include/class.video_player.php';
require '../include/language/' . LANG . '/lang_admin_video_details.php';

check_admin_login();

$vid = (int) $_GET['id'];

if (is_numeric($vid))
{
    $sql = "SELECT * FROM `videos` WHERE
           `video_id`='" . (int) $vid . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $num_result = mysql_num_rows($result);
    
    if ($num_result == 1)
    {
        $video_info = mysql_fetch_assoc($result);
        $player = new video_player();
        $smarty->assign('VSHARE_PLAYER', $player->get_player_code($vid));
        $smarty->assign('video', $video_info);
        $smarty->assign('video_type', $video_info['video_vtype']);
        $sql = "SELECT * FROM `process_queue` WHERE
               `vid`='" . (int) $vid . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result) == 1)
        {
            $source_video = VSHARE_DIR . '/video/' . $video_info['video_name'];
            
            if (file_exists($source_video))
            {
                $smarty->assign('reprocess', 1);
                $process_queue_info = mysql_fetch_assoc($result);
                $smarty->assign('reprocess_id', $process_queue_info['id']);
            }
        }
    }
    else
    {
        $err = str_replace('[VIDEO_ID]', $_GET['id'], $lang['video_not_found']);
    }
}
else
{
    $err = $lang['video_id_empty'];
}

if (isset($_REQUEST['a']))
{
    $smarty->assign('a', $_REQUEST['a']);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/video_details.tpl');
$smarty->display('admin/footer.tpl');
db_close();
