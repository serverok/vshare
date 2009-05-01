<?php
/******************************************************************************
 *
 *   COMPANY: BuyScripts.in
 *   PROJECT: vShare Youtube Clone
 *   VERSION: 2.7
 *   LISENSE: http://buyscripts.in/vshare-license.html
 *   WEBSITE: http://buyscripts.in/youtube_clone.html
 *
 *   This program is a commercial software and any kind of using it must agree 
 *   to vShare license.
 *
 ******************************************************************************/

require '../include/config.php';

check_admin_login();

$smarty->assign('vshare_version', $vshare_version);
$smarty->assign('vshare_release', $vshare_release);

# number of videos


$sql = "SELECT count(*) AS `total` FROM `videos` WHERE
       `video_active`='1'";
$result = mysql_query($sql);
$tmp = mysql_fetch_assoc($result);
$total_video = $tmp['total'];

$smarty->assign('total_video', $total_video);

# number of public videos


$sql = "SELECT count(*) AS `total` FROM `videos` WHERE
       `video_active`='1' AND
       `video_type`='public'";
$result = mysql_query($sql);
$tmp = mysql_fetch_assoc($result);
$total_public_video = $tmp['total'];

$smarty->assign('total_public_video', $total_public_video);

# number of private videos


$sql = "SELECT count(*) AS `total` FROM `videos` WHERE
       `video_active`='1' AND
       `video_type`='private'";
$result = mysql_query($sql);
$tmp = mysql_fetch_assoc($result);
$total_private_video = $tmp['total'];

$smarty->assign('total_private_video', $total_private_video);

# number of users


$sql = "SELECT count(*) AS `total` FROM `users`";
$result = mysql_query($sql);
$tmp = mysql_fetch_assoc($result);
$total_users = $tmp['total'];

$smarty->assign('total_users', $total_users);

# number of channels


$sql = "SELECT count(*) AS `total` FROM `channels`";
$result = mysql_query($sql);
$tmp = mysql_fetch_assoc($result);
$total_channel = $tmp['total'];

$smarty->assign('total_channel', $total_channel);

# number of groups


$sql = "SELECT count(*) AS `total` FROM `groups`";
$result = mysql_query($sql);
$tmp = mysql_fetch_assoc($result);
$total_groups = $tmp['total'];

$smarty->assign('total_groups', $total_groups);

# check version


$version_file = VSHARE_DIR . '/templates_c/version.txt';

if (file_exists($version_file))
{
    $last_check = filemtime($version_file);
    $time_now = $_SERVER['REQUEST_TIME'];
    $time_since_last_chek = ($time_now - $last_check) / (60 * 60);
    if ($time_since_last_chek > 48)
    {
        $check_version_now = 1;
    }
    else
    {
        $check_version_now = 0;
    }
}
else
{
    $check_version_now = 1;
}

$errno = 0;

if ($check_version_now == 1)
{
    $errstr = '';
    $version_info = '';
    
    if ($fsock = @fsockopen('buyscripts.in', 80, $errno, $errstr, 10))
    {
        @fputs($fsock, "GET /vshare/version.txt HTTP/1.1\r\n");
        @fputs($fsock, "HOST: buyscripts.in\r\n");
        @fputs($fsock, "Connection: close\r\n\r\n");
        
        $get_info = false;
        
        while (! @feof($fsock))
        {
            if ($get_info)
            {
                $version_info .= @fread($fsock, 1024);
            }
            else
            {
                if (@fgets($fsock, 1024) == "\r\n")
                {
                    $get_info = true;
                }
            }
        }
        
        @fclose($fsock);
    }
    
    $fp = fopen($version_file, 'w');
    fwrite($fp, $version_info);
    fclose($fp);
}

unset($version_info);

$version_info = file($version_file);

if (sizeof($version_info) == 2)
{
    $latest_version = trim($version_info[0]);
    $latest_release = $version_info[1];
}
else
{
    $latest_version = 2;
    $latest_release = 2;
}

$smarty->assign('latest_version', $latest_version);
$smarty->assign('latest_release', $latest_release);

if ($errno == 0 && strlen($latest_version) > 2)
{
    if ($vshare_version < $latest_version)
    {
        $smarty->assign('vshare_status', 'old');
    }
    else
    {
        $smarty->assign('vshare_status', 'new');
    }
}
$smarty->display('admin/header.tpl');
$smarty->display('admin/home.tpl');
$smarty->display('admin/footer.tpl');
db_close();
