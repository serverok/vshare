<?php

require '../include/config.php';
require '../include/functions_ajax.php';

$video_id = isset($_POST['video_id']) ? $_POST['video_id'] : '';
$comment_id = isset($_POST['comment_id']) ? $_POST['comment_id'] : '';

if (! is_numeric($video_id) || ! is_numeric($comment_id) || ! isset($_SESSION['UID']))
{
    return_json('Hacking attempt.', 'error');
    exit(0);
}

if (isset($_SESSION['UID']))
{
    $sql = "SELECT * FROM `videos` WHERE
           `video_id`=" . (int) $video_id . " AND
           `video_user_id`=" . (int) $_SESSION['UID'];
    $result = mysql_query($sql) or mysql_die($sql);
    
    if (mysql_num_rows($result) == 1)
    {
        $sql = "DELETE FROM `comments` WHERE 
               `comment_id`=" . (int) $comment_id . " AND
               `comment_video_id`=" . (int) $video_id;
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_affected_rows() == 1)
        {
            $sql = "UPDATE `videos` SET
		           `video_com_num`=`video_com_num`-1 WHERE
		           `video_id`='" . (int) $video_id . "'";
            mysql_query($sql) or mysql_die($sql);
            
            return_json($comment_id, 'success');
        }
    }
}

db_close();
