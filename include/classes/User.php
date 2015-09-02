<?php

class User
{

    public static function getByName($user_name)
    {
        $sql = 'SELECT * FROM `users` WHERE
                `user_name`=\'' . DB::quote($user_name) . '\'';
        return DB::fetch1($sql);
    }

    public static function getById($user_id)
    {
        $sql = 'SELECT * FROM `users` WHERE
                `user_id`=' . (int) $user_id;
        return DB::fetch1($sql);
    }

    static function login($user_name, $admin_login = 0)
    {
        global $config;

        $sql = "SELECT * FROM `users` WHERE
               `user_name`='" . DB::quote($user_name) . "'";
        $user_info = DB::fetch1($sql);

        if ($user_info) {

            $sql = "UPDATE `users` SET
                   `user_last_login_time`='" . $_SERVER['REQUEST_TIME'] . "' WHERE
                   `user_name`='" . DB::quote($user_name) . "'";
            DB::query($sql);

            $password = $user_info['user_password'];
            $user_salt = $user_info['user_salt'];
            $token = $password . $user_salt;
            $token = md5($token);

            $_SESSION['EMAIL'] = $user_info['user_email'];
            $_SESSION['UID'] = $user_info['user_id'];
            $_SESSION['USERNAME'] = $user_info['user_name'];
            $_SESSION['EMAILVERIFIED'] = $user_info['user_email_verified'];
            $_SESSION['pwd'] = $token;

            if (Config::get('hotlink_protection') == 2) {
                setcookie('vShareAllow', 'yes', time() + 60 * 60 * 24 * 100, '/');
            }

            if ($admin_login == 1) {
                return 1;
            }

            /* log user logins  */

            $ip = User::get_ip();

            $sql = "INSERT INTO user_logins SET
                   `user_login_user_id`='" . (int) $_SESSION['UID'] . "',
                   `user_login_time`='" . DB::quote($_SERVER['REQUEST_TIME']) . "',
                   `user_login_ip`='" . DB::quote($ip) . "'";
            DB::query($sql);

            /* delete 100 days old log */

            $delete_days_old = 100;
            $time_old = $_SERVER['REQUEST_TIME'] - (86400 * $delete_days_old);

            $sql = "DELETE FROM user_logins WHERE
                   `user_login_time` < '$time_old'";
            DB::query($sql);

            if ($config['family_filter'] == 1) {
            	$_SESSION['FAMILY_FILTER'] = $user_info['user_adult'];
            }
        }
    }

    static function logout()
    {
        global $config;

        if (isset($_SESSION['UID'])) unset($_SESSION['UID']);
        if (isset($_SESSION['EMAIL'])) unset($_SESSION['EMAIL']);
        if (isset($_SESSION['USERNAME'])) unset($_SESSION['USERNAME']);
        if (isset($_SESSION['EMAILVERIFIED'])) unset($_SESSION['EMAILVERIFIED']);
        if (isset($_SESSION['pwd'])) unset($_SESSION['pwd']);
        setcookie('VSHARE_AL_USER', '', $_SERVER['REQUEST_TIME'] - 10000, '/');
        setcookie('VSHARE_AL_PASSWORD', '', $_SERVER['REQUEST_TIME'] - 10000, '/');
        setcookie('vShareAllow', '', time() - 3600, '/');


        if ($config['family_filter'] == 1) {
            $_SESSION['FAMILY_FILTER'] = 1;
        }
    }

