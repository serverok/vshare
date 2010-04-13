<?php

function flv_metadata($flv_name, $video_folder, $log_file_name, $debug)
{

    global $config;
    $flv_metadata = get_config('flv_metadata');

    if ($flv_metadata != 'none')
    {
        $video_flv = VSHARE_DIR . '/flvideo/' . $video_folder . $flv_name;

        if ($flv_metadata == 'flvtool')
        {
            $cmd_flvtool = $config['flvtool'] . ' -U ' . $video_flv;
            $tmp = exec($cmd_flvtool, $exec_result);
            $log_text = "<h2>Running flvtool2: $cmd_flvtool</h2>";
            write_log($log_text, $log_file_name, $debug, 'html');
        }
        else if ($flv_metadata == 'yamdi')
        {
            $video_metadata_flv = VSHARE_DIR . '/flvideo/' . $video_folder . 'metadata_' . $flv_name;
            $log_text = "Metadata Flv : $video_metadata_flv";
            write_log($log_text, $log_file_name, $debug, 'html');

            $cmd_yamdi = "/usr/bin/yamdi -i $video_flv -o $video_metadata_flv";
            $tmp = exec($cmd_yamdi, $exec_result);

            $log_text = "<h2>Running yamdi: $cmd_yamdi</h2>";
            write_log($log_text, $log_file_name, $debug, 'html');

            if (file_exists($video_metadata_flv))
            {
                unlink($video_flv);
                rename($video_metadata_flv, VSHARE_DIR . '/flvideo/' . $video_folder . $flv_name);
                $log_text = "Rename : $video_metadata_flv---$flv_name";
                write_log($log_text, $log_file_name, $debug, 'html');
            }
        }
    }

}
