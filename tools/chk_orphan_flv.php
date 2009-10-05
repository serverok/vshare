<?php

include("../include/config.php");
$dir = "/home/video/public_html/flvideo/";
$orphan = 0;
$not_orphan = 0;
$total_flv = 0;

if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if(is_file($dir.$file)){
            	if (preg_match("/flv/i",$file)) {
            		$sql = "SELECT * FROM `videos` WHERE
                           `video_flv_name`='$file'";
            		$result = mysql_query($sql);
            		$num_result = mysql_num_rows($result);
            		if($num_result == 1){
//            			echo "<font color="green"><b>The file have a parent - $file</b></font><br />";
            			$not_orphan++;
        			} else {
						echo "<font color=\"red\"><b>$file $sql</b></font><br />";
						$orphan++;
						$orphan_file_path = $dir . $file;
						$orphan_file_new_path = "/home/video/public_html/templates_c/" . $file;
						copy($orphan_file_path,$orphan_file_new_path);
						unlink($orphan_file_path);
						echo "<br />";
            		}
				$total_flv++;
				} else {
				    echo "$file do not have .flv extension.<br />";
				}


            } else {
                echo "$file is not a file<br />";
            }

        }
        closedir($dh);
    }
}

echo "Orphan: " . $orphan . "<br />";
echo "Not orphan: " . $not_orphan . "<br />";
echo "Total flv files: " . $total_flv . "<br />";
