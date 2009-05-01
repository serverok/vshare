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

require './include/config.php';
require './include/functions_upload.php';

$qid = $_SERVER['argv'][1];
write_log("Starting Background video conversion - $qid");
$video_id = process_video($qid, 0);
write_log("End of Background video conversion - $qid");
db_close();
