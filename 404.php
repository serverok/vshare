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

require_once 'include/config.php';

header($_SERVER["SERVER_PROTOCOL"].' 404 Not Found');

$sql = "SELECT * FROM `videos` WHERE
       `video_featured`='yes' AND
       `video_type`='public' AND
       `video_approve`='1' AND
       `video_active`='1'
       LIMIT 0,4";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) == 0)
{
    $sql = "SELECT * FROM `videos` WHERE
           `video_type`='public' AND
           `video_approve`='1' AND
           `video_active`='1'
           LIMIT 0,4";
    $result = mysql_query($sql) or mysql_die($sql);
}

if (mysql_num_rows($result) > 0)
{
    $video_info = array();
    
    while ($tmp = mysql_fetch_assoc($result))
    {
        $tmp['video_thumb_url'] = $servers[$tmp['video_thumb_server_id']];
        $video_info[] = $tmp;
    }
    
    $smarty->assign('video_info', $video_info);
}

$smarty->assign('msg_404', 'We\'re sorry, the page you requested cannot be found.');
$smarty->assign('html_title', '404 Not Found');
$smarty->display('header.tpl');
$smarty->display('404.tpl');
$smarty->display('footer.tpl');
db_close();
