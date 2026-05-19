<?php

require '../include/config.php';
require '../include/class.tags.php';

$sql = "DROP TABLE `tags`, `tag_video`";
DB::query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL auto_increment,
  `tag` varchar(255) NOT NULL,
  `tag_count` int(11) NOT NULL default '0',
  `used_on` int(11) NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

DB::query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS `tag_video` (
  `id` int(11) NOT NULL auto_increment,
  `tag_id` int(11) NOT NULL,
  `vid` int(11) NOT NULL,
  `chid` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

DB::query($sql);


$sql = "SELECT * FROM `videos` WHERE `video_type`='public'";
$result = DB::query($sql);

while ($video_info = mysqli_fetch_assoc($result))
{
    $video_id = $video_info['video_id'];
    $video_keywords = $video_info['video_keywords'];
    $video_channels = $video_info['video_channels'];
    $video_user_id = $video_info['video_user_id'];
    $video_add_time = $video_info['video_add_time'];

    $tags = new Tags($video_keywords, $video_id, $video_user_id, $video_channels);
    $tags->settime($video_add_time);
    $tags->add();

    $video_tags = $tags->get_tags();
    $video_keywords_new = implode(' ', $video_tags);

    echo $sql = "UPDATE `videos` SET
                  `video_keywords`='" . DB::quote($video_keywords_new) . "' WHERE
                  `video_id`='" . (int) $video_id . "'";
    var_dump($video_keywords);
    echo "<p>$sql</p><br>";

    DB::query($sql);
}
