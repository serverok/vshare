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
require '../include/language/' . LANG . '/lang_admin_group_search.php';

check_admin_login();

$found = 0;

if (! empty($_POST['group_name']))
{
    $sql = "SELECT * FROM `groups` WHERE
           `group_name`='" . mysql_clean($_POST['group_name']) . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    
    if (mysql_num_rows($result) == 0)
    {
        $err = str_replace('[GROUP_NAME]', $_POST['group_name'], $lang['group_not_found_name']);
    }
    else
    {
        $found = 1;
        $group_info = mysql_fetch_assoc($result);
        $group_id = $group_info['group_id'];
    }
}

if ($found > 0)
{
    $redirect_url = VSHARE_URL . '/admin/group_view.php?group_id=' . $group_id;
    redirect($redirect_url);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/group_search.tpl');
$smarty->display('admin/footer.tpl');
db_close();