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

require '../include/config.php';

check_admin_login();

$result_per_page = get_config('admin_listing_per_page');

if (isset($_GET['action']))
{
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    
    if ($page < 1)
    {
        $page = 1;
    }
    
    $items_per_page = isset($_GET['items_per_page']) ? (int) $_GET['items_per_page'] : $result_per_page;
    
    $start = ($page - 1) * $items_per_page;
    
    if ($_GET['action'] == 'update_video_counts')
    {
        $sql = "SELECT `user_id`, `user_name` FROM `users` WHERE
               `user_account_status`='Active' AND
               `user_email_verified`='Yes'
                ORDER BY `user_id` ASC
                LIMIT $start, $items_per_page";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result) > 0)
        {
            echo '<strong>Video Counts Updating...</strong>';
            
            while (list($user_id, $user_name) = mysql_fetch_array($result))
            {
                $sql = "SELECT COUNT(*) AS `total` FROM `videos` WHERE
                       `video_user_id`='" . (int) $user_id . "' AND
                       `video_active`='1' AND
                       `video_approve`='1'";
                $tmp_result = mysql_query($sql) or mysql_die($sql);
                $tmp_info = mysql_fetch_assoc($tmp_result);
                $total = $tmp_info['total'];
                
                $sql = "UPDATE `users` SET `user_videos`='" . (int) $total . "' WHERE
                       `user_id`='" . (int) $user_id . "'";
                mysql_query($sql) or mysql_die($sql);
                
                echo "<p>$user_name = $total videos.</p>";
            }
            
            $page ++;
            
            echo '<meta http-equiv="refresh" content="3;url=' . VSHARE_URL . '/admin/update_counters.php?action=update_video_counts&items_per_page=' . $items_per_page . '&page=' . $page . '">';
        }
        else
        {
            set_message('Video Counts Updated Successfully');
            
            $redirect_url = VSHARE_URL . '/admin/update_counters.php';
            redirect($redirect_url);
        }
    }
}
else
{
    $smarty->assign('result_per_page', $result_per_page);
    $smarty->assign('err', $err);
    $smarty->assign('msg', $msg);
    $smarty->display('admin/header.tpl');
    $smarty->display('admin/update_counters.tpl');
    $smarty->display('admin/footer.tpl');
}

db_close();
