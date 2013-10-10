<?php

require VSHARE_DIR . '/include/functions_insert.php';

function check_admin_login()
{
    global $config;
    $admin_loged_in = 0;
    if (isset($_SESSION['AUID']) && isset($_SESSION['APASSWORD']))
    {
        if (($_SESSION['AUID'] == $config['admin_name']) && ($_SESSION['APASSWORD'] == $config['admin_pass']))
        {
            $admin_loged_in = 1;
        }
    }

    if ($admin_loged_in == 0)
    {
        set_message('You are not logged in.', 'error');
        $redirect_url = $config['baseurl'] . '/admin/index.php';
        redirect($redirect_url);
    }

    write_admin_log();
}

function write_admin_log()
{
    $file_name_array = explode('/', $_SERVER['SCRIPT_FILENAME']);
    $admin_log_script = $file_name_array[count($file_name_array)-1];

    if ($admin_log_script == 'admin_log.php' || $admin_log_script == 'menu.php' || $admin_log_script == 'main.php')
    {
        return;
    }

    require_once 'class.user.php';
    $user = new User();
    $admin_log_ip = $user->get_ip();
    $admin_log_user_id = isset($_SESSION['MUID']) ? (int) $_SESSION['MUID'] : 0;
    $admin_log_time = time();
    $admin_log_extra = '';

    if (isset($_SERVER['QUERY_STRING']))
    {
        $admin_log_extra = $_SERVER['QUERY_STRING'];
    }

    $sql = "INSERT INTO `admin_log` SET
           `admin_log_user_id`='$admin_log_user_id',
           `admin_log_script`='$admin_log_script',
           `admin_log_time`='$admin_log_time',
           `admin_log_extra`='$admin_log_extra',
           `admin_log_ip`='$admin_log_ip'";
    $result = mysql_query($sql) or mysql_die($sql);
}

function mailing($recipient, $name, $from, $subj, $body, $bcc = '')
{
    $headers = '';
    $subj = nl2br($subj);
    $body = nl2br($body);
    if ($bcc != '')
    {
        $headers = 'Bcc: ' . $bcc . "\n";
    }
    $headers .= 'From: ' . $from . "\n";
    $headers .= "Content-Type: text/html\n";
    mail("$recipient", "$subj", "$body", "$headers");
}

function years($sel = '')
{
    $year = '';
    $init = date('Y');

    for ($i = 1900; $i <= $init; $i ++)
    {
        if ($i == $sel)
        {
            $year .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
        }
        else
        {
            $year .= '<option value="' . $i . '">' . $i . '</option>';
        }
    }
    return $year;
}

function months($sel = '')
{
    $months = array(
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    );
    $month = '';
    for ($i = 1; $i <= 12; $i ++)
    {
        if ($i == $sel)
        {
            $month .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
        }
        else
        {
            $month .= '<option value="' . $i . '">' . $i . '</option>';
        }
    }
    return $month;
}

function days($sel = '')
{
    $day = '';
    for ($i = 1; $i <= 31; $i ++)
    {
        if ($i == $sel)
        {
            $day .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
        }
        else
        {
            $day .= '<option value="' . $i . '">' . $i . '</option>';
        }
    }
    return $day;
}

function redirect($link)
{
    if (! headers_sent())
    {
        header("Location: $link");
    }
    else
    {
        echo "<script language=Javascript>document.location.href='$link';</script>";
    }
    exit(0);
}

