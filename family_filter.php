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

$redirect_url = VSHARE_URL . '/index.php';

if (isset($_SESSION['REDIRECT']) && ! empty($_SESSION['REDIRECT']))
{
    $redirect_url = $_SESSION['REDIRECT'];
    unset($_SESSION['REDIRECT']);
}
else if (isset($_SERVER['HTTP_REFERER']) && ! empty($_SERVER['HTTP_REFERER']))
{
    $redirect_url = $_SERVER['HTTP_REFERER'];
}

if ($config['family_filter'] == 0)
{
    db_close();
    redirect($redirect_url);
}

$pure_redirect_url = str_replace(VSHARE_URL . '/', '', $redirect_url);
$smarty->assign('pure_redirect_url', $pure_redirect_url);

if ($_COOKIE['FAMILY_FILTER'] == 0)
{
    setcookie('FAMILY_FILTER', 1, time() + 8640000, '/');
    
    if (isset($_SESSION['UID']))
    {
        $sql = "UPDATE `users` SET `user_adult`='1' WHERE
			   `user_id`='" . (int) $_SESSION['UID'] . "'";
        $result = mysql_query($sql) or mysql_die($sql);
    }
    
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
        
        $pure_redirect_url = VSHARE_URL . '/' . $_POST['pure_redirect_url'];
        
        db_close();
        redirect($pure_redirect_url);
    }
}

$smarty->display('header.tpl');
$smarty->display('family_filter.tpl');
$smarty->display('footer.tpl');
db_close();
