<?php
/******************************************************************************
 *
 *   COMPANY: BuyScripts.in
 *   PROJECT: vShare Youtube Clone
 *   VERSION: 2.8
 *   LISENSE: http://buyscripts.in/vshare-license.html
 *   WEBSITE: http://buyscripts.in/youtube_clone.html
 *
 *   This program is a commercial software and any kind of using it must agree 
 *   to vShare license.
 *
 ******************************************************************************/

require '../include/config.php';
require '../include/functions_file.php';

$destination_folder = VSHARE_DIR . '/flvideo_new';

if (is_dir($destination_folder))
{
    echo $destination_folder . ' already exist.Please delete and try again';
    exit();
}
else
{
    if (! mkdir($destination_folder))
    {
        echo 'Failed to create directory';
        exit();
    }
}

$sql = "SELECT * FROM `videos` WHERE `video_server_id`='0'";
$result = mysql_query($sql) or die('Unable to execute query');

while ($videoInfo = mysql_fetch_assoc($result))
{
    $videoFileName = $videoInfo['video_folder'] . $videoInfo['video_flv_name'];
    $fileExtension = getFileExtension($videoInfo['video_flv_name']);
    $input_path = VSHARE_DIR . '/flvideo/' . $videoFileName;
    
    if (! file_exists($input_path))
    {
        echo 'ERROR: File Not found ' . $input_path . "\n";
        continue;
    }
    
    if ($fileExtension == 'flv')
    {
        $output_path = VSHARE_DIR . '/flvideo_new/' . $videoFileName;
        
        if (! is_dir(VSHARE_DIR . '/flvideo_new/' . $videoInfo['video_folder']))
        {
            mkdir(VSHARE_DIR . '/flvideo_new/' . $videoInfo['video_folder']);
        }
        
        $cmd = "/usr/bin/yamdi -i $input_path -o $output_path";
        exec($cmd);
        echo $cmd . "\n";
    }
}

