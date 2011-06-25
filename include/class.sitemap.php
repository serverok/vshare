<?php

class sitemap
{
    public $sitemap_info = array();
    private $sitemap_xml_header = '<?xml version="1.0" encoding="UTF-8"?>';
    private $sitemap_urlset_open = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.sitemaps.org/schemas/sitemap-image/1.1"
        xmlns:video="http://www.sitemaps.org/schemas/sitemap-video/1.1">';
    private $sitemap_urlset_close = '</urlset>';
    private $sitemap_index_header = '<?xml version="1.0" encoding="UTF-8"?>
   		<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    private $sitemap_index_close = '</sitemapindex>';
    private $where = '';
    private $sitemap_name = '';
    private $sitemap_xml = '';
    private $sitemap_url_count = 0;
    private $sitemap_size_limit = 10485760;
    private $sitemap_url_limit = 20000;
    private $sitemap_url = '';
    private $sitemap_xml_read = '';

    public function getSitemapInfo()
    {
        $sql = "SELECT * FROM `sitemap` ORDER BY `sitemap_id` DESC";
        $result = mysql_query($sql) or mysql_die($sql);
        
        while ($info = mysql_fetch_assoc($result))
        {
            $info['format_size'] = $this->formatSize($info['sitemap_size']);
            $this->sitemap_info[] = $info;
        }
        
        return $this->sitemap_info;
    }

    public function generateDaily()
    {
        $sql = "SELECT `sitemap_create_date` FROM `sitemap` ORDER BY `sitemap_id` DESC LIMIT 1";
        $result = mysql_query($sql) or mysql_die($sql);
        $sitemap_info = mysql_fetch_assoc($result);
        $sitemap_create_date = $sitemap_info['sitemap_create_date'];
        $sitemap_expiry_time = $sitemap_create_date + 86400; //  86400 = seconds in 24 hours
        $now_time = time();
        
        if ($sitemap_expiry_time < $now_time)
        {
            $this->generate();
        }
    }

