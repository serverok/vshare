<?php
/******************************************************************************
 *
 * COMPANY: BuyScripts.in
 * PROJECT: vShare Youtube Clone
 * VERSION: [VSHARE_VERSION]
 * LICENSE: http://buyscripts.in/vshare-license
 * WEBSITE: http://buyscripts.in/vshare-youtube-clone
 *
 * This program is a commercial software and any kind of using it must agree
 * to vShare license.
 *
 ******************************************************************************/

require 'admin_config.php';
require '../include/config.php';
require '../include/language/' . LANG . '/admin/upload_watermark.php';

Admin::auth();

if (isset($_POST['submit'])) {

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . DB::quote($_POST['watermark_url']) . "' WHERE
           `soption`='watermark_url'";
    DB::query($sql);

    $smarty->assign('watermark_url', $_POST['watermark_url']);

    if (is_uploaded_file($_FILES['upfile']['tmp_name'])) {
        $upfile_type = $_FILES['upfile']['type'];

        if ($upfile_type == 'image/gif') {
            $new_file_name = VSHARE_DIR . '/templates/images/watermark.gif';

            if (move_uploaded_file($_FILES['upfile']['tmp_name'], $new_file_name)) {
                chmod($new_file_name, 0777);
                $msg = $lang['watermark_uploaded'];
            } else {
                $err = str_replace('[NEW_FILE_NAME]', $new_file_name, $lang['unable_to_move']);
            }
        } else {
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
DB::close();
