<?php

$displayheight = $config['player_height'] - 20;

//{$config['baseurl']}/player/swfobject.js

$vshare_player = <<<EOT

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.1/swfobject.js"></script>

<p id="vshare_player">
    <a href="http://www.adobe.com/go/getflashplayer">
        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
    </a>
</p>

<script type="text/javascript">

var flashvars = {
  file: "{$file}",
  image: "{$video_thumb_url}/thumb/{$video_folder}{$video_id}.jpg",
  logo: "{$config['baseurl']}/templates/images/watermark.gif",
  link: "{$config["watermark_url"]}",
  linktarget: "_blank",
  width: "$config[player_width]",
  height: "$config[player_height]",
  displayheight: "$displayheight",
  autostart: "{$config['player_autostart']}",
  overstretch: "true"
};
var params = {
  menu: "false",
  allowfullscreen: "true"
};
var attributes = {
  id: "vshare-swf",
  name: "vshare-swf"
};
swfobject.embedSWF("{$config['baseurl']}/player/player.swf", "vshare_player", "$config[player_width]", "$config[player_height]", "9.0.0",false, flashvars, params, attributes);
</script>

EOT;
