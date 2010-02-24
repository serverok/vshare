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
require '../include/language/' . LANG . '/lang_admin_email_edit.php';

check_admin_login();

$sql = "SELECT * FROM `email_templates` WHERE
       `email_id`='" . mysql_clean($_GET['email_id']) . "'";
$result = mysql_query($sql) or mysql_die($sql);
$email = mysql_fetch_assoc($result);
$email['email_body'] = htmlentities($email['email_body'], ENT_QUOTES, 'UTF-8');
$smarty->assign('email', $email);

if (isset($_POST['submit']))
{
    $sql = "UPDATE `email_templates` SET
           `email_subject`='" . mysql_clean($_REQUEST['email_subject']) . "',
           `email_body`='" . mysql_clean($_REQUEST['email_body']) . "',
           `comment`='" . mysql_clean($_REQUEST['comment']) . "' WHERE
           `email_id`='" . mysql_clean($_GET['email_id']) . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    set_message($lang['email_updated'], 'success');
    $redirect_url = VSHARE_URL . '/admin/email_templates.php';
    redirect($redirect_url);
}

$smarty->assign('editor_wysiwyg_email', get_config('editor_wysiwyg_email'));
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/email_edit.tpl');
$smarty->display('admin/footer.tpl');
db_close();
