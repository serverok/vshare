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

require 'include/config.php';

User::is_logged_in();

$mail_types = array(
    'inbox',
    'outbox'
);

if (! in_array($_GET['folder'], $mail_types))
{
    $_GET['folder'] = 'inbox';
}

if ($_GET['folder'] == 'inbox')
{
    $who = 'mail_receiver';
    $mail_send = 'mail_sender';
    $sql = "UPDATE `mails` SET
           `mail_read`='1' WHERE
           `mail_id`='" . (int) $_GET['id'] . "' AND
           `mail_receiver`='" . mysql_clean($_SESSION['USERNAME']) . "'";
    $result = mysql_query($sql) or mysql_die($sql);
}
else
{
    $who = 'mail_sender';
}

$sql = "SELECT m.*,u.user_id FROM
       `mails` AS m,
       `users` AS u WHERE
       `mail_id`='" . (int) $_GET['id'] . "' AND
        $who ='" . mysql_clean($_SESSION['USERNAME']) . "' AND
        u.user_name=m.mail_sender";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) > 0)
{
    $tmp = mysql_fetch_assoc($result);
    $tmp['mail_subject'] = htmlspecialchars_uni($tmp['mail_subject']);
    $tmp['mail_date'] = date('l,F j,Y H:i:s a', strtotime($tmp['mail_date']));
    $smarty->assign('msg_info', $tmp);
}

if ($_GET['folder'] == 'inbox')
{
    $reply_subject = 'Re: ' . $tmp['mail_subject'];
    $reply_subject = urlencode($reply_subject);
    $smarty->assign('reply_subject', $reply_subject);
}

$smarty->assign('err', $err);
$smarty->assign('sub_menu', 'menu_message.tpl');
$smarty->display('header.tpl');
$smarty->display('msg.tpl');
$smarty->display('footer.tpl');
db_close();