    public function generate()
    {
        $sql = "SELECT * FROM `sitemap` ORDER BY `sitemap_id` DESC LIMIT 1";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result) == 0)
        {
            $this->sitemap_name = $this->createNewSitemapName();
        }
        else
        {
            $sitemap_info = mysql_fetch_assoc($result);
            
            $last_video_id = $sitemap_info['sitemap_last_video_id'];
            $this->sitemap_url_count = $sitemap_info['sitemap_url_count'];
            $this->where = "AND `video_id`>$last_video_id";
            $this->sitemap_name = $sitemap_info['sitemap_name'];
        }
        
        $sql = "SELECT * FROM `videos` WHERE
	   		   `video_approve`='1' AND
	   		   `video_active`='1'
	   		   $this->where ORDER BY `video_id` ASC";
        $result = mysql_query($sql) or mysql_die($sql);
        
        while ($video_info = mysql_fetch_assoc($result))
        {
            $this->createSitemap($video_info);
        }
        
        return $this->createSitemapIndex();
    }

    private function createSitemapIndex()
    {
        $sql = "SELECT * FROM `sitemap` ORDER BY `sitemap_id` DESC";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result) > 0)
        {
            $gz = gzopen(VSHARE_DIR . '/sitemap/sitemap_index.xml.gz', 'w9');
            $sitemap_index = $this->sitemap_index_header;
            gzwrite($gz, $sitemap_index);
            
            while ($sitemap_info = mysql_fetch_assoc($result))
            {
                $sitemap = '<sitemap>';
                gzwrite($gz, "\n\t\t" . $sitemap . "\n\t\t\t");
                $loc = '<loc>' . VSHARE_URL . '/sitemap/' . $sitemap_info['sitemap_name'] . '</loc>';
                gzwrite($gz, $loc . "\n\t\t\t");
                $lastmod = '<lastmod>' . date('Y-m-d h:i:s', $sitemap_info['sitemap_create_date']) . '</lastmod>';
                gzwrite($gz, $lastmod . "\n\t\t");
                $sitemap = '</sitemap>';
                gzwrite($gz, $sitemap . "\n");
            }
            
            $sitemap_index = $this->sitemap_index_close;
            gzwrite($gz, $sitemap_index);
            gzclose($gz);
            
            return $this->submitToGoogle();
        }
    }

    private function createSitemap($video_info)
    {
        $this->checkSitemapDir();
        $this->checkSitemap();
        $this->getUrl($video_info);
        
        $gz = gzopen(VSHARE_DIR . '/sitemap/' . $this->sitemap_name, 'w9');
        
        if (file_exists(VSHARE_DIR . '/sitemap/' . $this->sitemap_name) && filesize(VSHARE_DIR . '/sitemap/' . $this->sitemap_name) > 26)
        {
            gzwrite($gz, $this->sitemap_xml_read);
        }
        else
        {
            gzwrite($gz, $this->sitemap_xml_header);
            gzwrite($gz, $this->sitemap_urlset_open);
        }
        
        gzwrite($gz, $this->sitemap_xml);
        gzwrite($gz, $this->sitemap_urlset_close);
        gzclose($gz);
        
        $sitemap_size = filesize(VSHARE_DIR . '/sitemap/' . $this->sitemap_name);
        
        $sql = "UPDATE `sitemap` SET
			   `sitemap_size`='$sitemap_size',
			   `sitemap_create_date`='" . time() . "' WHERE
			   `sitemap_name`='$this->sitemap_name'";
        mysql_query($sql) or mysql_die($sql);
    }

    private function getUrl($video_info)
    {
        global $servers;
        
        if (preg_match('/&/i', $video_info['video_title'], $match))
        {
            $video_info['video_title'] = preg_replace('/&/i', htmlentities('&'), $video_info['video_title']);
        }
        
        if (preg_match('/&/i', $video_info['video_description'], $match))
        {
            $video_info['video_description'] = preg_replace('/&/i', htmlentities('&'), $video_info['video_description']);
        }
        
        $this->sitemap_xml = '
		<url>
   			<loc>' . VSHARE_URL . '/view/' . $video_info['video_id'] . '/' . $video_info['video_seo_name'] . '/</loc>
    		<video:video>
      			<video:player_loc allow_embed="yes" autoplay="ap=1">' . VSHARE_URL . '/v/' . $video_info['video_id'] . htmlentities('&') . 'hl=en_US' . htmlentities('&') . 'fs=1</video:player_loc>
      			<video:thumbnail_loc>' . $servers[$video_info['video_server_id']] . '/thumb/' . $video_info['video_folder'] . '1_' . $video_info['video_id'] . '.jpg</video:thumbnail_loc>
      			<video:title>' . $video_info['video_title'] . '</video:title>
      			<video:description>' . $video_info['video_description'] . '</video:description>
    		</video:video>
  		</url>';
        
        $sql = "SELECT `sitemap_name`,`sitemap_url_count` FROM `sitemap` WHERE
			   `sitemap_name`='$this->sitemap_name'";
        $tmp = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($tmp) > 0)
        {
            $info = mysql_fetch_assoc($tmp);
            $url_count = $info['sitemap_url_count'] + 1;
            
            $sql = "UPDATE `sitemap` SET
				   `sitemap_last_video_id`='" . $video_info['video_id'] . "',
				   `sitemap_url_count`=$url_count WHERE
				   `sitemap_name`='$this->sitemap_name'";
            mysql_query($sql) or mysql_die($sql);
        }
        else
        {
            $url_count = 1;
            
            $sql = "INSERT INTO `sitemap` SET
				   `sitemap_last_video_id`='" . $video_info['video_id'] . "',
				   `sitemap_url_count`=$url_count,
				   `sitemap_name`='$this->sitemap_name'";
            mysql_query($sql) or mysql_die($sql);
        }
    }

    private function checkSitemapDir()
    {
        if (! is_dir(VSHARE_DIR . '/sitemap'))
        {
            if (! mkdir(VSHARE_DIR . '/sitemap'))
            {
                die('Create folder sitemap with 777 permission');
            }
            
            if (! chdir(VSHARE_DIR . '/sitemap'))
            {
                die('Failed to change directory sitemap');
            }
        }
    }

    private function checkSitemap()
    {
        if (file_exists(VSHARE_DIR . '/sitemap/' . $this->sitemap_name))
        {
            $sql = "SELECT `sitemap_url_count` FROM `sitemap` WHERE
				   `sitemap_name`='" . $this->sitemap_name . "'";
            $tmp = mysql_query($sql) or mysql_die($sql);
            
            if (mysql_num_rows($tmp) > 0)
            {
                $sitemap_info = mysql_fetch_assoc($tmp);
                
                if ($sitemap_info['sitemap_url_count'] < $this->sitemap_url_limit && filesize(VSHARE_DIR . '/sitemap/' . $this->sitemap_name) <= $this->sitemap_size_limit)
                {
                    
                    $sitemap_gz = fopen(VSHARE_DIR . '/sitemap/' . $this->sitemap_name, "rb");
                    fseek($sitemap_gz, - 4, SEEK_END);
                    $buffer = fread($sitemap_gz, 4);
                    $sitemap_gz_file_size = end(unpack("V", $buffer));
                    fclose($sitemap_gz);
                    
                    $zd = gzopen(VSHARE_DIR . '/sitemap/' . $this->sitemap_name, "r");
                    $this->sitemap_xml_read = gzread($zd, $sitemap_gz_file_size);
                    gzclose($zd);
                    $this->sitemap_xml_read = preg_replace('/<\/urlset>/i', '', $this->sitemap_xml_read);
                }
                else
                {
                    $this->sitemap_name = $this->createNewSitemapName();
                }
            }
            else
            {
                $this->sitemap_name = $this->createNewSitemapName();
            }
        }
    
    }

    private function formatSize($size)
    {
        if ($size >= 1073741824)
        {
            $format_size = number_format($size / 1073741824, 1) . ' GB';
        }
        else if ($size >= 1048576)
        {
            $format_size = number_format($size / 1048576, 1) . ' MB';
        }
        else
        {
            $format_size = number_format($size / 1024, 1) . ' KB';
        }
        
        return $format_size;
    }

    private function createNewSitemapName()
    {
        $i = 0;
        $sitemap_name = 'sitemap';
        $sitemap_extn = 'xml.gz';
        $file_name = $sitemap_name . '.' . $sitemap_extn;
        $desination = VSHARE_DIR . '/sitemap/' . $file_name;
        
        while (file_exists($desination))
        {
            $i ++;
            $file_name = $sitemap_name . '_' . $i . '.' . $sitemap_extn;
            $desination = VSHARE_DIR . '/sitemap/' . $file_name;
        }
        
        return $file_name;
    }

    private function submitToGoogle()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.google.com/webmasters/tools/ping?sitemap=" . VSHARE_URL . "/sitemap/sitemap_index.xml.gz");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
        return 'Sitemap Generated And Submitted to Google';
    }

}