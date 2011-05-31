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

$html_title = 'VSHARE INSTALLATION';

require '../include/config.php';
require 'tpl/header.php';

$tables = array();

$q = mysql_query('SHOW TABLES');

while ($r = @mysql_fetch_array($q))
{
    $tables[] = $r[0];
}

@mysql_free_result($q);

if (in_array('videos', $tables))
{
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

}
else
{
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
    $result = mysql_query($sql) or mysql_die($sql);
    
    echo "<p class=\"tables-created\">Database tables created.</p>
        <form action=\"install_finished.php\" METHOD=\"POST\">
        <input type=\"hidden\" name=\"buyscript_pass\" value=\"$buyscript_pass\" />
        <input type=\"submit\" name=\"submit\" value=\"Continue Installation >>\" class=\"button\" />
        </form>";
}

require './tpl/footer.php';
