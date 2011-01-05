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

if ($config['family_filter'] == 0 || !isset($_SESSION['UID']))
{
    db_close();
    redirect(VSHARE_URL);
}



if (! isset($_SESSION['REDIRECT']) || empty($_SESSION['REDIRECT']))
{
    if (! preg_match('/family_filter/i', $_SERVER['HTTP_REFERER']))
    {
        if (preg_match("/" . preg_quote(VSHARE_URL, '/') . "/i", $_SERVER['HTTP_REFERER']))
        {
            $_SESSION['REDIRECT'] = $_SERVER['HTTP_REFERER'];
        }
        else
        {
        	$_SESSION['REDIRECT'] = VSHARE_URL;
        }
    }
    else
    {
    	$_SESSION['REDIRECT'] = VSHARE_URL;
    }
}

if ($_SESSION['FAMILY_FILTER'] == 0)
{
    $_SESSION['FAMILY_FILTER'] = 1;
    
    if (isset($_SESSION['UID']))
    {
        $sql = "UPDATE `users` SET `user_adult`='1' WHERE
               `user_id`='" . (int) $_SESSION['UID'] . "'";
        $result = mysql_query($sql) or mysql_die($sql);
    }
    
    $redirect_url = $_SESSION['REDIRECT'];
    unset($_SESSION['REDIRECT']);
    db_close();
    redirect($redirect_url);
}
else
{
    if (isset($_POST['submit']))
    {
        $_SESSION['FAMILY_FILTER'] = 0;
        
        if (isset($_SESSION['UID']))
        {
            $sql = "UPDATE `users` SET `user_adult`='0' WHERE
                   `user_id`='" . (int) $_SESSION['UID'] . "'";
            $result = mysql_query($sql) or mysql_die($sql);
        }
        
        $redirect_url = $_SESSION['REDIRECT'];
        unset($_SESSION['REDIRECT']);
        
        db_close();
        redirect($redirect_url);
    }
}

$smarty->assign('age_minimum', get_config('signup_age_min'));
$smarty->display('header.tpl');
$smarty->display('family_filter.tpl');
$smarty->display('footer.tpl');
db_close();
