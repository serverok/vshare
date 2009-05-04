<?php

$displayheight = $config['player_height'] - 20;

$vshare_player = <<<EOT

<script type="text/javascript" src="{$config['baseurl']}/player/swfobject_1.5.js"></script>

<p id="vshare_player">
    <a href="http://www.adobe.com/go/getflashplayer">
        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
    </a>
</p>

<script type="text/javascript">
var so = new SWFObject("{$config['baseurl']}/player/player.swf","vshare_player","$config[player_width]","$config[player_height]","8");
so.addParam("allowfullscreen","true");
so.addVariable("file","{$file}");
so.addVariable("image","{$video_thumb_url}/thumb/{$video_folder}{$video_id}.jpg");
so.addVariable("logo","{$config['baseurl']}/templates/images/watermark.gif");
so.addVariable("link","{$config["watermark_url"]}");
so.addVariable("linktarget","_blank");
so.addVariable("width","{$config['player_width']}");
so.addVariable("height","{$config['player_height']}");
so.addVariable("displayheight","$displayheight");
so.addVariable("overstretch", "true");
so.addVariable("autostart", "{$config['player_autostart']}");
so.addVariable("bufferlength", "{$config['player_bufferlength']}");
so.write('vshare_player');
</script>

EOT;
