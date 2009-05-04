<?php

$vshare_version = '2.7';
$vshare_release = '20090310';

set_time_limit(0);

$conn = mysql_connect($db_host, $db_user, $db_pass);

if (! $conn)
{
    die('Could not connect: ' . mysql_error());
}

mysql_select_db($db_name, $conn) or die('Can\'t select database : ' . mysql_error());
mysql_set_charset('utf8', $conn);

/*
 * set variables
 */

define('VSHARE_DIR', $config['basedir']);
define('VSHARE_URL', $config['baseurl']);
$config['TMB_DIR'] = VSHARE_DIR . '/thumb';

require VSHARE_DIR . '/include/smarty/libs/Smarty.class.php';
require VSHARE_DIR . '/include/phpmailer/class.phpmailer.php';
require VSHARE_DIR . '/include/functions.php';
require VSHARE_DIR . '/include/functions_security.php';
require VSHARE_DIR . '/include/class.user.php';

$smarty = new Smarty();

$smarty->template_dir = VSHARE_DIR . '/templates';
$smarty->compile_dir = VSHARE_DIR . '/templates_c';
$smarty->cache_dir = VSHARE_DIR . '/templates_c/cache';
$smarty->caching = 0;

$sql = "SELECT * FROM `sconfig`";
$result = mysql_query($sql);

while ($tmp = mysql_fetch_assoc($result))
{
    $field = $tmp['soption'];
    $config[$field] = $tmp['svalue'];
    $smarty->assign($field, $config[$field]);
}

mysql_free_result($result);

$sql = "SELECT * FROM `servers`";
$result = mysql_query($sql);

$servers[0] = VSHARE_URL;

if (mysql_num_rows($result) > 0)
{
    while ($tmp = mysql_fetch_assoc($result))
    {
        $tmp_server_id = $tmp['id'];
        $servers[$tmp_server_id] = $tmp['url'];
    }
}
$smarty->assign('servers', $servers);

$smarty->assign('base_url', VSHARE_URL);
$smarty->assign('base_dir', VSHARE_DIR);

define('IMG_CSS_URL', VSHARE_URL . '/templates');
$smarty->assign('img_css_url', IMG_CSS_URL);

if ($config['approve'] == 1)
{
    $active = "and `active`='1'";
}

if (! isset($language))
{
    $language = 'en';
}

set_include_path('.' . PATH_SEPARATOR . VSHARE_DIR . '/include/' . PATH_SEPARATOR . VSHARE_DIR . '/include/PEAR/' . PATH_SEPARATOR . get_include_path());

$result_per_page = 20;

$msg = '';
$err = '';

if (isset($_SESSION['vshare_message']))
{
    switch ($_SESSION['vshare_message_type'])
    {
        case 'success':
            $msg = $_SESSION['vshare_message'];
            break;
        case 'error':
            $err = $_SESSION['vshare_message'];
            break;
        default:
            $msg = $_SESSION['vshare_message'];
            break;
    }
    unset($_SESSION['vshare_message']);
    unset($_SESSION['vshare_message_type']);
}

if (! isset($_SESSION['CSS']))
{
    require VSHARE_DIR . '/include/class.css.php';
    css::cookie();
}

if (! isset($_SESSION['LANG']))
{
    require VSHARE_DIR . '/include/class.language.php';
    language::cookie();
}

if (! isset($_SESSION['USERNAME']) && isset($_COOKIE['VSHARE_AL_PASSWORD']))
{
    User::login_auto();
}
define('LANG', $_SESSION['LANG']);
