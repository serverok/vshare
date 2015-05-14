<?php

class BulkImport
{

    public static function checkImported($import_track_unique_id, $import_track_site)
    {
        $sql = "SELECT * FROM `import_track` WHERE
               `import_track_unique_id`='" . DB::quote($import_track_unique_id) ."' AND
               `import_track_site`='" . DB::quote($import_track_site) ."'";
        $import_track = DB::fetch1($sql);
        return count($import_track);
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

    public static function getYoutubeVideoId($url = '')
    {
        $search = array(
            '/v\/(.[a-zA-Z0-9_-]+)/i',
            '/v=(.[a-zA-Z0-9_-]+)/i',
            '/embed\/(.[a-zA-Z0-9_-]+)/i',
        );
        foreach ($search as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                if (isset($matches[1])) {
                    return $matches[1];
                }
            }
        }

        return 0;
    }
}
