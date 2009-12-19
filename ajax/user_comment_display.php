<?php

require '../include/config.php';
require '../include/functions_ajax.php';

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 0;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) $page = 1;

$sql = "SELECT * FROM `users` WHERE 
       `user_id`='" . (int) $user_id . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) > 0)
{
    $user_info = mysql_fetch_assoc($result);
    
    $sql = "SELECT count(*) AS total FROM `profile_comments` WHERE
           `profile_comment_user_id`='" . (int) $user_info['user_id'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    
    $tmp = mysql_fetch_assoc($result);
    $total = $tmp['total'];
    
    if ($total > 0)
    {
        $start_from = ($page - 1) * $config['items_per_page'];
        
        $sql = "SELECT * FROM `profile_comments` WHERE
               `profile_comment_user_id`='" . (int) $user_info['user_id'] . "'
                ORDER BY `profile_comment_id` DESC
                LIMIT $start_from, $config[items_per_page]";
        $result = mysql_query($sql) or mysql_die();
        
        $profile_comments = mysql_fetch_all($result);
        $smarty->assign('profile_comments', $profile_comments);
        
        require_once 'Pager/Pager.php';
        require_once 'Pager/Sliding.php';
        
        $params = array(
            'mode' => 'Sliding',
            'perPage' => $config['items_per_page'],
            'delta' => 2,
            'totalItems' => $total,
            'nextImg' => 'Next',
            'prevImg' => 'Previous',
            'urlVar' => 'page',
            'path' => '',
            'append' => false,
            'fileName' => 'javascript:display_user_comments(%d)'
        );
        
        $pager = new Pager_Sliding($params);
        $data = $pager->getPageData();
        $links = $pager->getLinks();
        
        $page_links = $links['all'];
        $smarty->assign('page_links', $page_links);
    
    }
    $smarty->display('user_comment.tpl');
}
else
{
    echo 'User not found.';
}

