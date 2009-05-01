<?php 

require '../include/config.php';
require '../include/functions_ajax.php';

$group_id = isset($_GET['group_id']) ? (int) $_GET['group_id'] : '';
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$ajax_debug = 0;

if ($page == 0 || !is_numeric($page))
{
	$page = 1;
}


if ($group_id == '')
{
	$err = 'There is no groups';
	if ($ajax_debug) error_log("$err \n",3, VSHARE_DIR . '/ajax/log.txt');
	return_json($err,'error');
	exit;
}

$sql = "SELECT * FROM `groups` WHERE 
       `group_id`=$group_id";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result)>0)
{
	$group_info = mysql_fetch_assoc($result);
	
	if (isset($_SESSION['UID']) && $_SESSION['UID'] == $group_info['group_owner_id'])
	{
		$approved = '';
	}
	else 
	{
		$approved = " AND gt.group_topic_approved='yes'";
	}
	
	$sql = "SELECT count(*) as `total` FROM `group_topics` AS gt WHERE
		    gt.group_topic_group_id=" . (int) $group_info['group_id'] . " 
		    $approved";
	$result = mysql_query($sql) or mysql_die($sql);
	
	if (mysql_num_rows($result)>0)
	{
			$total = mysql_fetch_array($result);
			$total = $total['total'];
	
			$start_from = ($page-1) * $config[items_per_page];
	
			$sql = "SELECT * FROM 
                   `group_topics` AS gt,
                   `users` AS u WHERE
	       			gt.group_topic_group_id=" . $group_info['group_id'] . " AND 
					u.user_id=gt.group_topic_user_id 
	       			$approved
	       			ORDER BY `group_topic_id` DESC
	       			LIMIT $start_from, $config[items_per_page]";
	       
			$result = mysql_query($sql) or mysql_die($sql);
			while($topics = mysql_fetch_assoc($result)) {
				$topics['addtime'] = date('F j,Y H:i a',strtotime($topics['addtime']));
				$group_topics[] = $topics;
			}
		
			$smarty->assign('group_info',$group_info);
			$smarty->assign('group_topics',$group_topics);
			
			$start_num = $start_from + 1;
			$end_num = $start_from + mysql_num_rows($result);

			require_once 'Pager/Pager.php';
			require_once 'Pager/Sliding.php';
	
			$params = array(
			    'mode'       => 'Sliding',
			    'perPage'    => $config['items_per_page'],
				'delta'      => 2,
				'totalItems' => $total,
				'nextImg' => 'Next',
				'prevImg' => 'Previous',
				'urlVar'    => 'page',
				'path'      => '',
				'append' => false,
				'fileName' => 'javascript:display_topics(%d)'
			);
			
			$pager = & new Pager_Sliding($params);
			$data = $pager->getPageData();
			$links = $pager->getLinks();
			
			$topics_links = $links['all'];
			$smarty->assign('topics_links',$topics_links);
			$smarty->assign('group_id',$group_id);

			$fetch_group_topics = $smarty->fetch('group_topics.tpl');
			return_json($fetch_group_topics,'success');
						
	}
	
}
else 
{
	$err = 'There is no groups';
	if ($ajax_debug) error_log("$err \n",3, VSHARE_DIR . '/ajax/log.txt');
	return_json($err,'error');
	exit;
}


