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

require '../include/config.php';

check_admin_login();

$server_id = isset($_GET['server_id']) ? $_GET['server_id'] : '';

$sql = "SELECT * FROM `servers` WHERE
       `id`='" . (int) $server_id . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) > 0)
{
    $server_info = mysql_fetch_assoc($result);
    if ($server_info['status'] == 1)
    {
        $new_status = 0;
        $enabled_or_disabled = 'Disabled';
    }
    else
    {
        $new_status = 1;
        $enabled_or_disabled = 'Enabled';
    }
    
    $sql = "UPDATE `servers` SET
           `status`='" . (int) $new_status . "' WHERE
           `id`='" . (int) $server_id . "'";
    mysql_query($sql) or mysql_die($sql);
    
    $msg = 'Server ' . $server_info['url'] . ' ' . $enabled_or_disabled;
    set_message($msg, 'success');
}
else
{
    set_message('Invalid server id', 'error');
}

db_close();
$redirect_url = VSHARE_URL . '/admin/server_manage.php';
redirect($redirect_url);
