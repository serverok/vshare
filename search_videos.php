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

if ($search_string == '') {
    $err = $lang['search_key_empty'];
}

if ($err == '') {

    if (mb_strlen($search_string) < 4) {
        $fulltext_search = 0;
    }

    if (mb_strlen($search_string) < 4) {
        $sql_extra = "WHERE `video_title` REGEXP '" . DB::quote($search_string) . "' OR
                     `video_description` REGEXP '" . DB::quote($search_string) . "' OR
                     `video_keywords` REGEXP '" . DB::quote($search_string) . "' AND";
    } else {
        $sql_extra = "";
    }

    if ($fulltext_search) {
        $sql = "SELECT count(*) AS `total` FROM `videos`
			WHERE MATCH (video_title,video_description,video_keywords) AGAINST ('" . DB::quote($search_string) . "' IN BOOLEAN MODE) AND
           `video_type`='public' AND
           `video_approve`='1' AND
           `video_active`='1'";
    } else {
        $sql = "SELECT count(*) AS `total` FROM `videos`
				WHERE `video_title` REGEXP '" . DB::quote($search_string) . "' OR
                `video_description` REGEXP '" . DB::quote($search_string) . "' OR
                `video_keywords` REGEXP '" . DB::quote($search_string) . "' AND
           		`video_type`='public' AND
           		`video_approve`='1' AND
           		`video_active`='1'";
    }

    $total = DB::getTotal($sql);

    if ($total > 0) {

        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        if ($page < 1) {
            $page = 1;
        }

        $start_from = ($page - 1) * $config['items_per_page'];
        $sql_limit = " LIMIT $start_from, $config[items_per_page]";
        $sql_select_fields = "`video_id`,`video_user_id`,`video_title`,`video_description`,`video_seo_name`,`video_length`,`video_com_num`,`video_view_number`,`video_rate`,`video_rated_by`,`video_thumb_server_id`,`video_folder`";

        if ($fulltext_search) {
            $sql = "SELECT  $sql_select_fields , MATCH (`video_title`,`video_description`,`video_keywords`) AGAINST ('" . DB::quote($search_string) . "' IN BOOLEAN MODE) AS `relevance` FROM `videos`
			WHERE MATCH (video_title,video_description,video_keywords) AGAINST ('" . DB::quote($search_string) . "' IN BOOLEAN MODE) AND
           `video_type`='public' AND
           `video_approve`='1' AND
           `video_active`='1' GROUP BY `video_id` ORDER BY `relevance` DESC " . $sql_limit;
        } else {
            $sql = "SELECT  $sql_select_fields FROM `videos`
				WHERE `video_title` REGEXP '" . DB::quote($search_string) . "' OR
                `video_description` REGEXP '" . DB::quote($search_string) . "' OR
                `video_keywords` REGEXP '" . DB::quote($search_string) . "' AND
           		`video_type`='public' AND
           		`video_approve`='1' AND
           		`video_active`='1'  GROUP BY `video_id`" . $sql_limit;
        }

        $videos_all = DB::fetch($sql);

        foreach ($videos_all as $video)
        {
            $video['video_thumb_url'] = $servers[$video['video_thumb_server_id']];
            $video_info[] = $video;
            $video_users[] = $video['video_user_id'];
        }

        $total_current_page = count($video_info);

        $start_num = $start_from + 1;
        $end_num = $start_from + $total_current_page;
        $page_links = Paginate::getLinks($total, $config['items_per_page'], '.', '', $page);

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

        //Video users
        $video_users = array_unique($video_users);
        $video_users_text = implode(', ', $video_users);

        $sql = "SELECT `user_id`,`user_name` FROM `users` WHERE
               `user_id` IN(" . $video_users_text . ")";
        $uploaders_all = DB::fetch($sql);

        $user_names = array();

        foreach ($uploaders_all as $uploader)
        {
            $user_id = $uploader['user_id'];
            $user_name = $uploader['user_name'];
            $user_names[$user_id] = $user_name;
        }

        $smarty->assign(array(
            'page' => $page,
            'start_num' => $start_num,
            'end_num' => $end_num,
            'page_links' => $page_links['all'],
            'total' => $total,
            'video_info' => $video_info,
            'user_names' => $user_names
        ));
    } else {
        $err = $lang['video_not_found'];
    }
}

$search_string = str_replace('+', ' ', $search_string);
$html_title = "$search_string - Search results page $page";

$smarty->assign(array(
    'search_string' => $search_string,
    'html_title' => $html_title,
    'html_keywords' => $html_title,
    'html_description' => $html_title,
    'err' => $err,
    'msg' => $msg,
    'sub_menu' => 'menu_home.tpl'
));

$smarty->display('header.tpl');
$smarty->display('search_videos.tpl');
$smarty->display('footer.tpl');
DB::close();
