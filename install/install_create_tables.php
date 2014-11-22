<?php
/******************************************************************************
 *
 * COMPANY: BuyScripts.in
 * PROJECT: vShare Youtube Clone
 * VERSION: [VSHARE_VERSION]
 * LICENSE: http://buyscripts.in/vshare-license
 * WEBSITE: http://buyscripts.in/vshare-youtube-clone
 *
 * This program is a commercial software and any kind of using it must agree
 * to vShare license.
 *
 ******************************************************************************/

session_start();

require 'inc/functions.php';
require '../include/classes/DB.php';

$html_title = 'VSHARE INSTALLATION';

require 'tpl/header.php';

$tables = array();

DB::connect($_SESSION['VSHARE_INSTALL']['DB_HOST'],$_SESSION['VSHARE_INSTALL']['DB_USER'],$_SESSION['VSHARE_INSTALL']['DB_PASSWORD'], $_SESSION['VSHARE_INSTALL']['DB_NAME']);

$tables = DB::fetch('SHOW TABLES');

if (! empty($tables)) {

    echo "<p>Your database already have tables needed for vshare. If you are upgrading, use the upgrade script instead.</p>";
    echo "<p class=\"table-already-exists\">If you are doing fresh install, make sure the database is empty.</p>";

    echo "<form name='yesgo' method='POST' action=''>
    <input type='submit' class='button' name='submit' value='Retry Installing' />
    <input type='hidden' name='step' value='2' />
    <input type=\"hidden\" name=\"db_host\" value=\"$db_host\" />
    <input type=\"hidden\" name=\"db_name\" value=\"$db_name\" />
    <input type=\"hidden\" name=\"db_user\" value=\"$db_user\" />
    <input type=\"hidden\" name=\"db_pass\" value=\"$db_pass\" />
    <input type=\"hidden\" name=\"action\" value=\"create_tables\" />
    </form>";

} else {

    require 'inc/class.sql_import.php';
    $sql_import = new Sql2Db('sql/vshare.sql');
    $sql_import->debug_filename = 'install';
    $sql_import->import();

    $buyscript_pass = rand();
    $buyscript_pass_md5 = md5($buyscript_pass);

    $sql = "INSERT INTO `users` SET
           `user_email`='you@yourdomain.com',
           `user_name`='vshare',
           `user_password`='$buyscript_pass_md5',
           `user_website`='http://buyscripts.in',
           `user_friends_type`='All|Family|Friends',
           `user_email_verified`='yes',
           `user_account_status`='Active',
           `user_join_time`='" . time() . "',
           `user_last_login_time`='" . time() . "'";
    DB::query($sql);

    echo "<p class=\"tables-created\">Database tables created.</p>
        <form action=\"install_finished.php\" METHOD=\"POST\">
        <input type=\"hidden\" name=\"buyscript_pass\" value=\"$buyscript_pass\" />
        <input type=\"submit\" name=\"submit\" value=\"Continue Installation >>\" class=\"button\" />
        </form>";
}

require './tpl/footer.php';
