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
	private $sitemap_url_limit = 50000;
	private $sitemap_url = '';
	
	public function getSitemapInfo()
	{
		$sql = "SELECT * FROM `sitemap` ORDER BY `sitemap_id` DESC";
		$result = mysql_query($sql) or mysql_die($sql);
		
		while($info = mysql_fetch_assoc($result))
		{
			$info['format_size'] = $this->formatSize($info['sitemap_size']);
			$this->sitemap_info[] = $info;
		}		
				
		return $this->sitemap_info;
	}
	
	public function generate()
	{	
		$sql = "SELECT * FROM `sitemap` ORDER BY `sitemap_id` DESC LIMIT 1";	
		$result = mysql_query($sql) or mysql_die($sql);	
	
		if (mysql_num_rows($result) === 0)
		{
			$this->sitemap_name = 'sitemap_' . substr(md5(time() . rand()), 0, 6) .  '.xml';
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
		
		while($video_info = mysql_fetch_assoc($result))
		{
			$this->createSitemap($video_info);
		}
		
		$this->createSitemapIndex();
	}
	
	private function createSitemapIndex()
	{
		$sql = "SELECT * FROM `sitemap` ORDER BY `sitemap_id` DESC";
		$result = mysql_query($sql) or mysql_die($sql);
		
		if (mysql_num_rows($result) > 0)
		{	
			$fp = fopen(VSHARE_DIR . '/sitemap/sitemap_index.xml', 'w');
			
			$sitemap_index = $this->sitemap_index_header;
			fwrite($fp, $sitemap_index);
			
			while($sitemap_info = mysql_fetch_assoc($result))
			{
				$sitemap = '<sitemap>';
				fwrite($fp,	"\n\t\t" . $sitemap . "\n\t\t\t");
				$loc = '<loc>' . VSHARE_URL . '/sitemap/' . $sitemap_info['sitemap_name'] . '</loc>';
				fwrite($fp, $loc . "\n\t\t\t");
				$lastmod = '<lastmod>' . date('Y-m-d h:i:s', $sitemap_info['sitemap_create_date']) . '</lastmod>';
				fwrite($fp, $lastmod . "\n\t\t");
				$sitemap = '</sitemap>';
				fwrite($fp, $sitemap . "\n");
			}
			
			$sitemap_index = $this->sitemap_index_close;
			fwrite($fp, $sitemap_index);
			fclose($fp);
		}
	}	
	
	public function updateSitemap($sitemap_id)
	{
		$sql = "SELECT * FROM `sitemap` WHERE
			   `sitemap_id`='$sitemap_id'";
		$result = mysql_query($sql) or mysql_die($sql);
		
		if (mysql_num_rows($result) > 0)
		{
			$sitemap_info = mysql_fetch_assoc($result);
			$this->sitemap_url_count = $sitemap_info['sitemap_url_count'];
			$this->sitemap_name = $sitemap_info['sitemap_name'];
			
			$sql = "UPDATE `sitemap` SET 
					`sitemap_url_count`='0',
					`sitemap_size`='0' WHERE
			        `sitemap_id`='$sitemap_id'";
			$result = mysql_query($sql) or mysql_die($sql);
			
			$sql = "SELECT * FROM `videos` WHERE
	   		   		`video_approve`='1' AND
	   		   		`video_active`='1' AND
	   		   		`video_id`<=" . $sitemap_info['sitemap_last_video_id'] . " 
	   		   		ORDER BY `video_id` DESC LIMIT " . $sitemap_info['sitemap_url_count'];
	   		$result = mysql_query($sql) or mysql_die($sql);
	   		
	   		$video_info = mysql_fetch_all($result);
	   		unlink(VSHARE_DIR . '/sitemap/' . $this->sitemap_name);
	   		
			$start = count($video_info) - 1;  		
	   		
			for($i=$start;$i>=0;$i--)
			{
				$this->createSitemap($video_info[$i]);
			}
			
			$this->createSitemapIndex();   		
		}
	}	 

	public function deleteSitemap($sitemap_id)
	{
		$sql = "SELECT `sitemap_name` FROM `sitemap` WHERE
			   `sitemap_id`='$sitemap_id'";
		$result = mysql_query($sql) or mysql_die($sql);
		
		if (mysql_num_rows($result) > 0)
		{	
			$tmp = mysql_fetch_assoc($result);
			
			if (file_exists(VSHARE_DIR . '/sitemap/' . $tmp['sitemap_name']))
			{
				unlink(VSHARE_DIR . '/sitemap/' . $tmp['sitemap_name']);
			}
			
			$sql = "DELETE FROM `sitemap` WHERE `sitemap_id`='$sitemap_id'";
			$result = mysql_query($sql) or mysql_die($sql);
		}
	}	
	
	private function createSitemap($video_info)
	{
		$this->checkSitemapDir();
		$this->checkSitemap();
		$this->getUrl($video_info);
		$fp = fopen(VSHARE_DIR . '/sitemap/' . $this->sitemap_name, 'w');
		fwrite($fp, $this->sitemap_xml);
		fwrite($fp, $this->sitemap_urlset_close);
		fclose($fp);
		
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
		
		if (preg_match('/&/i',$video_info['video_title'],$match))
		{
			$video_info['video_title'] = preg_replace('/&/i',htmlentities('&'),$video_info['video_title']);	
		}
		
		if (preg_match('/&/i',$video_info['video_description'],$match))
		{
			$video_info['video_description'] = preg_replace('/&/i',htmlentities('&'),$video_info['video_description']);	
		}		
		
		$this->sitemap_xml .= '
		<url> 
   			<loc>' . VSHARE_URL . '/view/' . $video_info['video_id'] . '/'. $video_info['video_seo_name'] .'/</loc> 
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
				   `sitemap_last_video_id`='" . $video_info['video_id']. "',
				   `sitemap_url_count`=$url_count WHERE
				   `sitemap_name`='$this->sitemap_name'";
			mysql_query($sql) or mysql_die($sql);
		} 
		else
		{	
			$url_count = 1;
			
			$sql = "INSERT INTO `sitemap` SET 
				   `sitemap_last_video_id`='" . $video_info['video_id']. "',
				   `sitemap_url_count`=$url_count,
				   `sitemap_name`='$this->sitemap_name'";
			mysql_query($sql) or mysql_die($sql);
		} 		
	}
	
	private function checkSitemapDir()
	{
		if (!is_dir(VSHARE_DIR . '/sitemap'))
		{
			mkdir(VSHARE_DIR . '/sitemap');
			chdir(VSHARE_DIR . '/sitemap');
		}
	}	
	
	private function checkSitemap()
	{
		$this->sitemap_xml = $this->sitemap_xml_header;
		$this->sitemap_xml .= $this->sitemap_urlset_open;
		
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
					$this->sitemap_xml = file_get_contents(VSHARE_DIR . '/sitemap/' . $this->sitemap_name);
					$this->sitemap_xml = preg_replace('/<\/urlset>/i','',$this->sitemap_xml);
				}
				else 
				{
					$this->sitemap_name = 'sitemap_' . substr(md5(time() . rand()), 0, 6) .  '.xml';
				}
			}
			else 
			{
				$this->sitemap_name = 'sitemap_' . substr(md5(time() . rand()), 0, 6) .  '.xml';
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
	
}