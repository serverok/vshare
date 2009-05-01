<?php

require '../include/config.php';
require '../include/class.xss.php';
require '../include/language/' . LANG . '/lang_video_comment_add.php';

$comments_value = isset($_POST['comments_value']) ? $_POST['comments_value'] : '';
$video_id = isset($_POST['video_id']) ? (int) $_POST['video_id'] : '';

if (get_magic_quotes_gpc())
{
	$comments_value = stripslashes($comments_value);
}

$comments_value = Xss::clean($comments_value);
$comments_value = nl2br($comments_value);

if (! is_numeric($video_id))
{
    $err = $lang['vid_invalid'];
}
else if (! isset($_SESSION['UID']))
{
    $err = $lang['guest'];
}
else if (empty($comments_value))
{
    $err = $lang['comment_value_empty'];
}

if (! empty($err))
{
    echo $err;
    exit();
}

$sql = "SELECT * FROM `words`";
$result = mysql_query($sql) or mysql_die();
while ($row = mysql_fetch_assoc($result))
{
    $word = $row['word'];
    $replacement = $row['replacement'];
    if (preg_match("/$word/i", $comments_value))
    {
        if ($replacement == '')
        {
            $word_length = mb_strlen($word, 'UTF-8');
            $replacement = str_repeat('*', $word_length);
        }
        $comments_value = str_replace($word, $replacement, $comments_value);
    }
}

$sql = "INSERT INTO `comments` SET
	   `comment_video_id`='" . (int) $video_id . "',
	   `comment_user_id`='" . (int) $_SESSION['UID'] . "',
	   `comment_text`='" . mysql_clean($comments_value,1) . "',
	   `comment_add_time`='" . mysql_clean($_SERVER['REQUEST_TIME']) . "'";
$result = mysql_query($sql) or mysql_die();

if (mysql_affected_rows() == 1)
{
    $sql = "UPDATE `videos` SET
           `video_com_num`=`video_com_num`+1 WHERE
           `video_id`='" . (int) $video_id . "'";
    mysql_query($sql) or mysql_die($sql);
}

echo $lang['comment_posted'];
db_close();
