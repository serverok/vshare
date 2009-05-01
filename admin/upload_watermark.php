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
require '../include/language/' . LANG . '/lang_admin_upload_watermark.php';

check_admin_login();

if (isset($_POST['submit']))
{
    $sql = "UPDATE `sconfig` SET
           `svalue`='" . mysql_clean($_POST['watermark_url']) . "' WHERE
           `soption`='watermark_url'";
    mysql_query($sql) or mysql_die();
    
    $smarty->assign('watermark_url', $_POST['watermark_url']);
    
    if (is_uploaded_file($_FILES['upfile']['tmp_name']))
    {
        $upfile_type = $_FILES['upfile']['type'];
        
        if ($upfile_type == 'image/gif')
        {
            $new_file_name = VSHARE_DIR . '/templates/images/watermark.gif';
            
            if (move_uploaded_file($_FILES['upfile']['tmp_name'], $new_file_name))
            {
                chmod($new_file_name, 0777);
                $msg = $lang['watermark_uploaded'];
            }
            else
            {
                $err = str_replace('[NEW_FILE_NAME]', $new_file_name, $lang['unable_to_move']);
            }
        }
        else
        {
            $err = $lang['watermark_file_invalid'];
        }
    }
}

$smarty->assign('vshare_rand', $_SERVER['REQUEST_TIME']);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/upload_watermark.tpl');
$smarty->display('admin/footer.tpl');
db_close();
