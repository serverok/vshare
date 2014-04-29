<?php

class Media
{
    public static function flvMetadata($flv_name, $video_folder, $log_file_name, $debug)
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

    public static function mp4Metadata($mp4_name, $video_folder, $log_file_name, $debug)
    {
        $video_metadata_mp4 = VSHARE_DIR . '/flvideo/' . $video_folder . 'metadata_' . $mp4_name;
        $video_mp4 = (string) VSHARE_DIR . '/flvideo/' . $video_folder . $mp4_name;
        $video_mp4 = trim($video_mp4);

        if (file_exists($video_mp4)) {
            $log_text = "Metadata Mp4 : $video_metadata_mp4";
            write_log($log_text, $log_file_name, $debug, 'html');

            if (! file_exists(VSHARE_DIR . '/include/qt-faststart/qt-faststart')) {
                $cmd_faststart = 'gcc ' . VSHARE_DIR . '/include/qt_faststart/qt-faststart.c -o ' . VSHARE_DIR . '/include/qt_faststart/qt-faststart';
                $tmp = exec($cmd_faststart, $exec_result);
                $log_text = "<h2>Compile with gcc: $cmd_faststart</h2>";
                write_log($log_text, $log_file_name, $debug, 'html');
            }

            $cmd_qt_faststart = VSHARE_DIR . "/include/qt_faststart/qt-faststart $video_mp4 $video_metadata_mp4";
            $tmp = exec($cmd_qt_faststart, $exec_result);
            $log_text = "<h2>Running qt-faststart: $cmd_qt_faststart</h2>";
            write_log($log_text, $log_file_name, $debug, 'html');

            $return_data_all = '';

            for ($i = 0; $i < count($exec_result); $i ++) {
                $return_data = $exec_result[$i];
                $return_data = trim($return_data);
                $return_data = $return_data . "\n";
                $return_data_all = $return_data_all . $return_data;
            }

            $log_text = '<hr /><pre>' . $return_data_all . '</pre><hr />';
            write_log($log_text, $log_file_name, $debug, 'html');

            if (file_exists($video_metadata_mp4)) {
                unlink($video_mp4);
                rename($video_metadata_mp4, VSHARE_DIR . '/flvideo/' . $video_folder . $mp4_name);
                $log_text = "Rename : $video_metadata_mp4---$mp4_name";
                write_log($log_text, $log_file_name, $debug, 'html');
            }
        }
    }
}