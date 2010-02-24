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

require '../include/config.php';
require '../include/class.channels.php';
require '../include/language/' . LANG . '/lang_admin_group_edit.php';

check_admin_login();

if (isset($_POST['submit']))
{
    $_POST['keyword'] = preg_replace('/[\,\s]+/', ' ', $_POST['keyword']);
    
    $sql = "UPDATE `groups` SET
           `group_name`='" . mysql_clean($_POST['group_name']) . "',
           `group_keyword`='" . mysql_clean($_POST['keyword']) . "',
           `group_description`='" . mysql_clean($_POST['gdescn']) . "',
           `group_url`='" . mysql_clean($_POST['gurl']) . "',
           `group_type`='" . mysql_clean($_POST['type']) . "',
           `group_featured`='" . mysql_clean($_POST['featured']) . "',
           `group_upload`='" . mysql_clean($_POST['gupload']) . "',
           `group_posting`='" . mysql_clean($_POST['gposting']) . "',
           `group_image`='" . mysql_clean($_POST['gimage']) . "' WHERE
           `group_id`='" . (int) $_GET['gid'] . "'";
    mysql_query($sql) or mysql_die($sql);
    
    if (! isset($_POST['channel']) || count($_POST['channel']) < 1)
    {
        $err = $lang['group_channel_null'];
    }
    else
    {
        $sql = "UPDATE `groups` SET
               `group_channels`='0|" . implode('|', $_POST['channel']) . "|0' WHERE
               `group_id`='" . (int) $_GET['gid'] . "'";
        mysql_query($sql) or mysql_die($sql);
    }
    
    if ($err == '')
    {
        set_message($lang['group_edited'], 'success');
        $redirect_url = VSHARE_URL . '/admin/group_view.php?group_id=' . $_GET['gid'];
        redirect($redirect_url);
    }
}

$sql = "SELECT * FROM `groups` WHERE
       `group_id`='" . (int) $_GET['gid'] . "'";
$result = mysql_query($sql) or mysql_die($sql);
$group_info = mysql_fetch_assoc($result);

$type_public = $type_private = $type_protected = '';

if ($group_info['group_type'] == 'public')
{
    $type_public = "selected=\"selected\"";
}
else if ($group_info['group_type'] == 'private')
{
    $type_private = "selected=\"selected\"";
}
else if ($group_info['group_type'] == 'protected')
{
    $type_protected = "selected=\"selected\"";
}

$type_box = "
<option value='public' $type_public>Public</option>
<option value='private' $type_private>Private</option>
<option value='protected' $type_protected>Protected</option>";

$smarty->assign('type_box', $type_box);

$gupload_immediate = $gupload_owner_approve = $gupload_owner_only = '';

if ($group_info['group_upload'] == 'immediate')
{
    $gupload_immediate = "selected=\"selected\"";
}
else if ($group_info['group_upload'] == 'owner_approve')
{
    $gupload_owner_approve = "selected=\"selected\"";
}
else if ($group_info['group_upload'] == 'owner_only')
{
    $gupload_owner_only = "selected=\"selected\"";
}

$upload_box = "
<option value='immediate' $gupload_immediate>immediate</option>
<option value='owner_approve' $gupload_owner_approve>owner_approve</option>
<option value='owner_only' $gupload_owner_only>owner_only</option>";

$smarty->assign('upload_box', $upload_box);

$gposting_immediate = $gposting_owner_approve = $gposting_owner_only = '';

if ($group_info['group_posting'] == 'immediate')
{
    $gposting_immediate = "selected=\"selected\"";
}
else if ($group_info['group_posting'] == 'owner_approve')
{
    $gposting_owner_approve = "selected=\"selected\"";
}
else if ($group_info['group_posting'] == 'owner_only')
{
    $gposting_owner_only = "selected=\"selected\"";
}

$posting_box = "
<option value='immediate' $gposting_immediate>immediate</option>
<option value='owner_approve' $gposting_owner_approve>owner_approve</option>
<option value='owner_only' $gposting_owner_only>owner_only</option>";

$smarty->assign('posting_box', $posting_box);

$gimage_immediate = $gimage_owner_only = '';

if ($group_info['group_image'] == 'immediate')
{
    $gimage_immediate = "selected=\"selected\"";
}
else if ($group_info['group_image'] == 'owner_only')
{
    $gimage_owner_only = "selected=\"selected\"";
}

$icon_box = "
<option value='immediate' $gimage_immediate>immediate</option>
<option value='owner_only' $gimage_owner_only>owner_only</option>";

$smarty->assign('icon_box', $icon_box);

$featured_yes = $featured_no = '';

if ($group_info['group_featured'] == 'yes')
{
    $featured_yes = "selected=\"selected\"";
}
else
{
    $featured_no = "selected=\"selected\"";
}

$featured_box = "
<option value='yes' $featured_yes>Yes</option>
<option value='no' $featured_no>No</option>";

$smarty->assign('featured_box', $featured_box);

$ch_checkbox = '';
$mych = explode('|', $group_info['group_channels']);
$ch = channels::get_all();

for ($i = 0; $i < count($ch); $i ++)
{
    
    if (in_array($ch[$i]['channel_id'], $mych))
    {
        $checked = "checked=\"checked\"";
    }
    else
    {
        $checked = "";
    }
    
    $ch_checkbox .= '<input type="checkbox" name="channel[]" value="' . $ch[$i]['channel_id'] . '"' . $checked . '/>' . htmlspecialchars($ch[$i]['channel_name'], ENT_QUOTES, 'UTF-8') . '<br />';
}

$smarty->assign('ch_checkbox', $ch_checkbox);
$smarty->assign('group', $group_info);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/group_edit.tpl');
$smarty->display('admin/footer.tpl');
db_close();
