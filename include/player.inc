<?php

$displayheight = $config['player_height'] - 20;

if ($vshare_player == "StrobeMediaPlayback")
{
    $vshare_player = <<<EOT
   <script type="text/javascript" src="{$config['baseurl']}/player/swfobject.js"></script>
   <script type="text/javascript">
   var parameterNames = new Array();
   var parameters =
   {   id: "1"
   ,   src: "{$file}"
   ,   src_title: "VSHARE : Title"
   ,   autoPlay: "{$config['player_autostart']}"
   ,   width: "{$config['player_width']}"
   ,   height: "{$displayheight}"
   ,   controlBarAutoHide: "false"
   ,   controlBarPosition: "bottom"
   ,   poster: "{$video_thumb_url}/thumb/{$video_folder}{$video_id}.jpg"
   ,   plugin_youtube: "{$config['baseurl']}/player/YouTubePlugin.swf"
   };

   for (var i=0; i<parameterNames.length; i++)
   {
   var parameterName = parameterNames[i];
   parameters[parameterName] = parameters[parameterName];
   }

   swfobject.embedSWF
   ( "{$config['baseurl']}/player/StrobeMediaPlayback.swf"
   , "vshare_player"
   , parameters["width"], parameters["height"]
   , "10.0.0"
   , {}
   , parameters
   , { allowFullScreen: "true" }
   , { name: "StrobeMediaPlayback" }
   );
   </script>
   <p id="vshare_player">
       <a href="http://www.adobe.com/go/getflashplayer">
           <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
       </a>
   </p>

EOT;

}
else
{
$vshare_player = <<<EOT

<script type="text/javascript" src="{$config['baseurl']}/player/jwplayer.js"></script>

<p id="vshare_player">
    <a href="http://www.adobe.com/go/getflashplayer">
        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
    </a>
</p>

<script type="text/javascript">
jwplayer("vshare_player").setup({
    file: "{$file}",
    image: "{$video_thumb_url}/thumb/{$video_folder}{$video_id}.jpg",
    logo: {
        file: "{$config['baseurl']}/templates/images/watermark.gif",
        link: "{$config["watermark_url"]}"
    },
    width: "100%",
    aspectratio: "16:9",
    autostart: "{$config['player_autostart']}",
    bufferlength: "{$config['player_bufferlength']}"
});
</script>

EOT;

}
