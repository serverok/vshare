<?php

require '../include/config.php';
require '../include/functions_seo_name.php';

$sql = "SELECT * FROM `channel`";
$channels_all = DB::fetch($sql);

foreach ($channels_all as $channel) {
	$seo_name = seo_name($channel['channel_name']);
	$sql = "UPDATE `channels` SET
           `channel_seo_name`='$seo_name' WHERE
           `channel_id`='" . $channel['channel_id'] ."'";
	DB::query($sql);
}