function createThumb($srcname, $destname, $maxwidth, $maxheight)
{
    global $config;
    $oldimg = $srcname; //$config['basepath']."/photo/".$srcname;
    $newimg = $destname; //$config['basepath']."/photo/".$destname;


    $imagedata = GetImageSize($oldimg);
    $imagewidth = $imagedata[0];
    $imageheight = $imagedata[1];
    $imagetype = $imagedata[2];

    $shrinkage = 1;

    if ($imagewidth > $maxwidth)
    {
        $shrinkage = $maxwidth / $imagewidth;
    }

    if ($shrinkage != 1)
    {
        $dest_height = $shrinkage * $imageheight;
        $dest_width = $maxwidth;
    }
    else
    {
        $dest_height = $imageheight;
        $dest_width = $imagewidth;
    }

    if ($dest_height > $maxheight)
    {
        $shrinkage = $maxheight / $dest_height;
        $dest_width = $shrinkage * $dest_width;
        $dest_height = $maxheight;
    }

    if ($imagetype == 2)
    {
        $src_img = imagecreatefromjpeg($oldimg);
        $dst_img = imageCreateTrueColor($dest_width, $dest_height);
        ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $imagewidth, $imageheight);
        imagejpeg($dst_img, $newimg, 100);
        imagedestroy($src_img);
        imagedestroy($dst_img);
    }
    else if ($imagetype == 3)
    {
        $src_img = imagecreatefrompng($oldimg);
        $dst_img = imageCreateTrueColor($dest_width, $dest_height);
        ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $imagewidth, $imageheight);
        imagepng($dst_img, $newimg, 100);
        imagedestroy($src_img);
        imagedestroy($dst_img);
    }
    else
    {
        $src_img = imagecreatefromgif($oldimg);
        $dst_img = imageCreateTrueColor($dest_width, $dest_height);
        ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $imagewidth, $imageheight);
        imagejpeg($dst_img, $newimg, 100);
        imagedestroy($src_img);
        imagedestroy($dst_img);
    }
}

function check_field_exists($fvalue, $field, $table)
{
    global $conn;
    $sql = "SELECT count(*) AS `total` FROM `$table` WHERE
           `$field`='" . mysql_clean($fvalue) . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $tmp = mysql_fetch_assoc($result);
    if ($tmp['total'] > 0)
    {
        return 1;
    }
    else
    {
        return 0;
    }
}

function timediff($my_time, $current_time = '')
{
    $time1 = strtotime($my_time);

    if ($current_time == '')
    {
        $time2 = $_SERVER['REQUEST_TIME'];
    }
    else
    {
        $time2 = strtotime($current_time);
    }

    $diff = $time2 - $time1;
    $second = $diff % 60;
    $minutes = ($diff / 60) % 60;
    $hours = ($diff / 3600) % 24;
    $days = ($diff / (3600 * 24)) % 30;
    $x = array();
    $x['days'] = $days;
    $x['hours'] = $hours;
    $x['minutes'] = $minutes;
    $x['seconds'] = $second;

    return $x;
}

function add_item($table, $field, $query, $new)
{
    global $conn;
    $sql = "SELECT `$field` FROM `$table` WHERE $query";
    $result = mysql_query($sql) or mysql_die($sql);
    $tmp = mysql_fetch_assoc($result);
    $type = explode('|', $tmp[$field]);
    $type[] = $new;
    $type = array_unique($type);
    sort($type);
    $new_type = implode('|', $type);
    $sql = "UPDATE $table SET $field='$new_type|' WHERE $query";
    mysql_query($sql) or mysql_die($sql);
}

function remove_item($table, $field, $query, $item)
{
    global $conn;
    $sql = "SELECT `$field` FROM `$table` WHERE $query";
    $result = mysql_query($sql) or mysql_die($sql);
    $tmp = mysql_fetch_assoc($result);
    $new_type = str_replace("|$item|", '|', $tmp[$field]);
    $sql = "UPDATE `$table` SET `$field`='$new_type' WHERE $query";
    mysql_query($sql) or mysql_die($sql);
}

function format_size($size)
{
    if ($size['type'] == 'byte')
    {

    }
    else
    {
        if ($size < 1024)
        {
            $output = round($size, 2) . ' MB';
        }
        else
        {
            $output = round($size / 1024, 2) . ' GB';
        }
    }
    return $output;
}

