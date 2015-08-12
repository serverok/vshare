<?php
/******************************************************************************
 *
 * COMPANY: BuyScripts.in
 * PROJECT: vShare Youtube Clone
 * VERSION: VSHARE_VERSION_NUMBER_HERE
 * LICENSE: http://buyscripts.in/vshare-license
 * WEBSITE: http://buyscripts.in/vshare-youtube-clone
 *
 * This program is a commercial software and any kind of using it must agree
 * to vShare license.
 *
 ******************************************************************************/

require '../include/config.php';

if (! isset($config) || ! is_array($config))
{
    echo '<div stye="font-family:verdana;"><p><font size="4" color="#FF0000">ERROR: File include/config.php Missing.</font></p>
          <p>Restore include/config.php and try again.</p></div>';
    exit(0);
}

$vshare_versions = array(
    '20070625',
    '20070712',
    '20070730',
    '2.4',
    '2.5',
    '2.6',
    '2.7',
    '2.8',
    '2.8.1',
    '2.9',
    '3.0',
    '3.1',
);

if (! in_array($config['version'], $vshare_versions))
{

    echo <<<EOT
            <p>
            <font size="3" color="#FF0000" face="verdana"><b>
            Upgrade script can only upgrade from vShare Release: 20070625<br />
            You are using an old version that require manual upgrade, for upgrade instruction visit<br /><br />
            <a href="http://forums.buyscripts.in/viewforum.php?f=7">http://forums.buyscripts.in/viewforum.php?f=7</a><br />
            For professional upgrade, contact install@hostonnet.com
            </b></font>
            </p>
EOT;
    exit(0);
}

switch ($config['version'])
{
    case '20070625':
        $redirect_url = VSHARE_URL . '/install/upgrade_20070625_to_20070712.php';
        break;
    case '20070712':
        $redirect_url = VSHARE_URL . '/install/upgrade_20070712_to_20070730.php';
        break;
    case '20070730':
        $redirect_url = VSHARE_URL . '/install/upgrade_20070730_to_2.4.php';
        break;
    case '2.4':
        $redirect_url = VSHARE_URL . '/install/upgrade_2.4_to_2.5.php';
        break;
    case '2.5':
        $redirect_url = VSHARE_URL . '/install/upgrade_2.5_to_2.6.php';
        break;
    case '2.6':
        $redirect_url = VSHARE_URL . '/install/upgrade_2.6_to_2.7.php';
        break;
    case '2.7':
        $redirect_url = VSHARE_URL . '/install/upgrade_2.7_to_2.8.1.php';
        break;
    case '2.8':
        $redirect_url = VSHARE_URL . '/install/upgrade_2.8_to_2.8.1.php';
        break;
    case '2.8.1':
        $redirect_url = VSHARE_URL . '/install/upgrade_2.8.1_to_2.9.php';
        break;
    case '2.9':
        $redirect_url = VSHARE_URL . '/install/upgrade_2.9_to_3.0.php';
        break;
    case '3.0':
        $redirect_url = VSHARE_URL . '/install/upgrade_3.0_to_3.1.php';
        break;
    default:
        $redirect_url = VSHARE_URL . '/install/upgrade_finished.php';
        break;
}

Http::redirect($redirect_url);
