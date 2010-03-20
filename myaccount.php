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

User::is_logged_in();

$sql = "SELECT * FROM `users` WHERE
       `user_name`='" . mysql_clean($_SESSION['USERNAME']) . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) == 0)
{
    set_message($lang['user_not_found'], 'error');
    $redirect_url = VSHARE_URL . '/index.php';
    redirect($redirect_url);
}

$user_info = mysql_fetch_assoc($result);

$smarty->assign('user_info', $user_info);
$smarty->assign('sub_menu', 'menu_user.tpl');
$smarty->display('header.tpl');
$smarty->display('myaccount.tpl');
$smarty->display('footer.tpl');
db_close();