function upload_jpg($FILE, $var_name, $file_name, $img_width = 128, $dir = "upload/", $rename = '')
{

    if ($FILE[$var_name]['name'])
    {
        $file_url = $dir . uniqid("") . tmp;
        $ext = strrchr($FILE[$var_name]['name'], '.');
        move_uploaded_file($FILE[$var_name]['tmp_name'], $file_url);

        if ($FILE[$var_name]['error'] > 0)
        {
            $err = 'Error occurs while uploading file';
        }
        else if (strtolower($ext) == '.jpg')
        {
            $img = @imagecreatefromjpeg($file_url);
            $size = @getimagesize($file_url);
            $width = $size[0];
            $height = $size[1];

            if ($width > $img_width)
            {
                $percentage = $img_width / $width;
                $width *= $percentage;
                $height *= $percentage;

                $img_r = @imagecreatetruecolor($width, $height);
                @imagecopyresampled($img_r, $img, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
            }
            else
            {
                $img_r = $img;
            }

            $pic_name = $dir . $file_name;
            @ImageJpeg($img_r, $pic_name, 100);
            //                       rename("$pic_name", "$dir"."$rename");
            @unlink($file_url);
        }
        else
        {
            @unlink($file_url);
            $err = 'File must be as .jpg format';
        }
    }

    return $err;
}

function cc_month($sel = '')
{
    $month = '';

    for ($i = 1; $i <= 12; $i ++)
    {
        if ($i <= 9)
        {
            $j = '0' . $i;
        }
        else
        {
            $j = $i;
        }

        if ($i == $sel)
        {
            $month .= "<option value='$i' selected>$j</option>";
        }
        else
        {
            $month .= "<option value='$i'>$j</option>";
        }
    }
    return $month;
}

function cc_year($sel = '')
{
    $year = '';

    for ($i = 2004; $i <= 2020; $i ++)
    {
        if ($i == $sel)
        {
            $year .= "<option value='$i' selected>$i</option>";
        }
        else
        {
            $year .= "<option value='$i'>$i</option>";
        }
    }
    return $year;
}

function check_subscriber($space = 0)
{
    global $conn , $config;
    $err = '';
    $sql = "SELECT * FROM `subscriber` WHERE
           `UID`='" . (int) $_SESSION['UID'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $subs = mysql_fetch_assoc($result);
    $sql = "SELECT * FROM `packages` WHERE
           `package_id`=" . $subs['pack_id'];
    $result = mysql_query($sql) or mysql_die($sql);
    $pack = mysql_fetch_assoc($result);
    if ($pack['package_videos'] != 0 && ($subs['total_video'] >= $pack['package_videos']))
    {
        $err = 'You cannot upload more than ' . $pack['package_videos'] . ' videos';
        $type = 'limit';
    }
    else if ($subs['used_space'] + $space >= $pack['package_space'])
    {
        $err = 'You cannot upload more than ' . format_size($pack['package_space']) . ' space';
        $type = 'space';
    }

    if ($err != '')
    {
        $uid = $_SESSION['UID'];
        header('Location: ' . VSHARE_URL . '/renew_account.php?uid=' . $uid . '&err=' . $err);
        exit();
    }
}

function fx_replace($key, $value, $new_value)
{
    $re_value = str_replace($key, $new_value, $value);
    return $re_value;
}

function checklogin()
{
    if (isset($_SESSION['UID']))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function paginate($total, $result_per_page, $page_url, $page_id, $current_page)
{
    $pagination_output = '';
    $numPages = ceil($total / $result_per_page);

    $offset = 4;
    $span = ($offset * 2) + 1;

    if ($numPages > 1)
    {
        if ($current_page > 1)
        {
            $prevPage = $current_page - 1;
            $pagination_output .= "<a class='pagination_prev' href='$page_url/$prevPage'>&lt;</a> &nbsp; ";
        }

        if ($current_page > $offset)
        {
            $pagination_output .= "<a class='pagination' href='$page_url/1'>1</A> ... ";
        }

        if ($numPages > $span)
        {
            if ($current_page <= $offset)
            {
                $start = 1;
            }
            else if ($current_page >= ($numPages - $offset))
            {
                $start = $numPages - $span;
            }
            else
            {
                $start = $current_page - $offset;
            }
        }
        else
        {
            $start = 1;
            $span = $numPages;
        }

        $limit = $span + (($start != 1) ? $start : 0);

        for ($i = $start; $i <= $limit; $i ++)
        {
            if ($i != $current_page)
            {
                $pagination_output .= "<a class='pagination' href='$page_url/$i'>";
            }
            else
            {
                $pagination_output .= "<span class='pagination_active'>";
            }

            $pagination_output .= $i;

            if ($i != $current_page)
            {
                $pagination_output .= "</a>";
            }
            else
            {
                $pagination_output .= "</span>";
            }
        }

        if ($current_page < ($numPages - $offset))
        {
            $pagination_output .= " ... <a class='pagination' href='$page_url/$numPages'>$numPages</a>";
        }

        if ($current_page != $numPages)
        {
            $nextPage = $current_page + 1;
            $pagination_output .= " &nbsp; <a class='pagination_next' href='$page_url/$nextPage'>&gt;</a>";
        }
    }
    return $pagination_output;
}

function disallow_user_names($user_name)
{
    $err = '';
    $user_name = mb_strtolower($user_name);
    $sql = "SELECT * FROM `disallow` WHERE
           `disallow_username`='" . mysql_clean($user_name) . "'";
    $result = mysql_query($sql) or mysql_die($sql);

    if (mysql_num_rows($result) > 0)
    {
        $err = 1;
    }

    return $err;
}

function download($source, $destination)
{
    $written = null;
    $source = str_replace(' ', '%20', html_entity_decode($source));
    $read = fopen("$source", "r");
    if (! $read)
    {
        $err = 0;
        return $err;
    }
    $write = fopen($destination, "wb");
    if (! $write)
    {
        $err = 1;
        return $err;
    }

    while (! feof($read))
    :
        $written += fwrite($write, fread($read, 1024));
    endwhile;
    fclose($read);
    fclose($write);
    return $written;
}

function mysql_clean($value, $is_magic_quote_removed = 0)
{
    if (get_magic_quotes_gpc() && $is_magic_quote_removed == 0)
    {
        $value = stripslashes($value);
    }

    if (! is_numeric($value))
    {
        $value = mysql_real_escape_string($value);
    }

    return $value;
}

function mysql_die($msg)
{
    echo "<FONT face=verdana SIZE=2 COLOR=#FF0000><B>ERROR: Unable to execute query</B></FONT><BR>";
    echo "<pre>$msg</pre>";
    echo "<FONT face=arial SIZE=2 COLOR=#0000FF><B>";
    echo mysql_error();
    echo "</B></FONT><BR>";
    exit(0);
}

function write_log($txt, $logfile = 1, $echo = 0, $extension = 'txt')
{
    global $config;

    if ($logfile == 1)
    {
        $log_file = VSHARE_DIR . '/templates_c/debug.txt';
    }
    else
    {
        $log_file = VSHARE_DIR . '/templates_c/' . $logfile . '.' . $extension;
    }
    $now = date("Y-m-d G:i:s");
    error_log("$now $txt\n\r", 3, $log_file);

    if ($echo == 1)
    {
        echo $txt;
    }

}

function get_config($config_name)
{
    $sql = "SELECT * FROM `config` WHERE
           `config_name`='$config_name'";
    $result = mysql_query($sql) or mysql_die($sql);
    $config_data = mysql_fetch_assoc($result);
    return $config_data['config_value'];
}

function check_subscriber_duration($uid)
{
    global $config , $lang;
    $sql = "SELECT * FROM `subscriber` WHERE
           `UID`='" . (int) $uid . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $duration = mysql_fetch_assoc($result);
    $expired_time = $duration['expired_time'];
    $subscribe_time = $duration['subscribe_time'];

    if ($expired_time == '0000-00-00 00:00:00')
    {
        $expired_time = date("Y-m-d h:i:s");
        $sql = "UPDATE `subscriber` SET
               `expired_time`='$expired_time' WHERE
               `UID`='" . (int) $uid . "'";
        mysql_query($sql) or mysql_die($sql);
    }

    if ($subscribe_time == '0000-00-00 00:00:00')
    {
        $subscribe_time = date("Y-m-d h:i:s");
        $sql = "UPDATE `subscriber` SET
               `subscribe_time`='$subscribe_time' WHERE
               `UID`='" . (int) $uid . "'";
        mysql_query($sql) or mysql_die($sql);
    }

    $expired_time_in_sec = strtotime($expired_time);
    $current_time = $_SERVER['REQUEST_TIME'];

    if ($expired_time_in_sec < $current_time)
    {
        $expired_time = date("j F Y", strtotime($expired_time));
        $msg = str_replace('[EXPIRED_TIME]', $expired_time, $lang['subscriber_expired']);
        set_message($msg, 'success');
        $redirect_url = VSHARE_URL . '/renew_account.php?uid=' . $uid;
        redirect($redirect_url);
    }
}

function check_subscriber_space($user_id)
{
    global $config , $lang;
    $err = '';
    if (empty($user_id))
    {
        $user_id = 0;
    }
    $sql = "SELECT * FROM `subscriber` WHERE
           `UID`='" . (int) $user_id . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $subscribe_info = mysql_fetch_assoc($result);

    $sql = "SELECT * FROM `packages` WHERE
           `package_id`='" . (int) $subscribe_info['pack_id'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $pack = mysql_fetch_assoc($result);

    if ($subscribe_info['used_space'] >= $pack['package_space'])
    {
        $msg = $lang['subscriber_space'];
        $space_used = format_size($subscribe_info['used_space']);
        $msg = str_replace('[SPACE_USED]', $space_used, $msg);
        set_message($msg, 'success');
        $redirect_url = VSHARE_URL . '/renew_account.php?uid=' . $user_id;
        redirect($redirect_url);
    }
}

function check_subscriber_videos($uid)
{
    global $config , $lang;
    $err = '';
    $sql = "SELECT * FROM `subscriber` WHERE
           `UID`='" . (int) $uid . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $subscribe_info = mysql_fetch_assoc($result);

    $sql = "SELECT * FROM `packages` WHERE
           `package_id`='" . (int) $subscribe_info['pack_id'] . "'";
    $tmp_result = mysql_query($sql) or mysql_die($sql);
    $pack = mysql_fetch_assoc($tmp_result);

    if ($pack['package_videos'] != 0 && $subscribe_info['total_video'] >= $pack['package_videos'])
    {
        $msg = $lang['subscriber_video'];
        $total_videos = $subscribe_info['total_video'];
        $msg = str_replace('[TOTAL_VIDEOS]', $total_videos, $msg);
        set_message($msg, 'success');
        $redirect_url = VSHARE_URL . '/renew_account.php?uid=' . $uid;
        redirect($redirect_url);
    }
}

function find_age($dob)
{
    list($birth_year, $birth_month, $birth_day) = explode('-', $dob);
    $datestamp = date('d.m.Y');
    $t_arr = explode('.', $datestamp);
    $current_day = $t_arr[0];
    $current_month = $t_arr[1];
    $current_year = $t_arr[2];
    $year_dif = $current_year - $birth_year;

    if (($birth_month > $current_month) || ($birth_month == $current_month && $current_day < $birth_day))
    {
        $age = $year_dif - 1;
    }
    else
    {
        $age = $year_dif;
    }

    return $age;
}

function mysql_fetch_all($result)
{
    $records = array();
    while ($record = mysql_fetch_assoc($result))
    {
        $records[] = $record;
    }
    return $records;
}

function password_generator($lenght = 8)
{

    $password = array();

    for ($i = 0; $i <= $lenght; $i ++)
    {
        $password[$i] = chr(rand(97, 122));

        switch ($password[$i])
        {
            case 'a':
                $password[$i] = 4;
                break;
            case 'b':
                $password[$i] = 8;
                break;
            case 'e':
                $password[$i] = 3;
                break;
            case 'i':
                $password[$i] = 1;
                break;
            case 'o':
                $password[$i] = 0;
                break;
            case 's':
                $password[$i] = 5;
                break;
        }

        $third = $i / 3;

        if (is_int($third))
        {
            $password[$i] = strtoupper($password[$i]);
        }
    }
    return implode('', $password);
}

function sec2hms($sec, $useColon = true)
{
    $hms = '';
    $hours = intval(intval($sec) / 3600);

    if ($hours > 0)
    {
        $hms .= str_pad($hours, 2, '0', STR_PAD_LEFT) . ':';
    }

    $minutes = intval(($sec / 60) % 60);

    if ($minutes > 0)
    {
        $hms .= str_pad($minutes, 2, '0', STR_PAD_LEFT) . ':';
    }
    else
    {
        $hms .= '00:';
    }

    if ($sec > 59)
    {
        $seconds = intval($sec % 60);
    }
    else
    {
        $sec_tmp = round($sec, 2);
        $seconds = $sec_tmp;
    }

    $hms .= str_pad($seconds, 2, '0', STR_PAD_LEFT);
    return $hms;
}

function db_close()
{
    global $conn;
    mysql_close($conn);
}

function is_ip($ip)
{
    $valid = TRUE;

    $ip = explode('.', $ip);

    if (count($ip) != 4)
    {
        return FALSE;
    }

    foreach ($ip as $block)
    {
        if (! is_numeric($block) || $block > 255 || $block < 1)
        {
            $valid = FALSE;
        }
    }

    return $valid;
}

function set_message($message, $message_type)
{
    $_SESSION['vshare_message'] = $message;
    $_SESSION['vshare_message_type'] = $message_type;
}

function strlen_uni($string)
{
    return mb_strlen($string, 'UTF-8');
}

function htmlspecialchars_uni($text, $entities = true)
{
    return str_replace(array(
        '<',
        '>',
        '"'
    ), array(
        '&lt;',
        '&gt;',
        '&quot;'
    ), preg_replace('/&(?!' . ($entities ? '#[0-9]+|shy' : '(#[0-9]+|[a-z]+)') . ';)/si', '&amp;', $text));
}

function array_remove_duplicate($source_array)
{
    $source_array = array_unique($source_array);
    $array_new = array();

    foreach ($source_array as $key)
    {
        $array_new[] = $key;
    }
    return $array_new;
}

function check_config_exists($config_name)
{
    global $config;

    $sql = "SELECT * FROM `config` WHERE
		   `config_name`='" . mysql_clean($config_name) . "'";
    $result = mysql_query($sql);

    if (mysql_num_rows($result) > 0)
    {
        return 1;
    }
    else
    {
        return 0;
    }

}

function update_user_video_count($user_id, $action = 1)
{
    if ($action == 1)
    {
        $sql = "UPDATE `users` SET
               `user_videos`=`user_videos`+1 WHERE
               `user_id`='" . (int) $user_id . "'";
    }
    else
    {
        $sql = "UPDATE `users` SET
               `user_videos`=`user_videos`-1 WHERE
               `user_id`='" . (int) $user_id . "'";
    }

    mysql_query($sql) or mysql_die();
}

function get_family_filter()
{
	global $config;

	if ($config['family_filter'] == 1)
	{
		if (!isset($_SESSION['FAMILY_FILTER']))
		{
			if (isset($_SESSION['UID']))
			{
				$sql = "SELECT `user_adult` FROM `users` WHERE
				       `user_id`='" . (int) $_SESSION['UID'] . "'";
				$result = mysql_query($sql) or mysql_die($sql);
				$tmp = mysql_fetch_assoc($result);
				$user_adult = $tmp['user_adult'];
			}
			else
			{
				$user_adult = 1;
			}

			$_SESSION['FAMILY_FILTER'] = $user_adult;
		}

		return $_SESSION['FAMILY_FILTER'];
	}

	return 0;
}
