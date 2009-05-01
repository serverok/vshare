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

require '../include/config.php';
require './inc/functions_upgrade.php';
$html_title = 'VSHARE UPGRADE';
require './tpl/header.php';

if ($config['version'] != '20070712')
{
    die('<p>This upgrade script can only upgrade if you are using version: 20070712</p>');
}

# upgrade to version 20070730

write_log('#### UPGRADE 20070712 to 20070730 STARTED ####', 'vshare_upgrade', 0,'txt');

$sql = "SELECT * FROM video";
$result = mysql_query($sql) or mysql_die();

while ($video_info = mysql_fetch_assoc($result))
{
    $vid = $video_info['VID'];
    $flvdoname = $video_info['flvdoname'];
    
    if (strlen($flvdoname) < 4)
    {
        $flvdoname = $vid . '.flv';
        $sql = "UPDATE video SET 
               `flvdoname`='" . mysql_clean($flvdoname) . "' WHERE
               `VID`='" . (int) $vid . "'";
        mysql_query($sql) or mysql_die($sql);
        echo "<p>Correcting video: " . $flvdoname . "</p>";
    }
}

$sql = "CREATE TABLE `profile_comments` (
      `id` int(11) NOT NULL auto_increment,
      `uid` int(11) NOT NULL default '0',
      `posted_by` int(11) NOT NULL,
      `comment` text NOT NULL,
      `ip` varchar(255) NOT NULL default '',
      `date` datetime NOT NULL default '0000-00-00 00:00:00',
      PRIMARY KEY  (`id`),
      KEY `uid` (`uid`)
    );";

mysql_query($sql) or mysql_die($sql);

$sql = "INSERT INTO `emailinfo` (`email_id`, `email_subject`, `email_path`, `comment`) VALUES ('recommend_friends', '\$username sent you a video!', 'emails/recommend_friends.tpl', 'share videos with others');";
mysql_query($sql) or mysql_die($sql);

$sql = "UPDATE `sconfig` SET `svalue` = '20070730' WHERE `soption` = 'version'";
mysql_query($sql) or mysql_die($sql);

write_log('#### UPGRADE 20070712 to 20070730 FINISHED ####', 'vshare_upgrade', 0,'txt');

upgrade_next_step("20070730");
