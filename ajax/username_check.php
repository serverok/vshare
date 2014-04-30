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

$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';

if ((strlen($user_name) < 4) || (check_field_exists($user_name, 'user_name', 'users') == 1) || User::isReserved($user_name)) {
    echo 0;
} else {
    echo 1;
}
