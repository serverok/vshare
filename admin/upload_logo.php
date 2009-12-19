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
require '../include/language/' . LANG . '/lang_admin_upload_logo.php';

check_admin_login();

if (isset($_POST['submit']))
{
    if (is_uploaded_file($_FILES['logo']['tmp_name']))
    {
        $upfile_type = $_FILES['logo']['type'];
        
        if (($upfile_type == 'image/jpeg') or ($upfile_type == 'image/pjpeg'))
        {
            $new_file_name = VSHARE_DIR . '/templates/images/logo.jpg';
            
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $new_file_name))
            {
                chmod($new_file_name, 0777);
                $msg = $lang['logo_uploaded'];
            }
            else
            {
                $err = str_replace('[NEW_FILE_NAME]', $new_file_name, $lang['unable_to_move']);
            }
        }
        else
        {
            $err = $lang['logo_file_invalid'];
        }
    }
}

$smarty->assign('vshare_rand', $_SERVER['REQUEST_TIME']);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/upload_logo.tpl');
$smarty->display('admin/footer.tpl');
db_close();
