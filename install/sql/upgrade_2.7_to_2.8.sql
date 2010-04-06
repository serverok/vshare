ALTER TABLE `packages` ADD `package_allow_download` INT( 11 ) NOT NULL DEFAULT '0'
UPDATE `config` SET `config_name` = 'flv_metadata',`config_value` = 'flvtool' WHERE `config_name` = 'enable_flvtool' LIMIT 1 ;
ALTER TABLE `import_track` ADD `import_track_video_id` INT( 11 ) NOT NULL AFTER `import_track_unique_id`;
ALTER TABLE `process_queue` ADD `import_track_id` INT( 11 ) NOT NULL AFTER `process_queue_upload_ip`;
ALTER TABLE `users` ADD `user_friend_invition` tinyint(1) NOT NULL DEFAULT '1';
ALTER TABLE `users` ADD `user_private_message` tinyint(1) NOT NULL DEFAULT '1';
ALTER TABLE `users` ADD `user_profile_comment` tinyint(1) NOT NULL DEFAULT '1';
ALTER TABLE `users` ADD `user_favourite_public` tinyint(1) NOT NULL DEFAULT '1';
ALTER TABLE `users` ADD `user_playlist_public` tinyint(1) NOT NULL DEFAULT '1';
