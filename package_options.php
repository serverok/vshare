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

$sql = "SELECT * FROM `packages` WHERE
       `package_id`='" . (int) $_GET['package_id'] . "'";
$result = mysql_query($sql) or mysql_die($sql);
$package = mysql_fetch_assoc($result);

$smarty->assign('package', $package);

$period_ops = '';

if ($package['package_period'] == 'Year')
{
    for ($i = 1; $i <= 5; $i ++)
    {
        $period_ops .= '<option value="' . $i . '">' . $i . '</option>';
    }
}
else if ($package['package_period'] == 'Month')
{
    for ($i = 1; $i <= 12; $i ++)
    {
        $period_ops .= '<option value="' . $i . '">' . $i . '</option>';
    }
}

$smarty->assign('period_ops', $period_ops);

if ($config['payment_method'] != '')
{
    $method = explode('|', $config['payment_method']);
    $payment_method_ops = '';
    
    while (list($k, $v) = each($method))
    {
        $payment_method_ops .= '<option value="' . $v . '">' . $v . '</option>';
    }
    $smarty->assign('payment_method_ops', $payment_method_ops);
}

$smarty->assign('err', $err);
$smarty->display('header.tpl');
$smarty->display('package_options.tpl');
$smarty->display('footer.tpl');
db_close();
