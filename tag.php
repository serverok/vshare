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

require 'include/config.php';
require 'include/language/' . LANG . '/lang_tag.php';

$search_string = strip_tags($_GET['search_string']);
$search_string = trim($search_string);

if ($search_string == '')
{
    $err = $lang['search_key_empty'];
}

if (isset($_GET['sort']))
{
    $allowed_sort = array(
        'adddate',
        'viewnum',
        'rate'
    );
    
    if (in_array($_GET['sort'], $allowed_sort))
    {
        $_SESSION['tag_sort_order'] = $_GET['sort'];
    }
}

$sort = isset($_SESSION['tag_sort_order']) ? $_SESSION['tag_sort_order'] : '';

switch ($sort)
{
    case 'viewnum':
        $sortby = "ORDER BY videos.`video_view_number` DESC, tags.tag_count DESC";
        break;
    case 'rate':
        $sortby = "ORDER BY (videos.`video_rated_by`*videos.`video_rate`) DESC, tags.tag_count DESC";
        break;
    default:
        $sortby = "ORDER BY videos.`video_add_time` DESC, tags.tag_count DESC";
        break;
}

if ($err == '')
{
    $sql_all = "SELECT * FROM
               `tag_video` AS `tag_video`,
               `tags` AS `tags`,
               `videos` AS `videos` WHERE
                tags.tag='" . mysql_clean($search_string) . "' AND
                tags.id=tag_video.tag_id AND
                tag_video.vid=videos.video_id AND
                videos.video_type='public' AND
                videos.video_approve='1' AND
                videos.video_active='1'
                GROUP BY tag_video.vid";
    
    $sql = $sql_all;
    $result = mysql_query($sql) or mysql_die($sql);
    $total = mysql_num_rows($result);
    
    if ($total > 0)
    {
        
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        
        if ($page < 1)
        {
            $page = 1;
        }
        
        if ($page > round($total / $config['items_per_page']))
        {
            require '404.php';
            exit();
        }
        
        $start_from = ($page - 1) * $config['items_per_page'];
        
        $sql = $sql_all . "
                $sortby
                LIMIT $start_from, $config[items_per_page]";
        $result = mysql_query($sql) or mysql_die($sql);
        
        $tag_video_keywords = '';
        
        while ($video = mysql_fetch_assoc($result))
        {
            $video['video_thumb_url'] = $servers[$video['video_thumb_server_id']];
            $video['video_keywords_array'] = explode(' ', $video['video_keywords']);
            $video_info[] = $video;
            $vid[] = $video['video_id'];
        }
        
        $total_current_page = mysql_num_rows($result);
        $start_num = $start_from + 1;
        $end_num = $start_from + $total_current_page;
        $page_links = paginate($total, $config['items_per_page'], '.', '', $page);
        
        $tags = array();
        
        //Related tags
        

        for ($i = 0; $i < count($vid); $i ++)
        {
            $sql = "SELECT tags.tag FROM
                   `tag_video` AS tag_video,
                   `tags` AS tags WHERE
                    tag_video.tag_id=tags.id AND
                    tag_video.vid=" . (int) $vid[$i] . " AND
                   `active`=1";
            $result = mysql_query($sql) or mysql_die($sql);
            
            while ($tag = mysql_fetch_assoc($result))
            {
                if (! in_array($tag['tag'], $tags))
                {
                    $tags[] = $tag['tag'];
                }
            }
        }
        
        $smarty->assign('tags', $tags);
        $smarty->assign('page', $page);
        $smarty->assign('start_num', $start_num);
        $smarty->assign('end_num', $end_num);
        $smarty->assign('page_links', $page_links);
        $smarty->assign('total', $total);
        $smarty->assign('video_info', $video_info);
    
    }
    else
    {
        require '404.php';
        exit();
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
$smarty->display('tag.tpl');
$smarty->display('footer.tpl');
db_close();
