<?php

require '../include/config.php';
require '../include/functions_ajax.php';
require '../include/class.xss.php';
require '../include/language/' . LANG . '/lang_user_comment_add.php';

$comments = isset($_POST['comment_value']) ? $_POST['comment_value'] : '';
$comments = trim($comments);
$profile_id = isset($_POST['profile_id']) ? $_POST['profile_id'] : '';

if (!is_numeric($profile_id))
{
	$err = $lang['invalid_profile_id'];
}
else if (!isset($_SESSION['UID']))
{
	$err = $lang['guest'];
}
else if ($comments == '' || strlen($comments) < 10 )
{
    $err = $lang['comment_too_short'];
}

if (!empty($err))
{
    return_json($err, 'error');
	exit();
}

if (isset($_SESSION["USERNAME"]))
{
	$voter_id = (int) $_SESSION['UID'];
	
	if (get_magic_quotes_gpc())
	{
		$comments = stripslashes($comments);
	}
	
	$comments = Xss::clean($comments);
	$comments = trim($comments);
	
	if (!empty($comments)) 
	{
		$sql = "SELECT * FROM `words`";
		$result = mysql_query($sql) or mysql_die();
		while($myobj = mysql_fetch_object ($result))
		{
			$word = $myobj->word;
			$replacement = $myobj->replacement;
			if (preg_match("/$word/i",$comments))
			{
				if ($replacement == "")
				{
					$word_length = mb_strlen($word,'UTF-8');
					$replacement = str_repeat("*", $word_length);
				}
				$comments = str_replace($word, $replacement, $comments);
			}
		}
	
		$now = date("Y-m-d H:i:s");
		$ip = $_SERVER['REMOTE_ADDR'];
		$sql = "INSERT INTO `profile_comments` SET
               `profile_comment_user_id`='" . (int) $profile_id . "',
               `profile_comment_posted_by`='" . (int) $voter_id . "',
               `profile_comment_text`='" . mysql_clean($comments,1) . "',
               `profile_comment_date`='$now',
               `profile_comment_ip`='$ip'";
		$result = mysql_query($sql) or mysql_die($sql);
		//write_log("$comments",3,"$config[basedir]/ajax/log.txt");
		if (mysql_affected_rows() >= 1)
		{
            return_json($lang['comment_post'], 'success');
		}
		else
		{
            return_json($lang['comment_post_error'], 'error');
		}
	
	} else {
        return_json($lang['comment_post_error'], 'error');
	}
}
else
{
    return_json($lang['guest'], 'error');
}
