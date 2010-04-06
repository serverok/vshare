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

require 'include/config.php';

User::is_logged_in();

if (isset($_POST['submit']))
{
    $sql = "UPDATE `users` SET
		   `user_friend_invition`=" . (int) $_POST['user_friend_invition'] . ",
		   `user_private_message`=" . (int) $_POST['user_private_message'] . ",
		   `user_profile_comment`=" . (int) $_POST['user_profile_comment'] . ",
		   `user_favourite_public`=" . (int) $_POST['user_favourite_public'] . ",
		   `user_playlist_public`=" . (int) $_POST['user_playlist_public'] . "
		    WHERE `user_id`='" . (int) $_SESSION['UID'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
}

$sql = "SELECT * FROM `users` WHERE
       `user_id`='" . (int) $_SESSION['UID'] . "'";
$result = mysql_query($sql) or mysql_die($sql);
$user_info = mysql_fetch_assoc($result);

$smarty->assign('user_info', $user_info);
$smarty->display('header.tpl');
$smarty->display('user_privacy.tpl');
$smarty->display('footer.tpl');
db_close();
