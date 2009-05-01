<?php

function get_youtube_flv_url($url)
{
    $debug = 0;
    $v = $url;
    if ($debug) echo "<p>$v</p>";

    $v = split('=', $url);
    $video_id = $v[1];

    $content = file_get_contents($url);

    if (preg_match_all("/&t=[^&]*/", $content, $matches))
    {
        $t = $matches[0][0];
        $t = preg_split("/=/", $t);
        $t = $t[1];
        $flv_url = 'http://www.youtube.com/get_video.php?video_id=' . $video_id . '&t=' . $t . '&.flv';
    }

    return $flv_url;
}
