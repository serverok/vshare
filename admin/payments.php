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
 
require '../include/config.php';
require '../include/functions.php';

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'id_desc';
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$admin_listing_per_page = get_config('admin_listing_per_page');

if ($page < 1)
{
    $page = 1;
}

if ($sort == 'user_asc')
{
	$order_by = 'p.payment_user_id ASC';
}
else if ($sort == 'user_desc')
{
	$order_by = 'p.payment_user_id DESC';
}
else if ($sort == 'id_asc')
{
	$order_by = 'p.payment_id  ASC';
}
else
{
	$order_by = 'p.payment_id  DESC';
}

$sql = "SELECT count(*) AS total FROM `payments` AS p,`users` AS u,`packages` AS pa WHERE
		u.user_id=p.payment_user_id AND p.payment_package_id=pa.package_id";
$result = mysql_query($sql);
$tmp = mysql_fetch_array($result);
$total = $tmp['total'];

if ($total > 0 )
{
	$start_from = ($page - 1) * $admin_listing_per_page;

	require 'Pager/Pager.php';
	require 'Pager/Sliding.php';

	$params = array();
	$params['mode'] = 'Sliding';
	$params['perPage'] = $admin_listing_per_page;
	$params['linkClass'] = 'pager';
	$params['delta'] = 2;
	$params['totalItems'] = $total;
	$params['urlVar'] = 'page';

	$pager = & new Pager_Sliding($params);
	$data = $pager->getPageData();
	$links = $pager->getLinks();
		
	$sql = "SELECT * FROM `payments` AS p,`users` AS u,`packages` AS pa WHERE
			u.user_id=p.payment_user_id AND p.payment_package_id=pa.package_id ORDER BY $order_by LIMIT $start_from, $admin_listing_per_page";
	$result = mysql_query($sql) or mysql_die($sql);

	if (mysql_num_rows($result) > 0)
	{
		$payment_info = array();
		
		while($payment = mysql_fetch_assoc($result))
		{
			$payment_info[] = $payment; 
		}

		$smarty->assign('payment_info',$payment_info);
		$smarty->assign('page_links',$links['all']);
	}
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' )
{
	$payment_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
	$redirect_url = $config['baseurl'] . '/admin/payments.php';
	
	if ($payment_id == 0)
	{
		redirect($redirect_url);
	}
	
	$sql = "DELETE FROM `payments` WHERE
		   `payment_id`='$payment_id'";
	$result = mysql_query($sql);	   
	
	redirect($redirect_url);
}

$smarty->display('admin/header.tpl');
$smarty->display('admin/payments.tpl');
$smarty->display('admin/footer.tpl');