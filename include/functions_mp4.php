<?php

/******************************************************************************
 *
 * COMPANY: BuyScripts.in
 * PROJECT: vShare Youtube Clone
 * VERSION: [VSHARE_VERSION]
 * LISENSE: http://buyscripts.in/vshare-license.html
 * WEBSITE: http://buyscripts.in/youtube_clone.html
 *
 * This program is a commercial software and any kind of using it must agree
 * to vShare license.
 *
 ******************************************************************************/

function mp4_metadata($mp4_name, $video_folder, $log_file_name, $debug)
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
