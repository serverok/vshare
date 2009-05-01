<?php

include("../include/config.php");

$sql = "SELECT * FROM `videos`";
$result = mysql_query($sql)or die("Unable to execute Query".mysql_error());

while($myobj=mysql_fetch_object($result)){

$id = $myobj->video_id;
$title = $myobj->video_title;
$description = $myobj->video_description;
$keyword = $myobj->video_keywords;

$title_new = addslashes(trim(strip_tags($title)));
$description_new = addslashes(trim(strip_tags($description)));
$keyword_new  = ereg_replace("[^a-zA-Z0-9]+"," ",$keyword);
$keyword_new  = ereg_replace("[ ]+"," ",$keyword_new);

$sql = "UPDATE `videos` SET 
       `video_title`='$title_new', 
       `video_description`='$description_new', 
       `video_keywords`='$keyword_new' 
        WHERE `video_id`=$id";

echo "$sql <br />";
$result1 = mysql_query($sql)or die("Unable to execute Query".mysql_error());

}
