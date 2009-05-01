<?php

session_start();

$db_host     = 'localhost';
$db_name     = 'vshare';
$db_user     = 'vshare';
$db_pass     = 'vshare';

$language = "en";

$config = array();
$config['ffmpeg']          =  '/usr/bin/ffmpeg';
$config['mplayer']          =  '/usr/bin/mplayer';
$config['mencoder']          =  '/usr/bin/mencoder';
$config['flvtool']          =  '/usr/bin/flvtool2';
$config['basedir']        =  '/home/web/vshare';
$config['baseurl']        =  'http://linux/web/vshare';

include($config['basedir'] . '/include/vshare.php');
