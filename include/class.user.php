<?php

class User
{

    static function login($user_name, $admin_login = 0)
    {
        global $conn , $config;
        
        $sql = "SELECT * FROM `users` WHERE
               `user_name`='" . mysql_clean($user_name) . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result))
        {
            $user_info = mysql_fetch_assoc($result);
            $sql = "UPDATE `users` SET
                   `user_last_login_time`='" . $_SERVER['REQUEST_TIME'] . "' WHERE
                   `user_name`='" . mysql_clean($user_name) . "'";
            mysql_query($sql) or mysql_die($sql);
            
            $password = $user_info['user_password'];
            $user_salt = $user_info['user_salt'];
            $token = $password . $user_salt;
            $token = md5($token);
            
            $_SESSION['EMAIL'] = $user_info['user_email'];
            $_SESSION['UID'] = $user_info['user_id'];
            $_SESSION['USERNAME'] = $user_info['user_name'];
            $_SESSION['EMAILVERIFIED'] = $user_info['user_email_verified'];
            $_SESSION['pwd'] = $token;
            
            if ($admin_login == 1)
            {
                return 1;
            }
            
            /* log user logins  */
            
            $ip = User::get_ip();
            
            $sql = "INSERT INTO user_logins SET
                   `user_login_user_id`='" . (int) $_SESSION['UID'] . "',
                   `user_login_time`='" . mysql_clean($_SERVER['REQUEST_TIME']) . "',
                   `user_login_ip`='" . mysql_clean($ip) . "'";
            mysql_query($sql);
            
            /* delete 100 days old log */
            
            $delete_days_old = 100;
            $time_old = $_SERVER['REQUEST_TIME'] - (86400 * $delete_days_old);
            
            $sql = "DELETE FROM user_logins WHERE
                   `user_login_time` < '$time_old'";
            $result = mysql_query($sql);
            
            if ($config['family_filter'] == 1)
            {
            	$user_adult = $user_info['user_adult'];
            	setcookie('FAMILY_FILTER', $user_adult, time() + 8640000, '/');
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
        
        if ($config['family_filter'] == 1)
        {
            $_SESSION['FAMILY_FILTER'] = 1;
        }
    }

    static function get_ip()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
        {
            return $_SERVER['HTTP_X_FORWARDED'];
        }
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        {
            return $_SERVER['HTTP_FORWARDED_FOR'];
        }
        else if (isset($_SERVER['HTTP_FORWARDED']))
        {
            return $_SERVER['HTTP_FORWARDED'];
        }
        else
        {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    static function upload_photo()
    {
        global $conn , $config;
        
        $file_tmp_name = $_FILES['photo']['tmp_name'];
        $location_photo = VSHARE_DIR . '/photo/' . $_SESSION['UID'] . '.jpg';
        $location_avatar = VSHARE_DIR . '/photo/1_' . $_SESSION['UID'] . '.jpg';
        
        createThumb($file_tmp_name, $location_photo, $config['img_max_width'], $config['img_max_height']);
        createThumb($file_tmp_name, $location_avatar, 50, 40);
        
        $sql = "UPDATE `users` SET
               `user_photo`=1 WHERE
               `user_id`='" . (int) $_SESSION['UID'] . "'";
        $result = mysql_query($sql) or mysql_die($sql);
    }

    static function get_photo($user_photo = 0, $user_id)
    {
        global $conn , $config;
        
        if ($user_photo == 0)
        {
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
        $result = mysql_query($sql) or mysql_die($sql);
        if (mysql_num_rows($result))
        {
            $user_row = mysql_fetch_assoc($result);
            return $user_row['user_name'];
        }
        else
        {
            return 0;
        }
    }

    static function get_user_by_id($user_id)
    {
        $sql = "SELECT * FROM `users` WHERE
               `user_id`='" . (int) $user_id . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result))
        {
            $user_row = mysql_fetch_assoc($result);
            return $user_row;
        }
        else
        {
            return 0;
        }
    }

    static function get_user_by_name($user_name)
    {
        $sql = "SELECT * FROM `users` WHERE
           `user_id`='" . (int) $user_name . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        $user = mysql_fetch_assoc($result);
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
               `user_salt`='" . mysql_clean($user_salt) . "' WHERE
               `user_name`='" . mysql_clean($user_name) . "'";
        mysql_query($sql);
        
        $sql = "SELECT `user_password`,`user_salt` FROM `users` WHERE
               `user_name`='" . mysql_clean($user_name) . "'";
        $result = mysql_query($sql);
        $user_info = mysql_fetch_assoc($result);
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
               `user_name`='" . mysql_clean($_COOKIE['VSHARE_AL_USER']) . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result) == 1)
        {
            $user_info = mysql_fetch_assoc($result);
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $auth_string = $user_info['user_password'] . $user_info['user_salt'] . $user_agent;
            $auth_string = md5($auth_string);
            
            if ($_COOKIE['VSHARE_AL_PASSWORD'] == $auth_string)
            {
                User::login($_COOKIE['VSHARE_AL_USER']);
            }
            else
            {
                setcookie('VSHARE_AL_USER', '', time() - 10000, '/');
                setcookie('VSHARE_AL_PASSWORD', '', time() - 10000, '/');
            }
        }
    }

    static function is_logged_in()
    {
        global $config;
        $loged_in = 0;
        $signup_enable = get_config('signup_enable');
        
        if (isset($_SESSION['UID']) and isset($_SESSION['pwd']))
        {
            $sql = "SELECT `user_password`,`user_salt` FROM `users` WHERE
                   `user_id`='" . (int) $_SESSION['UID'] . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            
            if (mysql_num_rows($result))
            {
                $user_info = mysql_fetch_assoc($result);
                $token = $user_info['user_password'] . $user_info['user_salt'];
                $token = md5($token);
                if ($token == $_SESSION['pwd'])
                {
                    $loged_in = 1;
                }
            }
        }
        
        if ($loged_in == 0)
        {
            $_SESSION['REDIRECT'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            
            if ($signup_enable != 1)
            {
                $redirect_url = $config['baseurl'] . '/login';
            }
            else
            {
                $redirect_url = $config['baseurl'] . '/signup/';
            }
            
            redirect($redirect_url);
        }
    }

    static function delete($user_id, $is_admin = 0)
    {
        $user_info = User::get_user_by_id($user_id);
        
        if ($user_info == 0)
        {
            echo 'User not found';
            exit();
        }
        
        $photo_path = VSHARE_DIR . '/photo/' . $user_id . '.jpg';
        $photo_path_avatar = VSHARE_DIR . '/photo/1_' . $user_id . '.jpg';
        
        if (file_exists($photo_path) && is_file($photo_path))
        {
            unlink($photo_path);
        }
        
        if (file_exists($photo_path_avatar) && is_file($photo_path_avatar))
        {
            unlink($photo_path_avatar);
        }
        
        $user_name = $user_info['user_name'];
        
        $sql = "SELECT * FROM `videos` WHERE
               `video_user_id`='" . (int) $user_id . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        
        while ($videos = mysql_fetch_assoc($result))
        {
            Video::delete($videos['video_id'], $user_id, $is_admin);
        }
        
        $sql = "DELETE FROM `subscriber` WHERE
               `UID`='" . (int) $user_id . "'";
        mysql_query($sql) or mysql_die($sql);
        
        $sql = "DELETE FROM `user_logins` WHERE
               `user_login_user_id`='" . (int) $user_id . "'";
        mysql_query($sql) or mysql_die($sql);
        
        $sql = "DELETE FROM `playlists` WHERE
               `playlist_user_id`='" . (int) $user_id . "'";
        mysql_query($sql) or mysql_die($sql);
        
        $sql = "DELETE FROM `group_topics` WHERE
               `group_topic_user_id`='" . (int) $user_id . "'";
        mysql_query($sql) or mysql_die($sql);
        
        $sql = "DELETE FROM `group_topic_posts` WHERE
               `group_topic_post_user_id`='" . (int) $user_id . "'";
        mysql_query($sql) or mysql_die($sql);
        
        $sql = "DELETE FROM `comments` WHERE
               `comment_user_id`='" . (int) $user_id . "'";
        mysql_query($sql) or mysql_die($sql);
        
        $sql = "DELETE FROM `favourite` WHERE
               `favourite_user_id`='" . (int) $user_id . "'";
        mysql_query($sql) or mysql_die($sql);
        
        $sql = "DELETE FROM `group_members` WHERE
               `group_member_user_id`='" . (int) $user_id . "'";
        mysql_query($sql) or mysql_die($sql);
        
        $sql = "DELETE FROM `friends` WHERE
               `friend_user_id`='" . (int) $user_id . "'";
        mysql_query($sql) or mysql_die($sql);
        
        $sql = "DELETE FROM `friends` WHERE
               `friend_friend_id`='" . (int) $user_id . "'";
        mysql_query($sql) or mysql_die($sql);
        
        $sql = "DELETE FROM `groups` WHERE
               `group_owner_id`='" . (int) $user_id . "'";
        mysql_query($sql) or mysql_die($sql);
        
        $sql = "DELETE FROM `group_videos` WHERE
               `group_video_member_id`='" . (int) $user_id . "'";
        mysql_query($sql) or mysql_die($sql);
        
        $sql = "DELETE FROM `mails` WHERE
               `mail_sender`='$user_name' OR
               `mail_receiver`='$user_name'";
        mysql_query($sql) or mysql_die($sql);
        
        $sql = "DELETE FROM `profile_comments` WHERE
               `profile_comment_posted_by`='" . (int) $user_id . "'";
        mysql_query($sql) or mysql_die($sql);
        
        $sql = "DELETE FROM `buddy_list` WHERE
               `buddy_name`='" . mysql_clean($user_name) . "'";
        mysql_query($sql) or mysql_die($sql);
        
        $sql = "DELETE FROM `users` WHERE
               `user_id`='" . (int) $user_id . "'";
        mysql_query($sql) or mysql_die($sql);
    }
	
	static function friend_add($id,$key,$user_id)
	{
		$sql = "SELECT * FROM `verify_code` WHERE
			   `id`='" . (int) $id . "' AND
			   `vkey`='" . mysql_clean($key) . "'";
		$result = mysql_query($sql) or mysql_die($sql);
		
		if (mysql_num_rows($result) == 1)
		{
			$tmp = mysql_fetch_assoc($result);
			$fid = $tmp['data1'];
			
			$sql = "SELECT * FROM `users` WHERE
				   `user_id`='". (int) $user_id . "'";
			$result = mysql_query($sql) or mysql_die($sql);
			$user_info = mysql_fetch_assoc($result);
			
			
			$sql = "SELECT * FROM `friends` WHERE
				   `friend_id`='" . (int) $fid . "'";
			$result = mysql_query($sql) or mysql_die();
			$tmp = mysql_fetch_assoc($result);
			$friend_id = $tmp['friend_user_id'];
			
			$sql = "SELECT * FROM `users` WHERE
				   `user_id`='" . (int) $friend_id . "'";
			$result = mysql_query($sql) or mysql_die($sql);
			$tmp = mysql_fetch_assoc($result);
			$friend_user_name = $tmp['user_name'];
			
			$signup_auto_friend = get_config('signup_auto_friend');
			$friends = new Friends();
			
			if ($friend_user_name != $signup_auto_friend && !$friends->already_friends($user_id,$friend_id))
			{
				$friends->make_friends($user_info['user_name'], $friend_user_name);
			}
		}
	}
}
