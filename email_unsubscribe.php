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

require 'include/config.php';
require 'include/language/' . LANG . '/lang_email_unsubscribe.php';

$vkey = isset($_GET['vkey']) ? $_GET['vkey'] : 0;
$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
$unsubscribed_success = 0;

$sql = "SELECT `user_id` FROM `users` WHERE
	   `user_name`='" . mysql_clean($user_name) . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) != 1)
{
		echo $lang['user_not_found'];
		exit;
}

$user_info = mysql_fetch_assoc($result);

$data1 = 'UNSUBSCRIBE_' . $user_info['user_id'];

$sql = "SELECT * FROM `verify_code` WHERE
	   `vkey`='" . mysql_clean($vkey) . "' AND
	   `data1`='" . mysql_clean($data1) . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) != 1)
{
	echo $lang['invalid_auth_key'];
	exit;
}
				
if (isset($_POST['submit']))
{
        if ($_POST['submit'] == 'Unsubscribe')
        {
			$sql = "UPDATE `users` SET `user_subscribe_admin_mail`='0' WHERE
				   `user_id`='" . $user_info['user_id'] . "'";
			$result = mysql_query($sql) or mysql_die($sql);
			
			$unsubscribe_txt = str_replace('[PRIVACY_SETTINGS_URL]', VSHARE_URL . '/privacy/', $lang['unsubscribed_success']);
			$unsubscribe_txt = str_replace('[SITE_NAME]', $config['site_name'], $unsubscribe_txt);
			$smarty->assign('unsubscribe_txt',$unsubscribe_txt);
			$unsubscribed_success = 1;
                
		}
		else
		{
            redirect(VSHARE_URL);
		}
}

$smarty->assign('unsubscribed_success', $unsubscribed_success);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('email_unsubscribe.tpl');
$smarty->display('footer.tpl');
db_close();
