<?php

require '../include/config.php';

$sql = "SELECT * FROM `users`";
$result = DB::query($sql);

while ($userRow = mysqli_fetch_assoc($result))
{
	$user_name = $userRow['user_name'];
	$user_id = $userRow['user_id'];
	$user_password = $userRow['user_password'];
	if (strlen($user_password) > 30)
	{
		echo "<p><b>$user_name = $user_password</b></p>";
	}
	else
	{
		$user_password_md5 = md5($user_password);
		$sql = "UPDATE `users` SET
			   `user_password`='" . DB::quote($user_password_md5) . "' WHERE
			   `user_id`='" . (int) $user_id . "'";
		echo "<p>$sql</p>";
		DB::query($sql);
	}
}
