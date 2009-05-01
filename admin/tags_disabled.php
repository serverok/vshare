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

require '../include/config.php';

check_admin_login();

$sql = "SELECT * FROM `tags` WHERE
       `active`='0'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) > 0)
{
    while ($tags_info = mysql_fetch_assoc($result))
    {
        $tags[] = $tags_info;
    }
    $smarty->assign('tags', $tags);
}

if (isset($_POST['action']))
{
    $active = 1;
    $tag_id = $_POST['action_tag'];
    $sql = "UPDATE `tags` SET
           `active`='$active' WHERE
           `id`='" . (int) $tag_id . "'";
    mysql_query($sql) or mysql_die($sql);
    $msg = 'Tag has been ' . $_POST['action'] . 'd.';
    set_message($msg, 'success');
    $redirect_url = VSHARE_URL . '/admin/tags_disabled.php';
    redirect($redirect_url);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/tags_disabled.tpl');
$smarty->display('admin/footer.tpl');
db_close();
