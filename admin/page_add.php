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
require '../include/language/' . LANG . '/lang_admin_page_add.php';

check_admin_login();

if (isset($_POST['submit']))
{
    $name_old = $_POST['page_name'];
    $name = trim($name_old);
    $name = strtolower($name);
    $name = ereg_replace('[^a-z0-9]', "-", $name);
    
    if ($name_old != $name)
    {
        $err = $lang['invalid_page_name'];
        $err = str_replace('[NAME]', $name, $err);
        $err = str_replace('[NAME_OLD]', $name_old, $err);
    }
    else if (strlen($_POST['page_name']) < 3)
    {
        $err = $lang['name_too_short'];
    }
    else if (strlen($_POST['title']) < 6)
    {
        $err = $lang['title_too_short'];
    }
    else if (strlen($_POST['content']) < 20)
    {
        $err = $lang['content_too_short'];
    }
    else if (strlen($_POST['description']) < 6)
    {
        $err = $lang['description_too_short'];
    }
    else if (strlen($_POST['keywords']) < 6)
    {
        $err = $lang['keyword_too_short'];
    }
    
    if ($err == '')
    {
        $sql = "SELECT * FROM `pages` WHERE
               `page_name`='" . mysql_clean($name) . "'";
        $result = mysql_query($sql);
        
        if (mysql_num_rows($result) == 1)
        {
            $err = $lang['duplicate_name'];
        }
    }
    
    if ($err == '')
    {
        $sql = "INSERT INTO `pages` SET
               `page_name`='" . mysql_clean($name) . "',
               `page_title`='" . mysql_clean($_POST['title']) . "',
               `page_keywords`='" . mysql_clean($_POST['keywords']) . "',
               `page_description`='" . mysql_clean($_POST['description']) . "',
               `page_content`='" . mysql_clean($_POST['content']) . "',
               `page_counter`='1',
               `page_members_only`='" . mysql_clean($_POST['members_only']) . "'";
        mysql_query($sql) or mysql_die($sql);
        set_message($lang['page_created'], 'success');
        $redirect_url = VSHARE_URL . '/admin/page.php?name=' . $name;
        redirect($redirect_url);
    }
    
    $smarty->assign('name', $name);
}

$smarty->assign('editor_wysiwyg_admin', get_config('editor_wysiwyg_admin'));
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/page_add.tpl');
$smarty->display('admin/footer.tpl');
db_close();