    static function get_ip()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            return $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            return $_SERVER['HTTP_FORWARDED'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    static function upload_photo()
    {
        global $config;

        $file_tmp_name = $_FILES['photo']['tmp_name'];
        $location_photo = VSHARE_DIR . '/photo/' . $_SESSION['UID'] . '.jpg';
        $location_avatar = VSHARE_DIR . '/photo/1_' . $_SESSION['UID'] . '.jpg';

        Image::createThumb($file_tmp_name, $location_photo, Config::get('user_photo_width'), Config::get('user_photo_height'));
        Image::createThumb($file_tmp_name, $location_avatar, Config::get('user_avatar_width'), Config::get('user_avatar_height'));

        $sql = "UPDATE `users` SET
               `user_photo`=1 WHERE
               `user_id`='" . (int) $_SESSION['UID'] . "'";
        DB::query($sql);
    }

    static function get_photo($user_photo = 0, $user_id)
    {
        if ($user_photo == 0) {
            $photo_url = IMG_CSS_URL . '/images/no_pic.gif';
            return $photo_url;
        }

        $photo_url = VSHARE_URL . '/photo/' . $user_id . '.jpg';
        return $photo_url;
    }

    static function get_user_name_by_id($user_id)
    {
        $sql = "SELECT `user_name` FROM `users` WHERE
               `user_id`='" . (int) $user_id . "'";
        $user_row = DB::fetch1($sql);

        if ($user_row) {
            return $user_row['user_name'];
        } else {
            return 0;
        }
    }

    static function get_user_by_id($user_id)
    {
        $sql = "SELECT * FROM `users` WHERE
               `user_id`='" . (int) $user_id . "'";
        $user_row = DB::fetch1($sql);

        if ($user_row) {
            return $user_row;
        } else {
            return 0;
        }
    }

    static function get_user_by_name($user_name)
    {
        $sql = "SELECT * FROM `users` WHERE
           `user_id`='" . (int) $user_name . "'";
        return DB::fetch1($sql);
    }

    static function validate_url($url)
    {
        if (! $parse_url = parse_url($url))
        {
            return '';
        }

        if (! isset($parse_url['scheme']) || $parse_url['scheme'] == '')
        {
            $url = 'http://' . $url;
        }
        else
        {
            $allowed_protocols = array(
                'http',
                'https',
                'ftp',
                'nntp',
                'ssh',
                'sftp'
            );

            if (! in_array($parse_url['scheme'], $allowed_protocols))
            {
                $url = str_replace($parse_url['scheme'], 'http', $url);
            }
        }
        return $url;
    }

    static function set_auto_login_cookie($user_name)
    {
        $user_salt = md5(uniqid(rand(), TRUE));

        $sql = "UPDATE `users` SET
               `user_salt`='" . DB::quote($user_salt) . "' WHERE
               `user_name`='" . DB::quote($user_name) . "'";
        DB::query($sql);

        $sql = "SELECT `user_password`,`user_salt` FROM `users` WHERE
               `user_name`='" . DB::quote($user_name) . "'";
        $user_info = DB::fetch1($sql);
        $password = $user_info['user_password'];
        $user_salt = $user_info['user_salt'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $token = $password . $user_salt . $user_agent;
        $token = md5($token);
        setcookie('VSHARE_AL_USER', $user_name, time() + 60 * 60 * 24 * 100, '/');
        setcookie('VSHARE_AL_PASSWORD', $token, time() + 60 * 60 * 24 * 100, '/');
        // set new token for session auth
        $token = $password . $user_salt;
        $token = md5($token);
        $_SESSION['pwd'] = $token;
    }

    static function login_auto()
    {
        $sql = "SELECT user_password,user_salt FROM `users` WHERE
               `user_name`='" . DB::quote($_COOKIE['VSHARE_AL_USER']) . "'";
        $user_info = DB::fetch1($sql);

        if ($user_info) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $auth_string = $user_info['user_password'] . $user_info['user_salt'] . $user_agent;
            $auth_string = md5($auth_string);

            if ($_COOKIE['VSHARE_AL_PASSWORD'] == $auth_string) {
                User::login($_COOKIE['VSHARE_AL_USER']);
            } else {
                setcookie('VSHARE_AL_USER', '', time() - 10000, '/');
                setcookie('VSHARE_AL_PASSWORD', '', time() - 10000, '/');
            }
        }
    }

    static function is_logged_in()
    {
        global $config;
        $loged_in = 0;
        $signup_enable = Config::get('signup_enable');

        if (isset($_SESSION['UID']) and isset($_SESSION['pwd'])) {

            $sql = "SELECT `user_password`,`user_salt` FROM `users` WHERE
                   `user_id`='" . (int) $_SESSION['UID'] . "'";
            $user_info = DB::fetch1($sql);

            if ($user_info) {

                $token = $user_info['user_password'] . $user_info['user_salt'];
                $token = md5($token);

                if ($token == $_SESSION['pwd']) {
                    $loged_in = 1;
                }
            }
        }

        if ($loged_in == 0) {

            $_SESSION['REDIRECT'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

            if ($signup_enable != 1) {
                $redirect_url = $config['baseurl'] . '/login/';
            } else {
                $redirect_url = $config['baseurl'] . '/signup/';
            }

            Http::redirect($redirect_url);
        }
    }

    static function delete($user_id, $is_admin = 0)
    {
        $user_info = User::get_user_by_id($user_id);

        if ($user_info == 0) {
            echo 'User not found';
            exit();
        }

        $photo_path = VSHARE_DIR . '/photo/' . $user_id . '.jpg';
        $photo_path_avatar = VSHARE_DIR . '/photo/1_' . $user_id . '.jpg';

        if (file_exists($photo_path) && is_file($photo_path)) {
            unlink($photo_path);
        }

        if (file_exists($photo_path_avatar) && is_file($photo_path_avatar)) {
            unlink($photo_path_avatar);
        }

        $user_name = $user_info['user_name'];

        $sql = "SELECT * FROM `videos` WHERE
               `video_user_id`='" . (int) $user_id . "'";
        $result = DB::query($sql);

        while ($videos = mysqli_fetch_assoc($result)) {
            Video::delete($videos['video_id'], $user_id, $is_admin);
        }

        $sql = "DELETE FROM `subscriber` WHERE
               `UID`='" . (int) $user_id . "'";
        DB::query($sql);

        $sql = "DELETE FROM `user_logins` WHERE
               `user_login_user_id`='" . (int) $user_id . "'";
        DB::query($sql);

        $sql = "DELETE FROM `playlists` WHERE
               `playlist_user_id`='" . (int) $user_id . "'";
        DB::query($sql);

        $sql = "DELETE FROM `group_topics` WHERE
               `group_topic_user_id`='" . (int) $user_id . "'";
        DB::query($sql);

        $sql = "DELETE FROM `group_topic_posts` WHERE
               `group_topic_post_user_id`='" . (int) $user_id . "'";
        DB::query($sql);

        $sql = "DELETE FROM `comments` WHERE
               `comment_user_id`='" . (int) $user_id . "'";
        DB::query($sql);

        $sql = "DELETE FROM `favourite` WHERE
               `favourite_user_id`='" . (int) $user_id . "'";
        DB::query($sql);

        $sql = "DELETE FROM `group_members` WHERE
               `group_member_user_id`='" . (int) $user_id . "'";
        DB::query($sql);

        $sql = "DELETE FROM `friends` WHERE
               `friend_user_id`='" . (int) $user_id . "'";
        DB::query($sql);

        $sql = "DELETE FROM `friends` WHERE
               `friend_friend_id`='" . (int) $user_id . "'";
        DB::query($sql);

        $sql = "DELETE FROM `groups` WHERE
               `group_owner_id`='" . (int) $user_id . "'";
        DB::query($sql);

        $sql = "DELETE FROM `group_videos` WHERE
               `group_video_member_id`='" . (int) $user_id . "'";
        DB::query($sql);

        $sql = "DELETE FROM `mails` WHERE
               `mail_sender`='$user_name' OR
               `mail_receiver`='$user_name'";
        DB::query($sql);

        $sql = "DELETE FROM `profile_comments` WHERE
               `profile_comment_posted_by`='" . (int) $user_id . "'";
        DB::query($sql);

        $sql = "DELETE FROM `buddy_list` WHERE
               `buddy_name`='" . DB::quote($user_name) . "'";
        DB::query($sql);

        $sql = "DELETE FROM `users` WHERE
               `user_id`='" . (int) $user_id . "'";
        DB::query($sql);
    }

	static function friend_add($id,$key,$user_id)
	{
		$sql = "SELECT * FROM `verify_code` WHERE
			   `id`='" . (int) $id . "' AND
			   `vkey`='" . DB::quote($key) . "'";
		$tmp = DB::fetch1($sql);

		if ($tmp) {
			$fid = $tmp['data1'];

			$sql = "SELECT * FROM `users` WHERE
				   `user_id`='". (int) $user_id . "'";
			$user_info = DB::fetch1($sql);

			$sql = "SELECT * FROM `friends` WHERE
				   `friend_id`='" . (int) $fid . "'";
			$tmp = DB::fetch1($sql);
			$friend_id = $tmp['friend_user_id'];

			$sql = "SELECT * FROM `users` WHERE
				   `user_id`='" . (int) $friend_id . "'";
			$tmp = DB::fetch1($sql);
			$friend_user_name = $tmp['user_name'];

			$signup_auto_friend = Config::get('signup_auto_friend');
			$friends = new Friends();

			if ($friend_user_name != $signup_auto_friend && !$friends->already_friends($user_id,$friend_id)) {
				$friends->make_friends($user_info['user_name'], $friend_user_name);
			}
		}
	}

    public static function isReserved($user_name)
    {
        $user_name = mb_strtolower($user_name);
        $sql = "SELECT * FROM `disallow` WHERE
                `disallow_username`='" . DB::quote($user_name) . "'";
        if (DB::fetch1($sql)) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function updateVideoCount($user_id, $action = 1)
    {
        if ($action) {
            $sql = "UPDATE `users` SET
                   `user_videos`=`user_videos`+1 WHERE
                   `user_id`='" . (int) $user_id . "'";
        } else {
            $sql = "UPDATE `users` SET
                   `user_videos`=`user_videos`-1 WHERE
                   `user_id`='" . (int) $user_id . "'";
        }
        DB::query($sql);
    }

    public static function findAge($dob)
    {
        list($birth_year, $birth_month, $birth_day) = explode('-', $dob);
        $datestamp = date('d.m.Y');
        $t_arr = explode('.', $datestamp);
        $current_day = $t_arr[0];
        $current_month = $t_arr[1];
        $current_year = $t_arr[2];
        $year_dif = $current_year - $birth_year;

        if (($birth_month > $current_month) || ($birth_month == $current_month && $current_day < $birth_day)) {
            $age = $year_dif - 1;
        } else {
            $age = $year_dif;
        }

        return $age;
    }

    public static function getPasswordToken($user_name)
    {
        $user_info = self::getByName($user_name);
        $token = $user_info['user_password'] . $user_info['user_salt'];
        $token = md5($token);
        return $token;
    }

    public static function validate($user_name, $password)
    {
        $user_info = self::getByName($user_name);

        if ($user_info) {
            $password_md5 = md5($password . $user_info['user_salt']);
            if ($user_info['user_password'] == $password_md5) {
                return true;
            }
        }
        return false;
    }

    public static function changePassword($user_name, $password_new)
    {
        $user_salt = self::makeSalt();
        $password_new_md5 = md5($password_new . $user_salt);

        $sql = "UPDATE `users` SET
               `user_password`='$password_new_md5',
               `user_salt`='$user_salt' WHERE
               `user_name`='" . DB::quote($user_name) . "'";
        DB::query($sql);

        $token = self::getPasswordToken($user_name);
        $_SESSION['pwd'] = $token;
    }

    public static function makeSalt()
    {
        $salt = md5(uniqid(rand(), TRUE));
        $salt = substr($salt,0,10);
        return $salt;
    }
}
