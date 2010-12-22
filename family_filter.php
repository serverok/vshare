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

if (isset($_SERVER['HTTP_REFERER']) && ! empty($_SERVER['HTTP_REFERER']))
{
    if (!preg_match('/family_filter/i',$_SERVER['HTTP_REFERER'],$match) && !isset($_SESSION['REDIRECT']))
    {
        $_SESSION['REDIRECT'] = $_SERVER['HTTP_REFERER'];
    }
}

if ($config['family_filter'] == 0)
{
    db_close();
    redirect(VSHARE_URL);
}

if ($_COOKIE['FAMILY_FILTER'] == 0)
{
    setcookie('FAMILY_FILTER', 1, time() + 8640000, '/');
    
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
else if ($_COOKIE['FAMILY_FILTER'] == 1)
{
    if (isset($_POST['submit']))
    {
        setcookie('FAMILY_FILTER', 0, time() + 8640000, '/');
        
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

$smarty->display('header.tpl');
$smarty->display('family_filter.tpl');
$smarty->display('footer.tpl');
db_close();
