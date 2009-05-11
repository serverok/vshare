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

require 'include/config.php';

header('Content-type: text/html; charset=UTF-8');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . date('r'));
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

$sql = "SELECT * FROM `videos` WHERE 
       `video_type`='public' AND 
       `video_active`='1' 
        ORDER BY `video_view_time` DESC 
        LIMIT 0, 5";
$result = mysql_query($sql) or mysql_die($sql);

echo '<vshare><video_list>';
while ($data = mysql_fetch_array($result))
{
    $video_url = VSHARE_URL . '/view/' . $data['video_id'] . '/' . $data['video_seo_name'] . '/';
    $thumb_url = $servers[$data['video_thumb_server_id']] . '/thumb/' . $data['video_folder'] . '1_' . $data['video_id'] . '.jpg';
    
    echo '<video>' . '<title>' . $data['video_title'] . '</title>' . '<run_time>' . $data['video_length'] . '</run_time>' . '<url>' . $video_url . '</url>' . '<thumbnail_url>' . $thumb_url . '</thumbnail_url>' . '</video>';

}
echo '</video_list></vshare>';
db_close();

