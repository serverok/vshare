<?php

include('../include/config.php');
include('../include/functions_seo_name.php');

$sql = "SELECT * FROM `channel`";
$result = mysql_query($sql) or mysql_die($sql);

while($channel = mysql_fetch_assoc($result)) {
	$seo_name = seo_name($channel['channel_name']);
	$sql = "UPDATE `channels` SET 
           `channel_seo_name`='$seo_name' WHERE 
           `channel_id`='" . $channel['channel_id'] ."'";
	mysql_query($sql) or mysql_die($sql);
}


?>