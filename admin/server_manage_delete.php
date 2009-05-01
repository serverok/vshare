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
require '../include/language/' . LANG . '/lang_admin_server_manage_delete.php';

check_admin_login();

$serverId = isset($_GET['id']) ? $_GET['id'] : 0;

$sql = "SELECT * FROM `servers` WHERE
        `id`='" . (int) $serverId . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) == 1)
{
    $serverRow = mysql_fetch_assoc($result);
}
else
{
    $err = $lang['server_not_found'];
    set_message($err, 'error');
}

if ($err == '')
{
    if ($serverRow['server_type'] == 1)
    {
        $sql = "SELECT count(*) AS `total` FROM `videos` WHERE
    		   `video_thumb_server_id`='" . (int) $serverId . "'";
    }
    else
    {
        $sql = "SELECT count(*) AS `total` FROM `videos` WHERE
    		   `video_server_id`='" . (int) $serverId . "'";
    }
    
    $result = mysql_query($sql) or mysql_die($sql);
    $tmp = mysql_fetch_assoc($result);
    
    if ($tmp['total'] == 0)
    {
        $sql = "DELETE FROM `servers` WHERE
               `id`='" . (int) $serverId . "'";
        mysql_query($sql) or mysql_die($sql);
        $msg = $lang['server_deleted'];
    }
    else
    {
        if ($serverRow['server_type'] == 1)
        {
            $msg = $lang['cannot_delete_thumb_server'];
        }
        else
        {
            $msg = $lang['cannot_delete_video_server'];
        }
    }
    set_message($msg, 'success');
}

db_close();
$redirect_url = VSHARE_URL . '/admin/server_manage.php';
redirect($redirect_url);
