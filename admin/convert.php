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
require '../include/functions_upload.php';
require '../include/language/' . LANG . '/lang_admin_convert.php';

check_admin_login();

$qid = $_GET['id'];

if (! is_numeric($qid))
{
    echo $lang['id_not_numeric'];
    exit();
}

$re_convert = isset($_GET['reconvert']) ? $_GET['reconvert'] : 0;

if ($re_convert == 1)
{
    $sql = "UPDATE `process_queue` SET
           `status`='2' WHERE
           `id`='" . (int) $qid . "'";
    mysql_query($sql) or mysql_die($sql);
}

$video_id = process_video($qid, 1);

echo "<p><a href=\"javascript:history.go(-1)\">Back</a></p>";
db_close();
