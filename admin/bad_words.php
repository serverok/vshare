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
require '../include/language/' . LANG . '/lang_admin_bad_words.php';

Admin::auth();

if (isset($_GET['action']) && $_GET['action'] == 'del') {
    $sql = "DELETE FROM `words` WHERE
           `word_id`='" . (int) $_GET['id'] . "'";
    DB::query($sql);
}

if (isset($_POST["action"]) && $_POST["action"] == 'add') {
    if ($_POST['word'] == '') {
        $err = $lang['bad_word_empty'];
        $smarty->assign('err', $err);
    }
    if ($err == '') {
        $word = trim($_POST['word']);
        $word = mb_strtolower($word);
        $sql = "INSERT INTO `words` SET
               `word`='" . DB::quote($word) . "'";
        DB::query($sql);
        $msg = $_POST['word'] . ' ' . $lang['bad_word_added'];
        $smarty->assign('msg', $msg);
    }
}

$sql = "SELECT * FROM `words`";
$badwords = DB::fetch($sql);

$smarty->assign('badwords', $badwords);
$smarty->display('admin/header.tpl');
$smarty->display('admin/bad_words.tpl');
$smarty->display('admin/footer.tpl');
DB::close();
