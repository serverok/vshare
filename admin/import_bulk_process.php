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
require '../include/class.upload_remote.php';
require '../include/functions_seo_name.php';
require '../include/class.tags.php';
require '../include/class.bulk_import.php';
require '../include/youtube.php';
require 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata_YouTube');

check_admin_login();

$imported_sites = array(
    'youtube'
);

if (isset($_POST['submit']))
{
    $video_id = isset($_POST['video_id']) ? $_POST['video_id'] : array();
    $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
    $channel_id = isset($_POST['channel_id']) ? (int) $_POST['channel_id'] : 0;
    
    $sql = "SELECT * FROM `users` AS u,`channels` AS c WHERE
    		u.user_name='" . mysql_clean($user_name) . "' AND
    		c.channel_id='" . (int) $channel_id . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    
    if (mysql_num_rows($result) > 0)
    {
        $tmp = mysql_fetch_assoc($result);
        $user_id = $tmp['user_id'];
        
        for ($i = 0; $i < count($video_id); $i ++)
        {
            if (! BulkImport::checkImported($video_id[$i], $_POST['import_site']) && in_array($_POST['import_site'], $imported_sites))
            {
                $sql = "INSERT INTO `import_track` SET
					   `import_track_unique_id`='" . mysql_clean($video_id[$i]) . "' ,
					   `import_track_site`='" . mysql_clean($_POST['import_site']) . "'";
                $result = mysql_query($sql) or mysql_die($sql);
                $import_track_id = mysql_insert_id();
                
                if ($_POST['import_site'] == 'youtube')
                {
                    $video_url = 'http://www.youtube.com/watch?v=' . $video_id[$i];
                    $video_info = BulkImport::getYoutubeVideoInfo($video_id[$i]);
                }
                
                if ($_POST['import_method'] == 'embed')
                {
                    
                    $seo_name = seo_name($video_info['video_title']);
                    
                    $sql = "INSERT INTO `videos` SET
		                   `video_user_id`='" . (int) $user_id . "',
		                   `video_title`='" . mysql_clean($video_info['video_title']) . "',
		                   `video_description`='" . mysql_clean($video_info['video_description']) . "',
		                   `video_keywords`='" . mysql_clean($video_info['video_keywords']) . "',
		                   `video_seo_name`='" . mysql_clean($seo_name) . "',
		                   `video_channels`='0|" . mysql_clean($channel_id) . "|0',
		                   `video_type`='" . mysql_clean('public') . "',
		                   `video_duration`=1,
		                   `video_length`='01:00',
		                   `video_add_time`='" . $_SERVER['REQUEST_TIME'] . "',
		                   `video_add_date`='" . date('Y-m-d') . "',
		                   `video_active`='1',
		                   `video_approve`='$config[approve]'";
                    
                    $result = mysql_query($sql) or mysql_die($sql);
                    $vid = mysql_insert_id();
                    
                    $upload = new upload_remote();
                    $upload->vid = $vid;
                    $upload->url = $video_url;
                    $upload->debug = 1;
                    
                    if ($config['approve'] == 1)
                    {
                        $current_keyword = mysql_clean($video_info['video_keywords']);
                        $tags = new Tags($video_info['video_keywords'], $vid, $user_id, "0|$channel_id|0");
                        $tags->add();
                        $video_tags = $tags->get_tags();
                        $sql = "UPDATE `videos` SET
                               `video_keywords`='" . mysql_clean(implode(' ', $video_tags)) . "' WHERE
                               `video_id`='" . (int) $vid . "'";
                        mysql_query($sql) or mysql_die($sql);
                    }
                    
                    if ($_POST['import_site'] == 'youtube')
                    {
                        $upload->youtube();
                    }
                    
                    $sql = "UPDATE `import_track` SET `import_track_video_id`=" . (int) $vid . " WHERE
                           `import_track_id`=" . (int) $import_track_id;
                    $result = mysql_query($sql) or mysql_die($sql);
                }
                else
                {
                    $sql = "INSERT INTO `process_queue`SET
			               `user`='" . mysql_clean($user_name) . "',
			               `title`='" . mysql_clean($video_info['video_title']) . "',
			               `description`='" . mysql_clean($video_info['video_description']) . "',
			               `keywords`='" . mysql_clean($video_info['video_keywords']) . "',
			               `process_queue_upload_ip`='" . User::get_ip() . "',
			               `type`='public',
			               `channels`='0|" . mysql_clean($channel_id) . "|0',
			               `status`='0',
			               `url`='" . mysql_clean($video_url) . "',
			               `import_track_id`=" . (int) $import_track_id;
                    $result = mysql_query($sql) or mysql_die($sql);
                }
            
            }
        }
    }
    
    $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
    $page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
    
    $redirect_url = VSHARE_URL . '/admin/import_bulk.php?keyword=' . $keyword . '&user_name=' . $user_name . '&channel=' . $channel_id . '&page=' . $page;
    redirect($redirect_url);
}
