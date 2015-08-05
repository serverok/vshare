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

$html_title = 'VSHARE UPGRADE FINISHED';
require '../include/config.php';
require './tpl/header.php';
echo '<p class="upgrade-finished">Upgrade Finished</h2>';
echo '<p class="upgrade-finished-version">vShare upgraded to version ' . $config['version'] . '</p>';
echo '<p class="upgrade-finish-warning">You must delete the "install" folder now.</p>';
require './tpl/footer.php';
