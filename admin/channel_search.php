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
require '../include/functions_seo_name.php';
require '../include/language/' . LANG . '/lang_admin_channel_search.php';

check_admin_login();

if (isset($_GET['action']) && $_GET['action'] == 'search')
{
    
    if (isset($_GET['id']) && $_GET['id'] != null)
    {
        if (is_numeric($_GET['id']))
        {
            $sql = "SELECT * FROM `channels` WHERE
                   `channel_id`='" . (int) $_GET['id'] . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            
            if (mysql_num_rows($result) < 1)
            {
                $err = str_replace("[CHANNEL_ID]", $_GET['id'], $lang['id_not_found']);
            }
            else
            {
                $channel = mysql_fetch_assoc($result);
                $channel = array_map("htmlspecialchars", $channel);
                $smarty->assign('channel', $channel);
            }
        }
        else
        {
            $err = $lang['id_invalid'];
        }
    
    }
    else if (isset($_GET['name']) && $_GET['name'] != null)
    {
        $sql = "SELECT * FROM `channels` WHERE
               `channel_name`='" . mysql_clean(trim($_GET['name'])) . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        if (mysql_num_rows($result) < 1)
        {
            $err = str_replace('[CHANNEL_NAME]', $_GET['name'], $lang['name_not_found']);
        }
        else
        {
            $channel = mysql_fetch_assoc($result);
            $channel = array_map("htmlspecialchars", $channel);
            $smarty->assign('channel', $channel);
        }
    }
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/channel_search.tpl');
$smarty->display('admin/footer.tpl');
db_close();
