<?php

require '../include/config.php';
require '../include/language/' . LANG . '/lang_video_add_favorite.php';

if (! isset($_SESSION['UID']))
{
    echo $lang['user_must_login'];
    exit(0);
}

$video_id = isset($_POST['video_id']) ? $_POST['video_id'] : '';

if (! is_numeric($video_id))
{
    echo $lang['hacking'];
    exit(0);
}

$sql = "SELECT * FROM `videos` WHERE
       `video_id`='" . (int) $video_id . "'";
$result = mysql_query($sql) or mysql_die($sql);
$video_info = mysql_fetch_assoc($result);

if ($_SESSION['UID'] == $video_info['video_user_id'])
{
    echo $lang['favorite_self'];
    exit(0);
}

$sql = "SELECT * FROM `favourite` WHERE
       `favourite_user_id`=" . (int) $_SESSION['UID'] . " AND
       `favourite_video_id`='" . (int) $video_id . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (! mysql_num_rows($result))
{
    $sql = "INSERT INTO `favourite` SET
	       `favourite_user_id`='" . (int) $_SESSION['UID'] . "',
	       `favourite_video_id`='" . (int) $video_id . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $sql = "UPDATE `videos` SET
	       `video_fav_num`=`video_fav_num`+1
	        WHERE `video_id`=" . (int) $video_id;
    $result = mysql_query($sql) or mysql_die($sql);
    echo $lang['favorite_added'];
}
else
{
    echo $lang['favorite_exists'];
}

db_close();
