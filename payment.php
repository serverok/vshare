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
require 'include/country.class.php';

if (! is_numeric($_POST['package_id']) && ! is_numeric($_POST['user_id']))
{
    Http::redirect(VSHARE_URL);
}

$user_info = User::get_user_by_id($_POST['user_id']);

if (! $user_info)
{
    Http::redirect(VSHARE_URL);
}

$smarty->assign('user_info', $user_info);

$countries = new countries();
$smarty->assign('country', $countries->country_options($user_info['user_country']));

$sql = "SELECT * FROM `packages` WHERE
       `package_id`='" . (int) $_POST['package_id'] . "'";
$result = mysql_query($sql) or mysql_die($sql);
$package = mysql_fetch_assoc($result);

$totalprice = $_POST['period'] * $package['package_price'];

$smarty->assign('package', $package);
$smarty->assign('totalprice', $totalprice);

if (isset($_POST['submit']))
{
    $sql = "UPDATE `users` SET
           `user_first_name`='" . DB::quote($_POST['user_first_name']) . "',
           `user_last_name`='" . DB::quote($_POST['user_last_name']) . "',
           `user_city`='" . DB::quote($_POST['user_city']) . "',
           `user_country`='" . DB::quote($_POST['user_country']) . "' WHERE
           `user_id`='" . (int) $_POST['user_id'] . "'";
    mysql_query($sql) or mysql_die($sql);
    
    $sql = "CREATE TABLE IF NOT EXISTS `payments` (
            `payment_id` int(11) unsigned NOT NULL auto_increment,
            `payment_hash` varchar(255) NOT NULL default '',
            `payment_user_id` int(10) unsigned NOT NULL default '0',
            `payment_completed` smallint(1) NOT NULL default '0',
            `payment_package_id` int(10) unsigned NOT NULL default '0',
            `payment_period` varchar(255) NOT NULL default '',
            `payment_amount` varchar(255) NOT NULL default '',
            PRIMARY KEY  (`payment_id`),
            KEY `payment_hash` (`payment_hash`)
            );";
    mysql_query($sql) or mysql_die($sql);
    
    $product_desc = $_POST['user_id'] . '|' . $_POST['package_id'] . '|' . $s_period . '|' . $totalprice;
    
    $payment_hash = md5(time());
    
    $sql = "INSERT INTO `payments` SET `payment_hash`='" . $payment_hash . "',
    	   `payment_user_id`='" . (int) $_POST['user_id'] . "',
    	   `payment_package_id`='" . (int) $_POST['package_id'] . "',
           `payment_period`='" . (int) $_POST['period'] . "',
           `payment_amount`='" . $totalprice . "'";
    $result = mysql_query($sql);
    
    $payment_id = mysql_insert_id();
    
    if ($_POST['method'] == 'Paypal')
    {
        $s_period = $_POST['period'] . ' ' . $package['package_period'];
        $theprice = $totalprice;
        $uniqueid = $_POST['user_id'] . '|' . $_POST['package_id'] . '|' . $s_period . '|' . $totalprice . '|' . $payment_id;
        $uniqueid = urlencode($uniqueid);
        
        $business = urlencode($config['paypal_receiver_email']);
        $item_name = urlencode('For Package : ' . $package['package_name']);
        $return = VSHARE_URL . '/payment/success.php';
        $cancel = VSHARE_URL . '/payment/failed.php';
        $notify = VSHARE_URL . '/payment/ipn.php';
        
        $return = urlencode($return);
        $cancel = urlencode($cancel);
        $notify = urlencode($notify);
        $first_name = urlencode($_POST['user_first_name']);
        $last_name = urlencode($_POST['user_last_name']);
        $city = urlencode($_POST['user_city']);
        
        if ($config['enable_test_payment'] == 'yes')
        {
            $url = 'www.sandbox.paypal.com';
        }
        else
        {
            $url = 'www.paypal.com';
        }
        
        $paypal_link = "https://$url/cgi-bin/webscr/?cmd=_xclick" . "&business=$business" . "&item_number=1&item_name=$item_name" . "&amount=$theprice&on0=0&custom=$uniqueid" . "&currency_code=$config[paypal_currency]" . "&return=$return" . "&cancel_return=$cancel" . "&notify_url=$notify" . "&first_name=$first_name" . "&last_name=$last_name" . "&city=$city";
        
        Http::redirect($paypal_link);
    }
    else if ($_POST['method'] == 'CCBill')
    {
        $theprice = $totalprice;
        $s_period = $_POST['period'] . ' ' . $package['package_period'];
        $product_desc = $_POST['user_id'] . '|' . $_POST['package_id'] . '|' . $s_period . '|' . $totalprice;
        
        $return = VSHARE_URL . '/payment/ccbill_success.php';
        $cancel = VSHARE_URL . '/payment/ccbill_failed.php';
        $notify = VSHARE_URL . '/payment/ccbill_ipn.php';
        
        $return = urlencode($return);
        $cancel = urlencode($cancel);
        $notify = urlencode($notify);
        $first_name = urlencode($_POST['user_first_name']);
        $last_name = urlencode($_POST['user_last_name']);
        $city = urlencode($_POST['user_city']);
        $country = $_POST['user_country'];
        
        $ccbill_ac_no = get_config('ccbill_ac_no');
        $ccbill_sub_ac_no = get_config('ccbill_sub_ac_no');
        $ccbill_form_name = get_config('ccbill_form_name');
        
        $ccbill_link = 'https://bill.ccbill.com/jpost/signup.cgi?clientAccnum=' . $ccbill_ac_no . '&clientSubacc=' . $ccbill_sub_ac_no . '&formName=' . $ccbill_form_name . '&customer_fname=' . $first_name . '&customer_lname=' . $last_name . '&city=' . $city . '&country=' . $country . '&accountingAmount=' . $theprice . '&vshare_payment_id=' . $payment_id . '&productDesc=' . $product_desc;
        Http::redirect($ccbill_link);
    }
}

$smarty->assign('err', $err);
$smarty->display('header.tpl');
$smarty->display('payment.tpl');
$smarty->display('footer.tpl');
db_close();
