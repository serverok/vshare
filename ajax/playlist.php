<?php

require '../include/config.php';
require '../include/language/' . LANG . '/lang_playlist.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

if (! isset($_SESSION['UID']))
{
    echo $lang['must_login'];
    exit();
}

if ($action == 'create_playlist')
{
    $playlist_name = isset($_GET['playlist_name']) ? $_GET['playlist_name'] : '';
    
    if ($playlist_name == '')
    {
        echo $lang['playlist_name_empty'];
    }
    else
    {
        $sql = "SELECT * FROM `playlists` WHERE
               `playlist_user_id`='" . (int) $_SESSION['UID'] . "' AND
               `playlist_name`='" . mysql_clean($playlist_name) . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result) < 1)
        {
            $sql = "INSERT INTO `playlists` SET
                   `playlist_user_id`='" . (int) $_SESSION['UID'] . "',
                   `playlist_name`='" . mysql_clean($playlist_name) . "',
                   `playlist_add_date`='" . (int) time() . "'";
            mysql_query($sql) or mysql_die($sql);
            
            echo mysql_insert_id();
        }
        else
        {
            echo $lang['playlist_duplicate'];
        }
    }
}
else if ($action == 'show_playlist')
{
    $sql = "SELECT * FROM `playlists` WHERE
           `playlist_user_id`='" . (int) $_SESSION['UID'] . "'
            ORDER BY `playlist_id` DESC";
    $result = mysql_query($sql) or mysql_die($sql);
    
    echo '<ul id="pl_lists">';
    
    if (mysql_num_rows($result) > 0)
    {
        while ($playlist = mysql_fetch_assoc($result))
        {
            echo '<li><span id="' . (int) $playlist['playlist_id'] . '" rel="pl_items">' . $playlist['playlist_name'] . '</span></li>';
        }
    }
    
    echo '
    <li>
        <span id="create_pl">Create a new playlist...</span>
        <span id="pl_txt_box" style="display: none;">
        <form id="pl-frm" action="javascript:void(0);" onsubmit="javascript:create_playlist();">
        <input type="text" name="playlist_name" id="playlist_name" style="width: 150px;" onclick=";return false;" /></span>
        </form>
        </li>
    </ul>';
    
    echo '
    <script type="text/javascript">
        $("ul#pl_lists *").click(function(){ return false; });
        $("span#create_pl").click(function(){
           $(this).remove();
           $("span#pl_txt_box").show();
           $("input#playlist_name").focus();
        });
        $("ul#pl_lists li span[rel=pl_items]").each(function(){
            $(this).click(function(){
                add_video_playlist($(this).attr("id"));
                $("#show_playlists").hide();
            });
        });
    </script>';
}
else if ($action == 'add_playlist_video')
{
    $video_id = isset($_GET['video_id']) ? $_GET['video_id'] : '';
    $playlist_id = isset($_GET['playlist_id']) ? $_GET['playlist_id'] : '';
    
    if ($video_id == '')
    {
        $err = $lang['playlist_vid_invalid'];
    }
    else if ($playlist_id == '')
    {
        $err = $lang['playlist_id_invalid'];
    }
    
    if ($err == '')
    {
        $sql = "SELECT * FROM `playlists` AS `p`, `playlists_videos` AS `pv` WHERE
                p.playlist_id='" . (int) $playlist_id . "' AND
                p.playlist_user_id='" . (int) $_SESSION['UID'] . "' AND
                p.playlist_id=pv.playlists_videos_playlist_id AND
                pv.playlists_videos_video_id='" . (int) $video_id . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result) < 1)
        {
            $sql = "INSERT INTO `playlists_videos` SET
                   `playlists_videos_playlist_id`='" . (int) $playlist_id . "',
                   `playlists_videos_video_id`='" . (int) $video_id . "'";
            mysql_query($sql) or mysql_die($sql);
            
            echo $lang['playlist_video_added'];
        }
        else
        {
            echo $lang['playlist_video_duplicate'];
        }
    }
}
