<?php

require '../include/config.php';

if (isset($_COOKIE['video_queue']))
{
    if (!empty($_COOKIE['video_queue']))
    {
        $video_ids = $_COOKIE['video_queue'];
            
        if (preg_match('/,$/',$_COOKIE['video_queue'],$match))
        {
            $video_ids = preg_replace('/,$/','',$_COOKIE['video_queue']);
        }
        
        $sql = "SELECT * FROM `videos` WHERE
               `video_id` IN($video_ids)";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result) > 0)
        {
            while($tmp = mysql_fetch_assoc($result))
            {
                $tmp['video_thumb_url'] = $servers[$tmp['video_server_id']];
                $video_info[] = $tmp;
            }
            
            $smarty->assign('video_info',$video_info);
            $smarty->display('video_queue.tpl');
        }
        
    }
}
