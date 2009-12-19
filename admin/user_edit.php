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
require '../include/country.class.php';
require '../include/language/' . LANG . '/lang_admin_user_edit.php';

check_admin_login();

if (isset($_POST['submit']))
{
    $sql = "UPDATE `users` SET
           `user_email`='" . mysql_clean($_POST['email']) . "',
           `user_first_name`='" . mysql_clean($_POST['fname']) . "',
           `user_last_name`='" . mysql_clean($_POST['lname']) . "',
           `user_about_me`='" . mysql_clean($_POST['aboutme']) . "',
           `user_website`='" . mysql_clean($_POST['website']) . "',
           `user_town`='" . mysql_clean($_POST['hometown']) . "',
           `user_city`='" . mysql_clean($_POST['city']) . "',
           `user_country`='" . mysql_clean($_POST['country']) . "',
           `user_occupation`='" . mysql_clean($_POST['occupation']) . "',
           `user_company`='" . mysql_clean($_POST['company']) . "',
           `user_school`='" . mysql_clean($_POST['school']) . "',
           `user_interest_hobby`='" . mysql_clean($_POST['interest_hobby']) . "',
           `user_fav_movie_show`='" . mysql_clean($_POST['fav_movie_show']) . "',
           `user_fav_music`='" . mysql_clean($_POST['fav_music']) . "',
           `user_fav_book`='" . mysql_clean($_POST['fav_book']) . "',
           `user_email_verified`= '" . mysql_clean($_POST['emailverified']) . "',
           `user_account_status`='" . mysql_clean($_POST['account_status']) . "' WHERE
           `user_id`='" . (int) $_GET['uid'] . "'";
    
    mysql_query($sql) or mysql_die($sql);
    
    set_message($lang['user_info_updated'], 'success');
    $redirect_url = VSHARE_URL . '/admin/user_view.php?user_id=' . $_GET['uid'];
    redirect($redirect_url);
}

$sql = "SELECT * FROM `users` WHERE
       `user_id`='" . (int) $_GET['uid'] . "'";
$result = mysql_query($sql) or mysql_die($sql);
$user = mysql_fetch_assoc($result);

$countries = new countries();
$smarty->assign('country_box', $countries->country_options($user['user_country']));

if ($user['user_email_verified'] == 'yes')
{
    $emailverified_yes = "selected=\"selected\"";
    $emailverified_no = '';
}
else
{
    $emailverified_no = "selected=\"selected\"";
    $emailverified_yes = "";
}

$email_ver_box = "
    <option value='yes' $emailverified_yes>Yes</option>
    <option value='no' $emailverified_no>No</option>
";

$smarty->assign('email_ver_box', $email_ver_box);

if ($user['user_account_status'] == 'Active')
{
    $account_status_inactive = '';
    $account_status_active = "selected=\"selected\"";
}
else
{
    $account_status_inactive = "selected=\"selected\"";
    $account_status_active = "";
}

$account_status_box = "
    <option value='Active' $account_status_active>Active</option>
    <option value='Inactive' $account_status_inactive>Inactive</option>
";

$smarty->assign('account_status_box', $account_status_box);
$smarty->assign('user', $user);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/user_edit.tpl');
$smarty->display('admin/footer.tpl');
db_close();
