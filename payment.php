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

require 'include/config.php';
require 'include/country.class.php';

if (! is_numeric($_POST['package_id']) && ! is_numeric($_POST['user_id']))
{
    redirect(VSHARE_URL);
}

$user_info = User::get_user_by_id($_POST['user_id']);

if (! $user_info)
{
    redirect(VSHARE_URL);
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
           `user_first_name`='" . mysql_clean($_POST['user_first_name']) . "',
           `user_last_name`='" . mysql_clean($_POST['user_last_name']) . "',
           `user_city`='" . mysql_clean($_POST['user_city']) . "',
           `user_country`='" . mysql_clean($_POST['user_country']) . "' WHERE
           `user_id`='" . (int) $_POST['user_id'] . "'";
    mysql_query($sql) or mysql_die($sql);
    
    if ($_POST['method'] == 'Paypal')
    {
        $s_period = $_POST['period'] . ' ' . $package['package_period'];
        $theprice = $totalprice;
        $uniqueid = $_POST['user_id'] . '|' . $_POST['package_id'] . '|' . $s_period . '|' . $totalprice;
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
        
        redirect($paypal_link);
    }
}

$smarty->assign('err', $err);
$smarty->display('header.tpl');
$smarty->display('payment.tpl');
$smarty->display('footer.tpl');
db_close();
