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
 
$html_title = 'VSHARE UPGRADE';
require '../include/config.php';
require '../include/functions_seo_name.php';
require '../include/class.tags.php';
require './inc/class.sql_import.php';
require './inc/functions_upgrade.php';
require './tpl/header.php';

if ($config['version'] != '2.6')
{
    die('<p>This upgrade script can only upgrade if you are using version: 2.6</p>');
}

write_log('#### UPGRADE 2.6 to 2.7 STARTED ####', 'vshare_upgrade', 0,'txt');

$sql = "ALTER DATABASE `$db_name`
        CHARACTER SET `utf8`";
mysql_query($sql) or mysql_die($sql);
write_log($sql, 'vshare_upgrade', 0,'txt');

$sql_file = VSHARE_DIR . '/install/sql/upgrade_2.6_to_2.7.sql';
$sql_import = new Sql2Db($sql_file);
$sql_import->import();

$sql = "SELECT * FROM `channels`";
$result = mysql_query($sql) or mysql_die($sql);
write_log($sql, 'vshare_upgrade', 0,'txt');

while ($channel = mysql_fetch_assoc($result))
{
    $seo_name = seo_name($channel['channel_name']);
    $sql = "UPDATE `channels` SET
           `channel_seo_name`='" . mysql_clean($seo_name) . "' WHERE
           `channel_id`='" . $channel['channel_id'] . "'";
    mysql_query($sql) or mysql_die($sql);
    write_log($sql, 'vshare_upgrade', 0,'txt');
}

$sql = "ALTER TABLE `videos` ADD
       `video_view_time` INT( 11 ) NOT NULL
        AFTER `viewtime` ";
mysql_query($sql) or mysql_die($sql);
write_log($sql, 'vshare_upgrade', 0,'txt');

$sql = "SELECT `video_id`,`viewtime` FROM `videos`";
$result = mysql_query($sql) or mysql_die($sql);
write_log($sql, 'vshare_upgrade', 0,'txt');

while ($video = mysql_fetch_assoc($result))
{
    $unix_time = strtotime($video['viewtime']);
    $sql = "UPDATE `videos` SET
           `video_view_time`='$unix_time' WHERE
           `video_id`='" . (int) $video['video_id'] . "'";
    mysql_query($sql) or mysql_die($sql);
    write_log($sql, 'vshare_upgrade', 0,'txt');
}

$sql = "ALTER TABLE `videos` CHANGE
       `viewtime` `not_used_viewtime` INT( 11 ) NOT NULL";
mysql_query($sql) or mysql_die($sql);
write_log($sql, 'vshare_upgrade', 0,'txt');

write_log('#### UPGRADE 2.6 to 2.7 FINISHED ####', 'vshare_upgrade', 0,'txt');

$next_step = VSHARE_URL . '/install/build_tags_2.7.php';
upgrade_next_step("2.7","$next_step");
