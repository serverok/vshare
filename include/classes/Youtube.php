<?php

class Youtube
{
    public static function getFlvUrl($url)
    {
        $content = file_get_contents($url);

        if (preg_match('/"video_id": "(.*?)"/', $content, $match) && preg_match('/"t": "(.*?)"/', $content, $match1)) {
            $url = "http://www.youtube.com/get_video?video_id=" . $match[1] . "&t=" . $match1[1];
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $cookie_name = md5(rand() . time());
            $cookiefile = VSHARE_DIR . '/templates_c/' . $cookie_name;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiefile);
            $data = curl_exec($ch);

            unlink($cookiefile);

            if (preg_match('/Location: (.*?)[\r\n]+/', $data, $match) || preg_match('/http-equiv=\'Refresh\' content=\'[0-9]+;url=(.*?)\'/s', $data, $match)) {
                return $match[1];
            }
        } else {
            echo "<p>failed to find youtube video url.</p>";
            exit();
        }
    }

}
