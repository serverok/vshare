<?php

class Friend
{
    public static function makeFriends($friend_1, $friend_2)
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

    public static function addList($new)
    {
        $sql = "SELECT `user_friends_type` FROM `users` WHERE
                `user_id`='" . (int) $_SESSION['UID'] . "'";
        $user_info = DB::fetch1($sql);
        $user_friends_types = explode('|', $user_info['user_friends_type']);
        $user_friends_types[] = $new;
        $user_friends_types = array_unique($user_friends_types);
        sort($user_friends_types);
        $user_friends_types = implode('|', $user_friends_types);
        $user_friends_types .= '|';

        $sql = "UPDATE `users` SET
                `user_friends_type`='" . DB::quote($user_friends_types) . "' WHERE
                `user_id`='" . (int) $_SESSION['UID'] . "'";
        DB::query($sql);
    }

    public static function removeList($list)
    {
        $sql = "SELECT `user_friends_type` FROM `users` WHERE
                `user_id`='" . (int) $_SESSION['UID'] . "'";
        $user_info = DB::fetch1($sql);
        $user_friends_types_new = str_replace('|' . $list . '|', '|', $user_info['user_friends_type']);

        $sql = "UPDATE `users` SET
                `user_friends_type`='" . DB::quote($user_friends_types_new) . "' WHERE
                `user_id`='" . (int) $_SESSION['UID'] . "'";
        DB::query($sql);

        $sql = "SELECT `friend_id` FROM `friends` WHERE
               `friend_user_id`='" . (int) $_SESSION['UID'] . "'";
        $friends = DB::fetch($sql);

        foreach ($friends as $key => $friend) {
            self::removeFromList($friend['friend_id'], $list);
        }
    }

    public static function addToList($friend_id, $list)
    {
        $sql = "SELECT `friend_type` FROM `friends` WHERE
               `friend_id`='" . (int) $friend_id . "'";
        $friend_info = DB::fetch1($sql);
        $friend_types = explode('|', $friend_info['friend_type']);
        $friend_types[] = $list;
        $friend_types = array_unique($friend_types);
        sort($friend_types);
        $friend_types = implode('|', $friend_types);
        $friend_types .= '|';

        $sql = "UPDATE `friends` SET
               `friend_type`='" . DB::quote($friend_types) . "' WHERE
               `friend_id`='" . (int) $friend_id . "'";
        DB::query($sql);
    }

    public static function removeFromList($friend_id, $list)
    {
        $sql = "SELECT `friend_type` FROM `friends` WHERE
               `friend_id`='" . (int) $friend_id . "'";
        $friend_info = DB::fetch1($sql);
        $friend_types_new = str_replace('|' . $list . '|', '|', $friend_info['friend_type']);

        $sql = "UPDATE `friends` SET
               `friend_type`='" . DB::quote($friend_types_new) . "' WHERE
               `friend_id`='" . (int) $friend_id . "'";
        DB::query($sql);
    }

    public static function delete($friend_id)
    {
        $sql = "DELETE FROM `friends` WHERE
               `friend_id`='" . (int) $friend_id . "' AND
               `friend_user_id`='" . (int) $_SESSION['UID'] . "'";
        DB::query($sql);
    }
}
