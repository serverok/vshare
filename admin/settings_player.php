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
require '../include/language/' . LANG . '/admin/settings_player.php';

Admin::auth();

if (isset($_POST['submit']))
{
    if (is_numeric($_POST['player_autostart']))
    {
        $sql = "UPDATE `sconfig` SET
               `svalue`='" . (int) $_POST['player_autostart'] . "' WHERE
               `soption`='player_autostart'";
        DB::query($sql);
        $smarty->assign('player_autostart', $_POST['player_autostart']);
    }

    if (is_numeric($_POST['player_bufferlength']))
    {
        $sql = "UPDATE `sconfig` SET
               `svalue`='" . (int) $_POST['player_bufferlength'] . "' WHERE
               `soption`='player_bufferlength'";
        DB::query($sql);
        $smarty->assign('player_bufferlength', $_POST['player_bufferlength']);
    }

    if (is_numeric($_POST['player_width']))
    {
        $sql = "UPDATE `sconfig` SET
               `svalue`='" . (int) $_POST['player_width'] . "' WHERE
               `soption`='player_width'";
        DB::query($sql);
        $smarty->assign('player_width', $_POST['player_width']);
    }

    if (is_numeric($_POST['player_height']))
    {
        $sql = "UPDATE `sconfig` SET
               `svalue`='" . (int) $_POST['player_height'] . "' WHERE
               `soption`='player_height'";
        DB::query($sql);
        $smarty->assign('player_height', $_POST['player_height']);
    }

    if (isset($_POST['youtube_player']))
    {
        $sql = "UPDATE `config` SET
               `config_value`='" . DB::quote($_POST['youtube_player']) . "' WHERE
               `config_name`='youtube_player'";
        DB::query($sql);
    }

    if (isset($_POST['vshare_player']))
    {
        $sql = "UPDATE `config` SET
               `config_value`='" . DB::quote($_POST['vshare_player']) . "' WHERE
               `config_name`='vshare_player'";
        DB::query($sql);
    }

    $msg = $lang['settings_updated'];
}

$smarty->assign('vshare_player', Config::get('vshare_player'));
$smarty->assign('youtube_player', Config::get('youtube_player'));
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/settings_player.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
