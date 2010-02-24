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

require 'include/config.php';
require 'include/class.channels.php';
require 'include/language/' . LANG . '/lang_channels.php';

$channels = channels::get_all();

if ($channels == 0)
{
    $msg = $lang['channel_not_found'];
}

$smarty->assign('html_title', 'Channels');
$smarty->assign('html_keywords', 'Channels');
$smarty->assign('html_description', 'Channels');
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('channels', $channels);
$smarty->display('header.tpl');
$smarty->display('channels.tpl');
$smarty->display('footer.tpl');
db_close();
