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
require '../include/language/' . LANG . '/lang_admin_tags_search.php';

check_admin_login();

if (isset($_POST['submit']))
{
    $search_tag = DB::quote($_POST['search_tag']);
    $sql = "SELECT * FROM `tags` WHERE
           `tag` like '%$search_tag%'";
    $result = mysql_query($sql) or mysql_die($sql);
    
    if (mysql_num_rows($result) > 0)
    {
        while ($tags = mysql_fetch_assoc($result))
        {
            $tag[] = $tags;
        }
        $smarty->assign('tag', $tag);
    }
    else
    {
        $err = str_replace('[SEARCH_TAG]', $search_tag, $lang['tag_not_found']);
    }
}

if (isset($_POST['action']))
{
    if ($_POST['action'] == 'Disable')
    {
        $active = 0;
    }
    else if ($_POST['action'] == 'Activate')
    {
        $active = 1;
    }
    $tag_id = $_POST['action_tag'];
    
    $sql = "UPDATE `tags` SET
           `active`=$active WHERE
           `id`=" . (int) $tag_id;
    mysql_query($sql) or mysql_die($sql);
    $msg = 'Tag has been ' . $_POST['action'] . 'd.';
    
    $sql = "SELECT * FROM `tags` WHERE
           `id`='" . (int) $tag_id . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    
    while ($tags = mysql_fetch_assoc($result))
    {
        $tag[] = $tags;
    }
    
    $smarty->assign('tag', $tag);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/tags_search.tpl');
$smarty->display('admin/footer.tpl');
db_close();
