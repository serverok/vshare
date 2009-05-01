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

$html_title = 'VSHARE INSTALLATION';
require '../include/config.php';
require './tpl/header.php';

$buyscript_pass = $_POST['buyscript_pass'];

echo <<<EOT

<p class="install-finish-success">vShare Youtube Clone installation completed successfully.</p>

<div class="login-info">

You can login to vShare admin area at:<br /><br />

<a href='$config[baseurl]/admin/' target="_blank">$config[baseurl]/admin/</a><br />

<p>
Username : admin<br />
Password : buyscripts
</p>

<p>You must change default admin password by logging into admin control panel.</p>

<p>Test User Account</p>

<p><a href='$config[baseurl]/login.php' target="_blank">$config[baseurl]/login.php</a></p>

<p>
Username : vshare<br />
Password : $buyscript_pass
</p>

</div>

<p class="install-finish-warning">You must delete the "install" folder now. Also chmod 755 include/config.php</p>

EOT;

require './tpl/footer.php';
