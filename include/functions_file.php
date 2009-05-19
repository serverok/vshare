<?php

function get_file_url($server_id, $folder, $name)
{

    global $config;

    $sql = "SELECT * FROM `servers` WHERE
           `id`=$server_id";
    $result = mysql_query($sql) or mysql_die($sql);
    $server_info = mysql_fetch_assoc($result);

    if ($server_info['server_type'] == 2 && $server_id != 0)
    {
        $secret = $server_info['server_secdownload_secret'];

        //$f = '/' . $folder . '/' . $name;
        $f = '/' . $name;
        $t = time();
        $t_hex = sprintf("%08x", $t);
        $m = md5($secret . $f . $t_hex);
        $url_parts = parse_url($server_info['url']);

        if ($url_parts['port'] == 80)
        {
            $server_url = 'http://' . $url_parts['host'];
        }
        else
        {
            $server_url = 'http://' . $url_parts['host'] . ':' . $url_parts['port'];
        }

        $file_url = $server_url . '/dl/' . $m . '/' . $t_hex . $f;
    }
    else
    {
        $file_url = $server_info['url'] . '/' . $folder . $name;
    }

    return $file_url;
}
