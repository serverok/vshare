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

$fulltext_search = 1;

if ($search_string == '')
{
    $err = $lang['search_key_empty'];
}

if ($err == '')
{
    if (mb_strlen($search_string) < 4)
    {
        $fulltext_search = 0;
    }
    
    if (mb_strlen($search_string) < 4)
    {
        $sql_extra = "WHERE `video_title` REGEXP '" . mysql_clean($search_string) . "' OR
                     `video_description` REGEXP '" . mysql_clean($search_string) . "' OR
                     `video_keywords` REGEXP '" . mysql_clean($search_string) . "' AND";
    }
    else
    {
        $sql_extra = "";
    }
    
    if ($fulltext_search)
    {
        $sql = "SELECT count(*) AS total FROM `videos`
			WHERE MATCH (video_title,video_description,video_keywords) AGAINST ('" . mysql_clean($search_string) . "' IN BOOLEAN MODE) AND
           `video_type`='public' AND
           `video_approve`='1' AND
           `video_active`='1'";
    }
    else
    {
        $sql = "SELECT count(*) AS total FROM `videos`
				WHERE `video_title` REGEXP '" . mysql_clean($search_string) . "' OR
                `video_description` REGEXP '" . mysql_clean($search_string) . "' OR
                `video_keywords` REGEXP '" . mysql_clean($search_string) . "' AND
           		`video_type`='public' AND
           		`video_approve`='1' AND
           		`video_active`='1'";
    }
    
    $result = mysql_query($sql) or mysql_die($sql);
    $tmp = mysql_fetch_assoc($result);
    $total = $tmp['total'];
    
    if ($total > 0)
    {
        
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        
        if ($page < 1)
        {
            $page = 1;
        }
        
        $start_from = ($page - 1) * $config['items_per_page'];
        $sql_limit = " LIMIT $start_from, $config[items_per_page]";
        $sql_select_fields = "`video_id`, `video_title`,`video_description`,`video_keywords`, `video_seo_name`,  `video_thumb_server_id`, `video_folder`";
        
        if ($fulltext_search)
        {
            $sql = "SELECT  $sql_select_fields , MATCH (`video_title`,`video_description`,`video_keywords`) AGAINST ('" . mysql_clean($search_string) . "' IN BOOLEAN MODE) AS `relevance` FROM `videos`
			WHERE MATCH (video_title,video_description,video_keywords) AGAINST ('" . mysql_clean($search_string) . "' IN BOOLEAN MODE) AND
           `video_type`='public' AND
           `video_approve`='1' AND
           `video_active`='1' GROUP BY `video_id` ORDER BY `relevance` DESC " . $sql_limit;
        }
        else
        {
            $sql = "SELECT  $sql_select_fields FROM `videos`
				WHERE `video_title` REGEXP '" . mysql_clean($search_string) . "' OR
                `video_description` REGEXP '" . mysql_clean($search_string) . "' OR
                `video_keywords` REGEXP '" . mysql_clean($search_string) . "' AND
           		`video_type`='public' AND
           		`video_approve`='1' AND
           		`video_active`='1'  GROUP BY `video_id`" . $sql_limit;
        }
        
        $result = mysql_query($sql) or mysql_die($sql);
        
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
        
        require 'Pager/Pager.php';
        require 'Pager/Sliding.php';
        
        $params = array();
        $params['mode'] = 'Sliding';
        $params['perPage'] = $config['items_per_page'];
        $params['linkClass'] = 'pager';
        $params['delta'] = 2;
        $params['totalItems'] = $total;
        $params['urlVar'] = 'page';
        
        $pager = new Pager_Sliding($params);
        $data = $pager->getPageData();
        $page_links = $pager->getLinks();
        
        $smarty->assign('page', $page);
        $smarty->assign('start_num', $start_num);
        $smarty->assign('end_num', $end_num);
        $smarty->assign('page_links', $page_links['all']);
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
