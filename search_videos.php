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
require 'include/language/' . LANG . '/lang_tag.php';

$search_string = strip_tags($_GET['search_string']);
$search_string = trim($search_string);

if ($search_string == '')
{
    $err = $lang['search_key_empty'];
}

if ($err == '')
{
    $search_string = str_replace('-', '+', $search_string);
    
    if (mb_strlen($search_string) < 4)
    {
        $sql_extra = "WHERE `video_title` REGEXP '" . mysql_clean($search_string) . "' OR 	
                     `video_description` REGEXP '" . mysql_clean($search_string) . "' OR
                     `video_keywords` REGEXP '" . mysql_clean($search_string) . "' AND";
    }
    else
    {
        $sql_extra = "WHERE MATCH (video_title,video_description,video_keywords) 
                      AGAINST ('" . mysql_clean($search_string) . "' IN BOOLEAN MODE) AND";
    }
    
    $sql = "SELECT `video_id` FROM `videos`
            $sql_extra
           `video_type`='public' AND
           `video_approve`='1' AND
           `video_active`='1'
            GROUP BY video_id";
    $result = mysql_query($sql) or mysql_die($sql);
    $total = mysql_num_rows($result);
    
    if ($total > 0)
    {
        
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        
        if ($page < 1)
        {
            $page = 1;
        }
        
        $start_from = ($page - 1) * $config['items_per_page'];
        
        $sql = "SELECT * FROM `videos` 
                $sql_extra
               `video_type`='public' AND
               `video_approve`='1' AND
               `video_active`='1'
                GROUP BY video_id
                LIMIT $start_from, $config[items_per_page]";
        $result = mysql_query($sql) or mysql_die($sql);
        
        while ($video = mysql_fetch_assoc($result))
        {
            $video['video_thumb_url'] = $servers[$video['video_thumb_server_id']];
            $video['video_keywords_array'] = split(' ', $video['video_keywords']);
            $video_info[] = $video;
            $vid[] = $video['video_id'];
        }
        
        $total_current_page = mysql_num_rows($result);
        $start_num = $start_from + 1;
        $end_num = $start_from + $total_current_page;
        $page_links = paginate($total, $config['items_per_page'], '.', '', $page);
        
        $smarty->assign('page', $page);
        $smarty->assign('start_num', $start_num);
        $smarty->assign('end_num', $end_num);
        $smarty->assign('page_links', $page_links);
        $smarty->assign('total', $total);
        $smarty->assign('video_info', $video_info);
    }
    else
    {
        $err = $lang['video_not_found'];
    }
}

$search_string = str_replace('+', ' ', $search_string);
$smarty->assign('search_string', $search_string);
$smarty->assign('html_title', $search_string);
$smarty->assign('html_keywords', $search_string);
$smarty->assign('html_description', $search_string);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('sub_menu', 'menu_home.tpl');
$smarty->display('header.tpl');
$smarty->display('search_videos.tpl');
$smarty->display('footer.tpl');
db_close();
