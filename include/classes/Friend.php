<?php

class Friend
{

    function makeFriends($friend_1, $friend_2)
    {
        $sql = "SELECT * FROM `users` WHERE
		       `user_name`='$friend_1'";
        $tmp = DB::fetch1($sql);
        $friend_1_id = $tmp['user_id'];

        $sql = "SELECT * FROM `users` WHERE
		       `user_name`='$friend_2'";
        $tmp = DB::fetch1($sql);
        $friend_2_id = $tmp['user_id'];

        $sql = "INSERT INTO `friends` SET
		       `friend_user_id`=$friend_2_id,
		       `friend_friend_id`='$friend_1_id',
		       `friend_name`='$friend_1',
		       `friend_type`='All|Friends',
		       `friend_invite_date`='" . date("Y-m-d") . "',
		       `friend_status`='Confirmed'";
        DB::query($sql);

        $sql = "INSERT INTO `friends` SET
		       `friend_user_id`=$friend_1_id,
		       `friend_friend_id`='$friend_2_id',
		       `friend_name`='$friend_2',
		       `friend_type`='All|Friends',
		       `friend_invite_date`='" . date("Y-m-d") . "',
		       `friend_status`='Confirmed'";
        DB::query($sql);
    }

}
