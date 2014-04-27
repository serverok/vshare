<?php


function create_video_thumb($video_id)
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

        $video_duration_cmd = get_config('video_duration_cmd');

        if ($video_duration_cmd == 0) {
            $duration = video_duration::find_video_duration_mplayer($t_info);
            $find_with = 'mplayer';
        } else if ($video_duration_cmd == 1) {
            $duration = video_duration::find_video_duration_ffmpeg($t_info);
            $find_with = 'ffmpeg';
        } else {
            $duration = video_duration::find_video_duration_ffmpeg_php($t_info);
            $find_with = 'ffmpeg-php';
        }

        $t_info['duration'] = $duration;

        if ($video_duration_cmd == 0) {
            $tmp = video_thumb::create_thumb_mplayer($t_info);
            $find_with = 'mplayer';
        } else if ($video_duration_cmd == 1) {
            $tmp = video_thumb::create_thumb_ffmpeg($t_info);
            $find_with = 'ffmpeg';
        } else {
            $tmp = video_thumb::create_thumb_ffmpeg_php($t_info);
            $find_with = 'ffmpeg-php';
        }

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
}
