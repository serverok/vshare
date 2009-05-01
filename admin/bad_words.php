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
require '../include/language/' . LANG . '/lang_admin_bad_words.php';

check_admin_login();

if (isset($_GET['action']) && $_GET['action'] == 'del')
{
    $sql = "DELETE FROM `words` WHERE
           `word_id`='" . (int) $_GET['id'] . "'";
    mysql_query($sql) or mysql_die($sql);
}

if (isset($_POST["action"]) && $_POST["action"] == 'add')
{
    
    if ($_POST['word'] == '')
    {
        $err = $lang['bad_word_empty'];
        $smarty->assign('err', $err);
    }
    
    if ($err == '')
    {
        $word = trim($_POST['word']);
        $word = mb_strtolower($word);
        $sql = "INSERT INTO `words` SET
               `word`='" . mysql_clean($word) . "'";
        mysql_query($sql) or mysql_die($sql);
        $msg = $_POST['word'] . ' ' . $lang['bad_word_added'];
        $smarty->assign('msg', $msg);
    }
}

$sql = "SELECT * FROM `words`";
$result = mysql_query($sql) or mysql_die($sql);
$badwords = mysql_fetch_all($result);

$smarty->assign('badwords', $badwords);
$smarty->display('admin/header.tpl');
$smarty->display('admin/bad_words.tpl');
$smarty->display('admin/footer.tpl');
db_close();
