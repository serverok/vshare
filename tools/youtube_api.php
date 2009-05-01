<?php
require '../include/config.php';
require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata_YouTube');

$yt = new Zend_Gdata_YouTube();
$query = $yt->newVideoQuery();
$query->setQuery('Ham Radio');
$query->setStartIndex(0);
$query->setMaxResults(10);

$feed = $yt->getVideoFeed($query);

foreach ($feed as $entry)
{

    $video['video_id'] = $entry->getVideoId();
    $video['thumb_url'] = $entry->mediaGroup->thumbnail[0]->url;
    $video['video_title'] = (string) $entry->mediaGroup->title;
    $video['video_description'] = (string) $entry->mediaGroup->description;
    echo '<pre>';
    print_r($entry);
    echo '</pre><hr>';
}
