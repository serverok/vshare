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
    echo "<p class=\"text-danger lead\">If you are doing fresh install, make sure the database is empty.</p>";

    echo "

    <div class=\"row\">
      <div class=\"col-md-4\">
        <form name='yesgo' method='POST' action=''>
        <input type='submit' class='btn-block btn btn-primary btn-lg' name='submit' value='Retry Installing' />
        <input type='hidden' name='step' value='2' />
        <input type=\"hidden\" name=\"db_host\" value=\"$db_host\" />
        <input type=\"hidden\" name=\"db_name\" value=\"$db_name\" />
        <input type=\"hidden\" name=\"db_user\" value=\"$db_user\" />
        <input type=\"hidden\" name=\"db_pass\" value=\"$db_pass\" />
        <input type=\"hidden\" name=\"action\" value=\"create_tables\" />
        </form>
      </div>
    </div>
    ";

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
           `user_salt` = '',
           `user_first_name` = '',
           `user_last_name` = '',
           `user_birth_date` = '0000-00-00',
           `user_gender` = '',
           `user_relation` = '',
           `user_about_me` = '',
           `user_town` = '',
           `user_city` = '',
           `user_zip` = '',
           `user_country` = '',
           `user_occupation` = '',
           `user_company` = '',
           `user_school` = '',
           `user_interest_hobby` = '',
           `user_fav_movie_show` = '',
           `user_fav_music` = '',
           `user_fav_book` = '',
           `user_friends_type`='All|Family|Friends',
           `user_video_viewed` = '0',
           `user_profile_viewed` = '0',
           `user_watched_video` = '0',
           `user_ip` = '',
           `user_email_verified`='yes',
           `user_subscribe_admin_mail` = '1',
           `user_account_status`='Active',
           `user_vote` = '',
           `user_rated_by` = '0',
           `user_rate` = '0',
           `user_parents_name` = '',
           `user_parents_email` = '',
           `user_friends_name` = '',
           `user_friends_email` = '',
           `user_adult` = '0',
           `user_photo` = '0',
           `user_background` = '0',
           `user_style` = '',
           `user_friend_invition` = '1',
           `user_private_message` = '1',
           `user_profile_comment` = '1',
           `user_favourite_public` = '1',
           `user_playlist_public` = '1',
           `user_videos` = '0',
           `user_join_time`='" . time() . "',
           `user_last_login_time`='" . time() . "'";
    DB::query($sql);

    $logo_url_md = $config['baseurl'] . '/themes/default/images/logo.png';
    $logo_url_sm = $config['baseurl'] . '/themes/default/images/logo-small.png';
    $watermark_image_url = $config['baseurl'] . '/themes/default/images/watermark.png';

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . DB::quote($logo_url_md) . "' WHERE
           `soption`='logo_url_md'";
    DB::query($sql);

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . DB::quote($logo_url_sm) . "' WHERE
           `soption`='logo_url_sm'";
    DB::query($sql);

    $sql = "UPDATE `sconfig` SET
           `svalue`='" . DB::quote($watermark_image_url) . "' WHERE
           `soption`='watermark_image_url'";
    DB::query($sql);

    echo "
    <div class=row>
      <div class=col-md-12>
        <div class=\"alert alert-success\">
          <strong>Database tables created</strong>
        </div>
        <form action=\"install_finished.php\" METHOD=\"POST\">
        <input type=\"hidden\" name=\"buyscript_pass\" value=\"$buyscript_pass\" />
        <input type=\"submit\" name=\"submit\" value=\"Continue Installation\" class=\"col-md-4 btn btn-primary btn-lg\" />
        </form>
      </div>
    </div>";
}



require './tpl/footer.php';
