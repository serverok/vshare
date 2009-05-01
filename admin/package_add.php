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
require '../include/language/' . LANG . '/lang_admin_package_add.php';

check_admin_login();

if (isset($_POST['add_package']))
{
    if ($_POST['pack_name'] == '')
    {
        $err = $lang['package_name_empty'];
    }
    else if ($_POST['pack_desc'] == '')
    {
        $err = $lang['package_description_empty'];
    }
    else if ($_POST['space'] == '')
    {
        $err = $lang['package_space_empty'];
    }
    else if ($_POST['price'] == '')
    {
        $err = $lang['package_price_empty'];
    }
    
    if ($err == '')
    {
        $sql = "INSERT INTO `packages` SET
               `package_name`='" . mysql_clean($_POST['pack_name']) . "',
               `package_description`='" . mysql_clean($_POST['pack_desc']) . "',
               `package_space`='" . mysql_clean($_POST['space']) . "',
               `package_price`='" . mysql_clean($_POST['price']) . "',
               `package_videos`='" . mysql_clean($_POST['video_limit']) . "',
               `package_period`='" . mysql_clean($_POST['period']) . "',
               `package_status`='" . mysql_clean($_POST['status']) . "'";
        mysql_query($sql) or mysql_die($sql);
    }
    
    if ($err == '')
    {
        set_message($lang['package_added'], 'success');
        $redirect_url = VSHARE_URL . '/admin/packages.php';
        redirect($redirect_url);
    }
}

$period_ops = "
<option value='Month'>Month</option>
<option value='Year'>Year</option>";

$status_ops = "
<option value='Active'>Active</option>
<option value='Inactive'>Inactive</option>";

$smarty->assign('period_ops', $period_ops);
$smarty->assign('status_ops', $status_ops);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/package_add.tpl');
$smarty->display('admin/footer.tpl');
db_close();