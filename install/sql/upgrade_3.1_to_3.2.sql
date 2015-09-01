CREATE TABLE IF NOT EXISTS `episodes` (
  `episode_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `episode_name` varchar(255) NOT NULL
) ENGINE=MYISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `episode_videos` (
  `ep_video_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `ep_video_eid` int(11) NOT NULL DEFAULT '0',
  `ep_video_vid` int(11) NOT NULL DEFAULT '0',
  `ep_video_order` int(11) NOT NULL DEFAULT '0'
) ENGINE=MYISAM DEFAULT CHARSET=utf8 ;

INSERT INTO `config` (`config_name`, `config_value`) VALUES ('episodes', '0');
