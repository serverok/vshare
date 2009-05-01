<?php

$cmd_ffmpeg = "$config[ffmpeg] -i '$video_src' -acodec libmp3lame -ar 22050 -ab 32 -f flv $video_flv";

# For old version of mplayer
# $cmd_mencoder = "$config[mencoder] '$video_src' -o $video_flv -of lavf -oac mp3lame -lameopts abr:br=56 -ovc lavc -lavcopts vcodec=flv:vbitrate=500:mbd=2:mv0:trell:v4mv:cbp:last_pred=3 -srate 22050 -lavfopts i_certify_that_my_video_stream_does_not_use_b_frames";

# For latest version of mplayer
$cmd_mencoder = "$config[mencoder] '$video_src' -o $video_flv -of lavf -oac mp3lame -lameopts abr:br=56 -ovc lavc -lavcopts vcodec=flv:vbitrate=500:mbd=2:mv0:trell:v4mv:cbp:last_pred=3 -srate 22050 -ofps 24 -vf harddup";

$cmd_all = $cmd_mencoder;

$convert_3gp = $cmd_all;
$convert_mp4 = $cmd_all;
$convert_mov = $cmd_all;
$convert_asf = $cmd_all;
$convert_mpg = $cmd_all;
$convert_avi = $cmd_all;
$convert_mpeg = $cmd_all;
$convert_wmv = $cmd_all;
$convert_rm = $cmd_all;
$convert_dat = $cmd_all;
