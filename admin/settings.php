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
        
        $sql = "UPDATE `sconfig` SET
               `svalue`='" . $_POST['paypal_receiver_email'] . "' WHERE
               `soption`='paypal_receiver_email'";
        mysql_query($sql);
        
        $sql = "UPDATE `sconfig` SET
               `svalue`='" . $_POST['enable_test_payment'] . "' WHERE
               `soption`='enable_test_payment'";
        mysql_query($sql);
    }
    
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

if ($config['payment_method'] != '')
{
    $method = explode('|', $config['payment_method']);
    
    while (list($k, $v) = each($method))
    {
        if ($v == 'Paypal')
        {
            $pay_checked = "checked=\"checked\"";
        }
        elseif ($v == 'ccbill')
        {
            $aut_checked = "checked=\"checked\"";
        }
    }
}

$payment_method_ops = '<input type="checkbox" name="method[]" value="Paypal" ' . $pay_checked . ' /> Paypal<br />';

$smarty->assign('allow_html', get_config('allow_html'));
$smarty->assign('payment_method_ops', $payment_method_ops);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/settings.tpl');
$smarty->display('admin/footer.tpl');
db_close();
