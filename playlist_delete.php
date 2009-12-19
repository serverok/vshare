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

require 'include/config.php';

$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

if ((isset($_GET['vid'])) && (isset($_SESSION['UID'])) && (is_numeric($_GET['vid'])))
{
    $sql = "DELETE FROM `playlists` WHERE
           `playlist_user_id`='" . (int) $_SESSION['UID'] . "' AND
           `playlist_video_id`='" . (int) $_GET['vid'] . "'";
    mysql_query($sql) or mysql_die($sql);
}

db_close();

$redirect_url = VSHARE_URL . '/' . $_SESSION['USERNAME'] . '/playlist/' . $page;
redirect($redirect_url);
