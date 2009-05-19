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

$page = isset($_GET['page']) ? $_GET['page'] : 1;

if (! is_numeric($page) || $page < 1)
{
    $page = 1;
}

$mail_folder = isset($_GET['folder']) ? $_GET['folder'] : 'inbox';

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
else if ($mail_folder == 'outbox')
{
    $who = 'mail_sender';
}

$sql = "SELECT count(*) AS `total` FROM `mails` WHERE
        `$who`='" . mysql_clean($_SESSION['USERNAME']) . "' AND
        `mail_" . $mail_folder . "_track`='2'";
$result = mysql_query($sql) or mysql_die($query);
$tmp = mysql_fetch_assoc($result);
$total = $tmp['total'];

$start_from = ($page - 1) * $config['items_per_page'];

$sql = "SELECT * FROM `mails` WHERE
       `$who`='" . mysql_clean($_SESSION['USERNAME']) . "' AND
       `mail_" . $mail_folder . "_track`='2'
        ORDER BY `mail_id` DESC
        LIMIT $start_from, $config[items_per_page]";
$result = mysql_query($sql) or mysql_die($sql);

$mails = array();

while ($mail = mysql_fetch_assoc($result))
{
    $mail['mail_date'] = date('d M Y G:i ', strtotime($mail['mail_date']));
    $mails[] = $mail;
}

$start_num = $start_from + 1;
$end_num = $start_from + mysql_num_rows($result);

require 'Pager/Pager.php';
require 'Pager/Sliding.php';

$params = array(
    'mode' => 'Sliding',
    'perPage' => $config['items_per_page'],
    'linkClass' => 'pager',
    'delta' => 2,
    'totalItems' => $total,
    'urlVar' => 'page'
);

$pager = & new Pager_Sliding($params);
$data = $pager->getPageData();
$links = $pager->getLinks();

$smarty->assign('mails', $mails);
$smarty->assign('mail_folder', $mail_folder);
$smarty->assign('mail_title', ucfirst($mail_folder));
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('page_link', $links['all']);
$smarty->assign('total', $total);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('sub_menu', 'menu_message.tpl');
$smarty->display('header.tpl');
$smarty->display('mail.tpl');
$smarty->display('footer.tpl');
db_close();