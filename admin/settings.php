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

require '../include/config.php';
require '../include/language/' . LANG . '/lang_admin_settings.php';

check_admin_login();

if (isset($_POST['submit']))
{
    $sql = "UPDATE `sconfig` SET
           `svalue`='" . mysql_clean($_POST['site_name']) . "' WHERE
           `soption`='site_name'";
    mysql_query($sql);
    
    $sql = "UPDATE `config` SET
           `config_value`='" . (int) $_POST['allow_html'] . "' WHERE
           `config_name`='allow_html'";
    mysql_query($sql);
    
    $sql = "UPDATE `sconfig` SET
           `svalue`='" . mysql_clean($_POST['meta_keywords']) . "' WHERE
           `soption`='meta_keywords'";
    mysql_query($sql);
    
    $sql = "UPDATE `sconfig` SET
           `svalue`='" . mysql_clean($_POST['meta_description']) . "' WHERE
           `soption`='meta_description'";
    mysql_query($sql);
    
    $sql = "UPDATE `sconfig` SET
           `svalue`='" . mysql_clean($_POST['admin_email']) . "' WHERE
           `soption`='admin_email'";
    mysql_query($sql);
    
    $sql = "UPDATE `sconfig` SET
           `svalue`='" . mysql_clean($_POST['items_per_page']) . "' WHERE
           `soption`='items_per_page'";
    mysql_query($sql);
    
    $sql = "UPDATE `sconfig` SET
           `svalue`='" . (int) $_POST['rel_video_per_page'] . "' WHERE
           `soption`='rel_video_per_page'";
    mysql_query($sql);
    
    $sql = "UPDATE `sconfig` SET
           `svalue`='" . (int) $_POST['num_watch_videos'] . "' WHERE
           `soption`='num_watch_videos'";
    mysql_query($sql);
    
    $sql = "UPDATE `sconfig` SET
           `svalue`='" . $_POST['enable_package'] . "' WHERE
           `soption`='enable_package'";
    mysql_query($sql);
    
    $sql = "UPDATE `sconfig` SET
           `svalue`='" . $_POST['approve'] . "' WHERE
           `soption`='approve'";
    mysql_query($sql);

    $sql = 'UPDATE `config` SET
            `config_value`="' . $_POST['moderate_video_links'] . '" WHERE
            `config_name`="moderate_video_links"';
    mysql_query($sql);

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . $_POST['debug'] . "' WHERE
           `soption`='debug'";
    mysql_query($sql);
    
    $sql = "UPDATE `sconfig` SET
           `svalue`='" . $_POST['notify_upload'] . "' WHERE
           `soption`='notify_upload'";
    mysql_query($sql);
    
    $sql = "UPDATE `sconfig` SET
           `svalue`='" . $_POST['guest_limit'] . "' WHERE
           `soption`='guest_limit'";
    mysql_query($sql);
    
    $sql = "UPDATE `sconfig` SET
           `svalue`='" . $_POST['embed_show'] . "' WHERE
           `soption`='embed_show'";
    mysql_query($sql);
    
    $sql = "UPDATE `sconfig` SET
           `svalue`='" . $_POST['embed_type'] . "' WHERE
           `soption`='embed_type'";
    mysql_query($sql);
    
    $sql = "UPDATE `sconfig` SET
           `svalue`='" . (int) $_POST['cache_enable'] . "' WHERE
           `soption`='cache_enable'";
    mysql_query($sql);
    
    if ($config['enable_package'] == 'yes')
    {
        $_POST['method'] = isset($_POST['method']) ? $_POST['method'] : '';
        
        if ($_POST['method'] == '')
        {
            $err = $lang['payment_method_empty'];
        }
        else
        {
            $payment_method = implode('|', $_POST['method']);
            $sql = "UPDATE `sconfig` SET
                   `svalue`='$payment_method' WHERE
                   `soption`='payment_method'";
            mysql_query($sql);
        }
        
        if ($err == '')
        {
            $sql = "UPDATE `sconfig` SET
                   `svalue`='" . mysql_clean($_POST['paypal_receiver_email']) . "' WHERE
                   `soption`='paypal_receiver_email'";
            mysql_query($sql);
            
            $sql = "UPDATE `sconfig` SET
                   `svalue`='" . mysql_clean($_POST['enable_test_payment']) . "' WHERE
                   `soption`='enable_test_payment'";
            mysql_query($sql);
            
            if (preg_match("/CCBill/i", $payment_method))
            {
                if (! is_numeric($_POST['ccbill_ac_no']))
                {
                    $err = 'CCBill account number must be numeric';
                }
                else if (! is_numeric($_POST['ccbill_sub_ac_no']))
                {
                    $err = 'CCBill sub account number must be numeric';
                }
                else
                {
                    $_POST['ccbill_ac_no'] = isset($_POST['ccbill_ac_no']) ? $_POST['ccbill_ac_no'] : '';
                    $_POST['ccbill_ac_no'] = trim($_POST['ccbill_ac_no']);
                    
                    if (check_config_exists('ccbill_ac_no'))
                    {
                        $sql = "UPDATE `config` SET
                               `config_value`='" . mysql_clean($_POST['ccbill_ac_no']) . "' WHERE
                               `config_name`='ccbill_ac_no'";
                        mysql_query($sql);
                    }
                    else
                    {
                        $sql = "INSERT INTO `config` SET
                               `config_name`='ccbill_ac_no',
                               `config_value`='" . mysql_clean($_POST['ccbill_ac_no']) . "'";
                        mysql_query($sql);
                    }
                    
                    $_POST['ccbill_sub_ac_no'] = isset($_POST['ccbill_sub_ac_no']) ? $_POST['ccbill_sub_ac_no'] : '';
                    $_POST['ccbill_sub_ac_no'] = trim($_POST['ccbill_sub_ac_no']);
                    
                    if (check_config_exists('ccbill_sub_ac_no'))
                    {
                        $sql = "UPDATE `config` SET
                               `config_value`='" . mysql_clean($_POST['ccbill_sub_ac_no']) . "' WHERE
                               `config_name`='ccbill_sub_ac_no'";
                        mysql_query($sql);
                    }
                    else
                    {
                        $sql = "INSERT INTO `config` SET
                               `config_name`='ccbill_sub_ac_no',
                               `config_value`='" . mysql_clean($_POST['ccbill_sub_ac_no']) . "'";
                        mysql_query($sql);
                    }
                    
                    $_POST['ccbill_form_name'] = isset($_POST['ccbill_form_name']) ? $_POST['ccbill_form_name'] : '';
                    $_POST['ccbill_form_name'] = trim($_POST['ccbill_form_name']);
                    
                    if (check_config_exists('ccbill_form_name'))
                    {
                        $sql = "UPDATE `config` SET
                               `config_value`='" . mysql_clean($_POST['ccbill_form_name']) . "' WHERE
                               `config_name`='ccbill_form_name'";
                        mysql_query($sql);
                    }
                    else
                    {
                        $sql = "INSERT INTO `config` SET
                               `config_name`='ccbill_form_name',
                               `config_value`='" . mysql_clean($_POST['ccbill_form_name']) . "'";
                        mysql_query($sql);
                    }
                
                }
            }
            
            $sql = "UPDATE `sconfig` SET
                   `svalue`='" . mysql_clean($_POST['family_filter']) . "' WHERE
                   `soption`='family_filter'";
            mysql_query($sql);
        }
    }
    
    $sql = "UPDATE `sconfig` SET
           `svalue`='" . mysql_clean($_POST['family_filter']) . "' WHERE
           `soption`='family_filter'";
    mysql_query($sql);
    
    if ($err == '')
    {
        set_message($lang['settings_updated'], 'success');
        $redirect_url = VSHARE_URL . '/admin/settings.php';
        redirect($redirect_url);
    }
}

