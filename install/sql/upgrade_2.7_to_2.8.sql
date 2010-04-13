ALTER TABLE `packages` ADD `package_allow_download` INT( 11 ) NOT NULL DEFAULT '0'
UPDATE `config` SET `config_name` = 'flv_metadata',`config_value` = 'flvtool' WHERE `config_name` = 'enable_flvtool' LIMIT 1 ;
ALTER TABLE `import_track` ADD `import_track_video_id` INT( 11 ) NOT NULL AFTER `import_track_unique_id`;
ALTER TABLE `process_queue` ADD `import_track_id` INT( 11 ) NOT NULL AFTER `process_queue_upload_ip`;
ALTER TABLE `users` ADD `user_friend_invition` tinyint(1) NOT NULL DEFAULT '1';
ALTER TABLE `users` ADD `user_private_message` tinyint(1) NOT NULL DEFAULT '1';
ALTER TABLE `users` ADD `user_profile_comment` tinyint(1) NOT NULL DEFAULT '1';
ALTER TABLE `users` ADD `user_favourite_public` tinyint(1) NOT NULL DEFAULT '1';
ALTER TABLE `users` ADD `user_playlist_public` tinyint(1) NOT NULL DEFAULT '1';

CREATE TABLE IF NOT EXISTS `admin_log` (
  `admin_log_id` int(11) NOT NULL auto_increment,
  `admin_log_user_id` int(11) NOT NULL,
  `admin_log_script` varchar(255) NOT NULL,
  `admin_log_time` int(11) NOT NULL,
  `admin_log_action` varchar(255) NOT NULL,
  `admin_log_extra` varchar(255) NOT NULL,
  `admin_log_ip` varchar(255) NOT NULL,
  PRIMARY KEY  (`admin_log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
