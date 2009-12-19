<?php
/******************************************************************************
 *
 *   COMPANY: BuyScripts.in
 *   PROJECT: vShare Youtube Clone
 *   VERSION: 2.8
 *   LISENSE: http://buyscripts.in/vshare-license.html
 *   WEBSITE: http://buyscripts.in/youtube_clone.html
 *
 *   This program is a commercial software and any kind of using it must agree 
 *   to vShare license.
 *
 ******************************************************************************/

require '../include/config.php';

check_admin_login();

$advertisement_id = isset($_GET['adv_id']) ? $_GET['adv_id'] : 0;

$sql = "SELECT * FROM `adv` WHERE
       `adv_id`='" . (int) $advertisement_id . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) < 1)
{
    $redirect_url = VSHARE_URL . '/admin/advertisements.php';
    db_close();
    redirect($redirect_url);
}

$advertisement_info = mysql_fetch_assoc($result);
$current_adv_status = $advertisement_info['adv_status'];
if ($current_adv_status == 'Active')
{
    $new_adv_status = 'Inactive';
}
else
{
    $new_adv_status = 'Active';
}

$sql = "UPDATE `adv` SET
       `adv_status`='" . $new_adv_status . "' WHERE
       `adv_id`='" . (int) $advertisement_id . "'";
mysql_query($sql) or mysql_die($sql);

set_message('Advertisement status changed', 'success');
$redirect_url = VSHARE_URL . '/admin/advertisements.php';
db_close();
redirect($redirect_url);
