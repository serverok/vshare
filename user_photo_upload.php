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
require 'include/language/' . LANG . '/lang_user_photo_upload.php';

User::is_logged_in();

if (isset($_FILES['photo']['tmp_name']) && is_uploaded_file($_FILES['photo']['tmp_name']))
{
    $file_type = $_FILES['photo']['type'];
    $file_tmp_name = $_FILES['photo']['tmp_name'];
    
    if (($file_type == 'image/jpeg') || ($file_type == 'image/pjpeg'))
    {
        $image_size = getimagesize($file_tmp_name);
        
        if ($image_size[2] == 2)
        {
            User::upload_photo();
            $msg = $lang['photo_uploaded'];
        }
    }
    else
    {
        $err = str_replace('[FILE_TYPE]', $file_type, $lang['invalid_file']);
    }
}

$sql = "SELECT `user_id`, `user_photo` FROM `users` WHERE
       `user_id`='" . (int) $_SESSION['UID'] . "'";
$result = mysql_query($sql) or mysql_die($sql);
$user_info = mysql_fetch_assoc($result);

$photo_url = User::get_photo($user_info['user_photo'], $user_info['user_id']);
$smarty->assign('vshare_rand', $_SERVER['REQUEST_TIME']);
$smarty->assign('photo_url', $photo_url);
$smarty->assign('uid', $_SESSION['UID']);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('sub_menu', 'menu_home.tpl');
$smarty->display('header.tpl');
$smarty->display('user_photo_upload.tpl');
$smarty->display('footer.tpl');
db_close();
