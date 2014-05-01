<?php

class VideoDuration
{

    public static function find($video_data)
    {
        if ($video_data['tool'] == 'mplayer') {
            $duration = self::_findWithMplayer($video_data);
        } else if ($video_data['tool'] == 'ffmpeg') {
            $duration = self::_findWithFfmpeg($video_data);
        } else {
            $duration = self::_findWithFfmpegPhp($video_data);
        }
        return $duration;
    }

    private static function _findWithFfmpeg($duration_arr)
    {
        global $config;
        $video = $duration_arr['src'];
        $debug = isset($duration_arr['debug']) ? $duration_arr['debug'] : 0;
        $cmd = $config['ffmpeg'] . " -i " . $video;
        @exec("$cmd 2>&1", $output);
        $output_all = implode("\n", $output);

        if ($debug) {
            echo "<p>$cmd</p>";
            echo "<pre>";
            print_r($output_all);
            echo "</pre>";
        }

        if (@preg_match('/Duration: ([0-9][0-9]:[0-9][0-9]:[0-9\.]+), .*/', $output_all, $regs)) {
            $sec = $regs[1];
            $duration_array = explode(":", $sec);
            $sec = ($duration_array[0] * 3600) + ($duration_array[1] * 60) + $duration_array[2];
            $sec = (int) $sec;
            if ($debug) echo "<p>Duration found = $sec seconds.</p>";
        } else {
            $sec = 0;
        }
        return $sec;
    }

    private static function _findWithMplayer($duration_arr)
    {
        global $config;
        $video = $duration_arr['src'];
        $debug = isset($duration_arr['debug']) ? $duration_arr['debug'] : 0;
        $cmd = $config['mplayer'] . " -vo null -ao null -frames 0 -identify " . $video;
        @exec("$cmd 2>&1", $output);
        $output_all = implode("\n", $output);

        if ($debug) {
            echo "<p>$cmd</p>";
            echo "<pre>";
            print_r($output_all);
            echo "</pre>";
        }

        if (@preg_match('/ID_LENGTH=([0-9\.]+)/', $output_all, $regs)) {
            $sec = (int) $regs[1];
        } else {
            $sec = 0;
        }
        return $sec;
    }

    private static function _findWithFfmpegPhp($duration_arr)
    {
        $video = $duration_arr['src'];
        $output = new ffmpeg_movie($video);
        $sec = $output->getDuration();
        $sec = round($sec, 2);
        return $sec;
    }
}
