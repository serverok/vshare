<?php

class BulkImport
{

    public static function checkImported($import_track_unique_id, $import_track_site)
    {
        $sql = "SELECT * FROM `import_track` WHERE
               `import_track_unique_id`='" . mysql_clean($import_track_unique_id) ."' AND
               `import_track_site`='" . mysql_clean($import_track_site) ."'";
        $result = mysql_query($sql);
        return mysql_num_rows($result);
    }

    public static function getYoutubeVideoInfo($video_id)
    {
		$yt = new Zend_Gdata_YouTube();
		$entry = $yt->getVideoEntry($video_id);
		$tmp['video_title'] = (string)$entry->mediaGroup->title;
		$tmp['video_description'] = (string)$entry->mediaGroup->description;
		$tmp['video_keywords'] = (string)$entry->mediaGroup->keywords;
		$tmp['video_duration'] = $entry->mediaGroup->duration->seconds;
		return $tmp;
    }

}