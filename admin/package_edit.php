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
require '../include/language/' . LANG . '/lang_admin_package_edit.php';

check_admin_login();

if (isset($_POST['submit']))
{
    $package_trail_period = isset($_POST['package_trial_period']) ? $_POST['package_trial_period'] : '';
    
    $sql = "UPDATE `packages` SET
         `package_name`='" . mysql_clean($_POST['package_name']) . "',
         `package_description`='" . mysql_clean($_POST['package_description']) . "',
         `package_space`='" . mysql_clean($_POST['package_space']) . "',
         `package_price`= '" . mysql_clean($_POST['package_price']) . "',
         `package_videos`='" . mysql_clean($_POST['package_videos']) . "',
         `package_period`='" . mysql_clean($_POST['package_period']) . "',
         `package_status`='" . mysql_clean($_POST['package_status']) . "',
         `package_trial_period`='" . mysql_clean($package_trail_period) . "' WHERE
         `package_id`='" . (int) $_POST['package_id'] . "'";
    mysql_query($sql) or mysql_die($sql);
    
    if ($err == '')
    {
        set_message($lang['package_updated'], 'success');
        $redirect_url = VSHARE_URL . '/admin/package_view.php?package_id=' . $_POST['package_id'];
        redirect($redirect_url);
    }
}

$sql = "SELECT * FROM `packages` WHERE
       `package_id`='" . (int) $_GET['package_id'] . "'";
$result = mysql_query($sql) or mysql_die($sql);
$package = mysql_fetch_assoc($result);
$smarty->assign('package', $package);

if ($package['package_period'] == 'Day')
{
    $select_year = '';
    $select_month = '';
    $select_day = "selected=\"selected\"";
}
else if ($package['package_period'] == 'Month')
{
    $select_year = '';
    $select_month = "selected=\"selected\"";
    $select_day = '';
}
else if ($package['package_period'] == 'Year')
{
    $select_year = "selected=\"selected\"";
    $select_month = '';
    $select_day = '';
}

if ($package['package_status'] == 'Active')
{
    $select_active = "selected=\"selected\"";
    $select_inactive = '';
}
else if ($package['package_status'] == 'Inactive')
{
    $select_inactive = "selected=\"selected\"";
    $select_active = '';
}

if ((isset($package)) && ($package['package_trial'] == 'yes'))
{
    $select_month = '';
    $select_year = '';
}

$period_ops = "
<option value='Month' $select_month>Month</option>
<option value='Year' $select_year>Year</option>";

$status_ops = "
<option value='Active' $select_active>Active</option>
<option value='Inactive' $select_inactive>Inactive</option>";

$smarty->assign('period_ops', $period_ops);
$smarty->assign('status_ops', $status_ops);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/package_edit.tpl');
$smarty->display('admin/footer.tpl');
db_close();
