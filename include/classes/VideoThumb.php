<?php

/*
video => thumbnail
input ==> video path, vid
video_thumb_cmd
0 - mplayer
1 - ffmpeg
2 - ffmpeg-php

*/

class VideoThumb
{
    public static function make($video_data)
    {
        if (! isset($video_data['duration'])) {
            $video_data['duration'] = VideoDuration::find($video_data);
        }

        if ($video_data['tool'] == 'mplayer') {
            $tmp = self::_createWithMplayer($video_data);
        } else if ($video_data['tool'] == 'ffmpeg') {
            $tmp = self::_createWithFfmpeg($video_data);
        } else {
            $tmp = self::_createWithFfmpegPhp($video_data);
        }

        return $tmp;
    }

    private static function _createWithFfmpeg($t_info)
    {

        global $config;

        $duration = $t_info['duration'];
        $debug = isset($t_info['debug']) ? $t_info['debug'] : 0;
        $step = intval($t_info['duration'] / 5);

        if ($step < 2)
        {
            $step = 1;
        }
        else if ($step > 20)
        {
            $step_c = intval($step / 20);
            $step_a = $step - $step_c;
            $step_b = $step + $step_c;
            $step = rand($step_a, $step_b);
        }

        $i = 1;

        if ($debug)
        {
            echo "<h2>Creating Thumbnail with ffmpeg</h2>";
        }

        $thumb_folder = VSHARE_DIR . '/thumb/' . $t_info['video_folder'];
        $no_thumb_image = VSHARE_DIR . '/templates/images/no_thumbnail.gif';
        unlink($thumb_folder . '/' . $t_info['vid'] . ".jpg");
        unlink($thumb_folder . '/1_' . $t_info['vid'] . ".jpg");
        unlink($thumb_folder . '/2_' . $t_info['vid'] . ".jpg");
        unlink($thumb_folder . '/3_' . $t_info['vid'] . ".jpg");

        $fc = 0;

        for ($pos = 1; $pos <= $duration; $pos += $step)
        {

            # echo "<h1>$pos = 1; $pos < $duration; $pos += $step</h1>";


            $pos_this = $pos;

            if ($fc == 0)
            {
                $maxwidth = 320;
                $maxheight = 240;
                $pos_this = rand(1, $duration);
                $fd = $thumb_folder . '/' . $t_info['vid'] . ".jpg";
            }
            else
            {
                $maxwidth = $config['img_max_width'];
                $maxheight = $config['img_max_height'];
                $fd = $thumb_folder . "/" . $fc . "_" . $t_info['vid'] . ".jpg";
                if ($fc == 1)
                {
                    $pos_this = rand(1, $duration);
                }
            }

            $thumb_position = sec2hms($pos_this);

            if (strlen($thumb_position) == 5)
            {
                $thumb_position = '00:' . $thumb_position;
            }

            if ($debug)
            {
                echo "<p>$fd</p>";
            }

            $cmd = "$config[ffmpeg] -i $t_info[src] -ss $thumb_position -t 00:00:01 -s " . $maxwidth . 'x' . $maxheight . " -r 1 -f mjpeg $fd";
            @exec("$cmd 2>&1", $output);

            if ($debug)
            {
                echo "<pre>$cmd</pre>";
            }

            if (! file_exists($fd))
            {
                copy($no_thumb_image, $fd);
            }

            $fc ++;

            if ($fc == 4)
            {
                break;
            }
        }

        if (file_exists($fd))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    private static function _createWithMplayer($t_info)
    {
        global $config;

        $debug = isset($t_info['debug']) ? $t_info['debug'] : 0;

        $output_folder = VSHARE_DIR . '/templates_c/' . $t_info['vid'] . '/';
        $thumb_folder = VSHARE_DIR . '/thumb/' . $t_info['video_folder'];

        mkdir($output_folder);

        $duration = intval($t_info['duration']);
        $sstep = intval($t_info['duration'] / 5);

        if ($sstep < 2)
        {
            $sstep = 0;
        }
        else if ($sstep > 20)
        {
            $sstep_c = intval($sstep / 20);
            $sstep_a = $sstep - $sstep_c;
            $sstep_b = $sstep + $sstep_c;
            $sstep = rand($sstep_a, $sstep_b);
        }

        $fc = 0;

        for ($i = 1; $i < $duration; $i += $sstep)
        {

            $cmd = $config['mplayer'] . " $t_info[src] -ss " . $i . " -nosound -vo jpeg:outdir=" . $output_folder . " -frames 2";
            @exec("$cmd 2>&1", $output_all);

            write_log($cmd);
            if ($debug)
            {
                echo "<h1>CREATING THUMBNAIL $fc</h1>";
                echo "<p>$cmd</p>";
                echo "<pre>";
                print_r($output_all);
                echo "</pre>";
            }

            if ($fc == 0)
            {
                $maxwidth = 320;
                $maxheight = 240;
                $fd = $thumb_folder . '/' . $t_info['vid'] . ".jpg";
            }
            else
            {
                $maxwidth = $config['img_max_width'];
                $maxheight = $config['img_max_height'];
                $fd = $thumb_folder . "/" . $fc . "_" . $t_info['vid'] . ".jpg";
            }

            if ($debug)
            {
                echo "<p>$fd</p>";
            }

            $source_image = $output_folder . "/00000002.jpg";

            if (! file_exists($source_image))
            {
                $source_image = $output_folder . "/00000001.jpg";
            }

            if (! file_exists($source_image))
            {
                $source_image = VSHARE_DIR . "/templates/images/no_thumbnail.gif";
            }

            Image::createThumb($source_image, $fd, $maxwidth, $maxheight);

            $fc ++;

            if ($fc == 4)
            {
                break;
            }
        }

        if (file_exists($output_folder . "/00000001.jpg"))
        {
            unlink($output_folder . "/00000001.jpg");
        }
        if (file_exists($output_folder . "/00000002.jpg"))
        {
            unlink($output_folder . "/00000002.jpg");
        }

        rmdir($output_folder);
    }

    private static function _createWithFfmpegPhp($t_info)
    {
        global $config;

        $video_src = $t_info['src'];
        $duration = $t_info['duration'];
        $debug = isset($t_info['debug']) ? $t_info['debug'] : 0;

        $mov = new ffmpeg_movie($video_src);
        $frcount = $mov->getFrameCount() - 1;
        $try = 1;
        $fc = 1;

        while (1)
        {
            $p = rand(1, $frcount);
            $ff_frame = $mov->getFrame($p);
            if ($ff_frame == true)
            {
                $gd_image = $ff_frame->toGDImage();
                $ff = VSHARE_DIR . '/thumb/' . $t_info['video_folder'] . '/' . $t_info['vid'] . '.jpg';
                imagejpeg($gd_image, $ff);
                $fd = VSHARE_DIR . '/thumb/' . $t_info['video_folder'] . '/' . $fc . '_' . $t_info['vid'] . '.jpg';
                Image::createThumb($ff, $fd, $config['img_max_width'], $config['img_max_height']);
                $fc ++;
            }
            $try ++;
            if ($try > 10 || $fc == 4)
            {
                break;
            }
        }
    }

    /*
    // duplicate (remote later)
    public static function createVideoThumb($video_id)
    {
        global $config;
        $config['debug'] = 0;

        $log_file_name = 'create_thumb_' . $video_id;

        echo "<p>Inside finction " . $video_id . "</p>";

        $video_info = Video::getById($video_id);

        if (! $video_info) {
            echo '<p>No video found</p>';
            return 'Video not found.';
        }

        echo '<pre>';
        print_r($video_info);
        echo '</pre>';

        $video_src = VSHARE_DIR . '/video/' . $video_info['video_name'];

        if ($config['debug']) {
            $log_text = '<p>$video_src = ' . $video_src . '</p>';
            write_log($log_text, $log_file_name, $config['debug'], 'html');
        }

        if (file_exists($video_src) && is_file($video_src)) {
            if ($config['debug']) {
                $log_text = '<p>File found = ' . $video_src . '</p>';
                write_log($log_text, $log_file_name, $config['debug'], 'html');
            }

            if ($video_info['video_folder'] != '') {
                if (! is_dir(VSHARE_DIR . '/thumb/' . $video_info['video_folder'])) {
                    mkdir(VSHARE_DIR . '/thumb/' . $video_info['video_folder']);
                }
            }

            if ($config['debug']) {
                $log_text = '<p>thumb_folder = ' . VSHARE_DIR . '/thumb/' . $video_info['video_folder'] . '</p>';
                write_log($log_text, $log_file_name, $config['debug'], 'html');
            }

            $t_info = array();
            $t_info['src'] = $video_src;
            $t_info['vid'] = (int) $video_id;
            $t_info['video_folder'] = $video_info['video_folder'];
            $t_info['debug'] = $config['debug'];

            $find_with = Config::get('tool_video_thumb');
            $t_info['tool'] = $find_with;

            $duration = VideoDuration::find($t_info);

            $t_info['duration'] = $duration;

            $tmp = self::make($t_info);

            if ($video_info['video_thumb_server_id'] > 0) {
                if ($config['debug']) {
                    $log_text = '<p>$video_info[\'video_thumb_server_id\'] = ' . $video_info['video_thumb_server_id'] . '</p>';
                    write_log($log_text, $log_file_name, $config['debug'], 'html');
                }
                $ftp_config = array();
                $ftp_config['debug'] = $config['debug'];
                $ftp_config['video_id'] = $video_id;
                $ftp_config['log_file_name'] = 'log_create_thumb';
                $ftp_config['must_upload'] = 1;
                $ftp = new Ftp();
                $ftp->upload_thumb($ftp_config);
            }
            echo '<p>Thumbnail created</p>';
        } else {
            echo '<p>Video not found</p>';
        }
    }*/
}
