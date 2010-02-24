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

require ('include/config.php');
require ('include/class.xss.php');
require 'include/language/' . LANG . '/lang_mail_delete.php';

User::is_logged_in();

if (isset($_POST['folder']))
{
    $mail_id = $_POST['mid'];
    $mail_folder = $_POST['folder'];
}
else
{
    $mail_id = array();
    $mail_id[] = $_GET['mail_id'];
    $mail_folder = $_GET['folder'];
}

$mail_folder_types = array(
    'inbox',
    'outbox'
);

if (! in_array($mail_folder, $mail_folder_types))
{
    $mail_folder = 'inbox';
}

if ($mail_folder == 'inbox')
{
    $who = 'mail_receiver';
}
else
{
    $who = 'mail_sender';
}

for ($i = 0; $i < count($mail_id); $i ++)
{
    $sql = "UPDATE `mails` SET `mail_" . $mail_folder . "_track`='1' WHERE
           `mail_id`=" . (int) $mail_id[$i] . " AND
           `$who`='" . mysql_clean($_SESSION['USERNAME']) . "'";
    mysql_query($sql) or mysql_die($sql);
}

$sql = "DELETE FROM `mails` WHERE
       `mail_inbox_track`=1 AND
       `mail_outbox_track`=1";
mysql_query($sql) or mysql_die($sql);

//$msg = str_replace('[MAIL_TYPE]', $mail_folder, $lang['mail_delete_success']);
//set_message($msg, 'success');
db_close();
$redirect_url = VSHARE_URL . '/mail.php?folder=' . $mail_folder;
redirect($redirect_url);
