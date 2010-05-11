<?php

class video_player
{
    var $video_info;

    function get_player_code($video_id)
    {
        global $config;
        $sql = "SELECT * FROM `videos` WHERE
               `video_id`=$video_id";
        $result = mysql_query($sql) or mysql_die($sql);

        if (mysql_num_rows($result) == 0)
        {
            return 'video not found';
        }

        $this->video_info = mysql_fetch_assoc($result);

        switch ($this->video_info['video_vtype'])
        {
            case 0:
                return $this->vshare_player();
                break;
            case 1:
                return $this->youtube();
                break;
            case 2:
                return $this->flv_url();
                break;
            case 3:
                return $this->divx();
                break;
            case 4:
                return $this->revver();
                break;
            case 5:
                return $this->metcafe();
                break;
            case 6:
                return $this->embedded_code();
                break;
            default:
                break;
        }

    }

    function vshare_player()
    {
        global $config , $servers;

        $video_folder = $this->video_info['video_folder'];

        if ($this->video_info['video_server_id'] == 0)
        {
            $file = VSHARE_URL . '/flvideo/' . $video_folder . $this->video_info['video_flv_name'];
            $video_id = $this->video_info['video_id'];
        }
        else
        {
            $sql = "SELECT * FROM `servers` WHERE
			       `id`='" . (int) $this->video_info['video_server_id'] . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            $server_info = mysql_fetch_assoc($result);
            $video_id = $this->video_info['video_id'];

            if ($server_info['server_type'] == 2)
            {
                $uri_prefix = '/dl/';
                $f = '/' . $this->video_info['video_folder'] . $this->video_info['video_flv_name'];
                $t = time();
                $t_hex = sprintf('%08x', $t);
                $m = md5($server_info['server_secdownload_secret'] . $f . $t_hex);
                $file = $server_info['url'] . $uri_prefix . $m . '/' . $t_hex . $f;
            }
            else
            {
                $file = $server_info['url'] . '/' . $this->video_info['video_folder'] . $this->video_info['video_flv_name'];
            }
        }
        $video_thumb_url = $servers[$this->video_info['video_thumb_server_id']];

        require VSHARE_DIR . '/include/player.inc';
        return $vshare_player;
    }

    function youtube()
    {
        global $config,$servers;
        $youtube_player = get_config('youtube_player');
        
        if ($youtube_player == 'vshare')
        {
            $video_folder = $this->video_info['video_folder'];
            $file = 'http://www.youtube.com/v/' . $this->video_info['video_name'];
            $video_id = $this->video_info['video_id'];
            $video_thumb_url = $servers[$this->video_info['video_thumb_server_id']];

	        require VSHARE_DIR . '/include/player.inc';
	        return $vshare_player;
        }
                
        $vshare_player = '
        <object width="' . $config['player_width'] . '" height="' . $config['player_height'] . '">
        <param name="movie" value="http://www.youtube.com/v/' . $this->video_info['video_name'] . '&autoplay=' . $config['player_autostart'] . '&hl=en&fs=1"></param>
        <param name="allowFullScreen" value="true"></param>
        <param name="allowscriptaccess" value="always"></param>
        <embed src="http://www.youtube.com/v/' . $this->video_info['video_name'] . '&autoplay=' . $config['player_autostart'] . '&hl=en&fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true"
        width="' . $config['player_width'] . '" height="' . $config['player_height'] . '"></embed>
        </object>';
        return $vshare_player;
    }

    function revver()
    {
        global $config;
        $vshare_player = "<embed type=\"application/x-shockwave-flash\"
						src=\"http://flash.revver.com/player/1.0/player.swf\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\"
						scale=\"noScale\" salign=\"TL\" bgcolor=\"#000000\" allowScriptAccess=\"always\"
						flashvars=\"mediaId={$this->video_info['video_name']}&affiliateId=0&allowFullScreen=true\" allowfullscreen=\"true\"
						height=\"$config[player_height]\" width=\"$config[player_width]\"></embed>";
        return $vshare_player;
    }

    function metcafe()
    {
        global $config;
        $vshare_player = "<embed src=\"http://www.metacafe.com/fplayer/{$this->video_info['video_name']}.swf\" width=\"$config[player_width]\"
				 height=\"$config[player_height]\" wmode=\"transparent\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\"
				 type=\"application/x-shockwave-flash\"> </embed>";
        return $vshare_player;
    }

    function embedded_code()
    {
        return $this->video_info['video_embed_code'];
    }

    function flv_url()
    {
        global $config, $servers;
        $file = $this->video_info['video_embed_code'];
        $video_id = $this->video_info['video_id'];
        $video_folder = $this->video_info['video_folder'];
        $video_thumb_url = $servers[$this->video_info['video_thumb_server_id']];
        require VSHARE_DIR . '/include/player.inc';
        return $vshare_player;
    }
}