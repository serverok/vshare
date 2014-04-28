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

    public static function createThumbFfmpeg($t_info)
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

    public static function createThumbMplayer($t_info)
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

            video_thumb::create_thumb($source_image, $fd, $maxwidth, $maxheight);

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

    function createThumbFfmpegPhp($t_info)
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
                video_thumb::create_thumb($ff, $fd, $config['img_max_width'], $config['img_max_height']);
                $fc ++;
            }
            $try ++;
            if ($try > 10 || $fc == 4)
            {
                break;
            }
        }
    }

    function createThumb($srcname, $destname, $maxwidth, $maxheight)
    {
        global $config;
        $oldimg = $srcname; //$config['basepath']."/photo/".$srcname;
        $newimg = $destname; //$config['basepath']."/photo/".$destname;


        $imagedata = GetImageSize($oldimg);
        $imagewidth = $imagedata[0];
        $imageheight = $imagedata[1];
        $imagetype = $imagedata[2];

        $shrinkage = 1;
        if ($imagewidth > $maxwidth)
        {
            $shrinkage = $maxwidth / $imagewidth;
        }
        if ($shrinkage != 1)
        {
            $dest_height = $shrinkage * $imageheight;
            $dest_width = $maxwidth;
        }
        else
        {
            $dest_height = $imageheight;
            $dest_width = $imagewidth;
        }

        if ($dest_height > $maxheight)
        {
            $shrinkage = $maxheight / $dest_height;
            $dest_width = $shrinkage * $dest_width;
            $dest_height = $maxheight;
        }

        if ($imagetype == 2)
        {
            $src_img = imagecreatefromjpeg($oldimg);
            $dst_img = imageCreateTrueColor($dest_width, $dest_height);
            ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $imagewidth, $imageheight);
            imagejpeg($dst_img, $newimg, 100);
            imagedestroy($src_img);
            imagedestroy($dst_img);
        }
        elseif ($imagetype == 3)
        {
            $src_img = imagecreatefrompng($oldimg);
            $dst_img = imageCreateTrueColor($dest_width, $dest_height);
            ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $imagewidth, $imageheight);
            imagepng($dst_img, $newimg, 100);
            imagedestroy($src_img);
            imagedestroy($dst_img);
        }
        else
        {
            $src_img = imagecreatefromgif($oldimg);
            $dst_img = imageCreateTrueColor($dest_width, $dest_height);
            ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $imagewidth, $imageheight);
            imagejpeg($dst_img, $newimg, 100);
            imagedestroy($src_img);
            imagedestroy($dst_img);
        }
    }
}
