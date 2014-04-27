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

$current_folder = dirname(__FILE__);

chdir("$current_folder");

require $current_folder . '/include/config.php';
require $current_folder . '/include/class.upload_remote.php';
require $current_folder . '/include/functions_seo_name.php';
require $current_folder . '/include/class.tags.php';
require $current_folder . '/include/youtube.php';
require $current_folder . '/include/class.bulk_import.php';
require 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata_YouTube');

$sql = "SELECT * FROM `import_auto`";
$result = mysql_query($sql) or mysql_die();

if (mysql_num_rows($result) < 1)
{
    exit();
}

while ($import_auto_info = mysql_fetch_assoc($result))
{
    if ($import_auto_info['import_auto_keywords'] != '')
    {
        $import_auto_info['import_auto_keywords'];
        $search_string = $import_auto_info['import_auto_keywords'];
        $yt = new Zend_Gdata_YouTube();
        $query = $yt->newVideoQuery();
        $query->setQuery($search_string);
        $query->setStartIndex(1);
        $query->setMaxResults(10);
        
        $feed = $yt->getVideoFeed($query);
        
        foreach ($feed as $entry)
        {
            $videos[] = $entry->getVideoId();
        }
        
        for ($i = 0; $i < count($videos); $i ++)
        {
            if (! BulkImport::checkImported($videos[$i], 'youtube'))
            {
                $sql = "INSERT INTO `import_track` SET
					   `import_track_unique_id`='" . DB::quote($videos[$i]) . "' ,
					   `import_track_site`='" . DB::quote('youtube') . "'";
                mysql_query($sql) or mysql_die();
                
                $video_url = 'http://www.youtube.com/watch?v=' . $videos[$i];
                $video_info = BulkImport::getYoutubeVideoInfo($videos[$i]);
                $user_name = $import_auto_info['import_auto_user'];
                
                $sql = "SELECT * FROM `users` WHERE
						`user_name`='" . $user_name . "'";
                
                $result = mysql_query($sql);
                $user_info = mysql_fetch_assoc($result);
                
                $channel_id = $import_auto_info['import_auto_channel'];
                
                if ($import_auto_info['import_auto_download'] == 0)
                {
                    
                    $seo_name = seo_name($video_info['video_title']);
                    
                    $sql = "INSERT INTO `videos` SET
		                   `video_user_id`='" . (int) $user_info['user_id'] . "',
		                   `video_title`='" . DB::quote($video_info['video_title']) . "',
		                   `video_description`='" . DB::quote($video_info['video_description']) . "',
		                   `video_keywords`='" . DB::quote($video_info['video_keywords']) . "',
		                   `video_seo_name`='" . DB::quote($seo_name) . "',
		                   `video_channels`='0|" . DB::quote($channel_id) . "|0',
		                   `video_type`='" . DB::quote('public') . "',
		                   `video_duration`=1,
		                   `video_length`='01:00',
		                   `video_add_time`='" . $_SERVER['REQUEST_TIME'] . "',
		                   `video_add_date`='" . date('Y-m-d') . "',
		                   `video_active`='1',
		                   `video_approve`='$config[approve]'";
                    
                    mysql_query($sql) or mysql_die();
                    $vid = mysql_insert_id();
                    
                    $upload = new upload_remote();
                    $upload->vid = $vid;
                    $upload->url = $video_url;
                    $upload->debug = 1;
                    
                    if ($type == 'public' && $config['approve'] == 1)
                    {
                        $current_keyword = DB::quote($video_info['video_keywords']);
                        $tags = new Tags($video_info['video_keywords'], $vid, $user_info['user_id'], "0|$channel_id|0");
                        $tags->add();
                    }
                    
                    $upload->youtube();
                
                }
                else if ($import_auto_info['import_auto_download'] == 1)
                {
                    $sql = "INSERT INTO `process_queue`SET
			               `user`='" . DB::quote($user_info['user_name']) . "',
			               `title`='" . DB::quote($video_info['video_title']) . "',
			               `description`='" . DB::quote($video_info['video_description']) . "',
			               `keywords`='" . DB::quote($video_info['video_keywords']) . "',
			               `type`='public',
			               `channels`='0|" . DB::quote($channel_id) . "|0',
			               `status`='0',
			               `url`='" . DB::quote($video_url) . "'";
                    mysql_query($sql) or mysql_die();
                }
            }
        }
        unset($videos);
    }
}