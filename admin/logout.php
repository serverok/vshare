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

$_SESSION['AUID'] = '';
$_SESSION['APASSWORD'] = '';
session_unregister('AUID');
session_unregister('APASSWORD');
session_destroy();
db_close();

$redirect_url = VSHARE_URL . '/index.php';
redirect($redirect_url);
