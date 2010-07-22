<?php

require '../include/config.php';

$video_id = isset($_GET['video_id']) ? (int) $_GET['video_id'] : 0;

$sql = "SELECT * FROM `videos` WHERE
       `video_id`=" . $video_id;
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) > 0)
{
    if (isset($_COOKIE['video_queue']) && !empty($_COOKIE['video_queue']))
    {
      
        $tmp = explode(',',$_COOKIE['video_queue']);

        if (!in_array($video_id,$tmp))
        {
            $video_ids = $_COOKIE['video_queue'] .  $video_id . ',' ;
            setcookie('video_queue', $video_ids, time() + 86400,'/');
        }
        
    }
    else
    {
        setcookie('video_queue', $video_id . ',', time() + 86400,'/');
    }
}