if ($config['enable_package'] == 'yes')
{
    $service_ops = "<option value='yes' selected=\"selected\">Enable Package</option><option value=\"no\">Free Service</option>";
}
else
{
    $service_ops = "<option value='yes'>Enable Package</option><option value='no' selected=\"selected\">Free Service</option>";
}

$smarty->assign('service_ops', $service_ops);

$ccbill_enabled = '';
$paypal_enabled = '';

if ($config['payment_method'] != '')
{
    $method = explode('|', $config['payment_method']);
    
    while (list($k, $v) = each($method))
    {
        if ($v == 'Paypal')
        {
            $paypal_enabled = "checked=\"checked\"";
        }
        else if ($v == 'CCBill')
        {
            $ccbill_enabled = "checked=\"checked\"";
        }
    }
}

$payment_method_ops = '<input type="checkbox" name="method[]" value="Paypal" ' . $paypal_enabled . ' /> Paypal <input type="checkbox" name="method[]" value="CCBill" ' . $ccbill_enabled . ' /> CCBill<br />';

$smarty->assign('ccbill_ac_no', get_config('ccbill_ac_no'));
$smarty->assign('ccbill_sub_ac_no', get_config('ccbill_sub_ac_no'));
$smarty->assign('ccbill_form_name', get_config('ccbill_form_name'));
$smarty->assign('moderate_video_links', get_config('moderate_video_links'));

$smarty->assign('allow_html', get_config('allow_html'));
$smarty->assign('payment_method_ops', $payment_method_ops);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/settings.tpl');
$smarty->display('admin/footer.tpl');
db_close();
