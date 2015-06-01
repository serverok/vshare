UPDATE `sconfig` SET `svalue`='250' WHERE `soption`='img_max_width';
UPDATE `sconfig` SET `svalue`='130' WHERE `soption`='img_max_height';
INSERT INTO `config` (`config_name`, `config_value`) VALUES ('youtube_api_key', '');
UPDATE `sconfig` SET `svalue` = '3.0' WHERE `soption` = 'version';