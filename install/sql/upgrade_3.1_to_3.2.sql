CREATE TABLE IF NOT EXISTS `episodes` (
  `episode_id` int(11) NOT NULL AUTO_INCREMENT,
  `episode_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`episode_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `episode_videos` (
  `ep_video_id` int(11) NOT NULL AUTO_INCREMENT,
  `ep_video_eid` int(11) NOT NULL DEFAULT '0',
  `ep_video_vid` int(11) NOT NULL DEFAULT '0',
  `ep_video_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ep_video_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;