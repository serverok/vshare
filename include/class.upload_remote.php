<?php

class upload_remote
{
    var $vid;
    var $url;
    var $video_id;
    var $err = '';
    var $upload = 0;
    var $debug = 0;

    function youtube()
    {
        global $config;
        $vid = $this->vid;
        $url = $this->url;
        
        if (preg_match('/&feature=/i',$url))
        {
        	$yt_url = explode('&feature=',$url);
        	$url = $yt_url[0];	
        }

        $pattern = '/v=([^&]+)/';
        preg_match($pattern, $url, $matches);
        $video_id = $matches[1];
        $videojpg = $vid . '.jpg';
        $this->video_id = $video_id;
        $source = 'http://img.youtube.com/vi/' . $video_id . '/1.jpg';

        if ($this->err == '')
        {
            for ($i = 1; $i <= 3; $i ++)
            {
                $source = 'http://img.youtube.com/vi/' . $video_id . '/' . $i . '.jpg';
                $desination = VSHARE_DIR . '/thumb/' . $i . '_' . $videojpg;
                $this->upload = download($source, $desination);
            }
            #Create Main Image
            $source = 'http://img.youtube.com/vi/' . $video_id . '/2.jpg';
            $desination = VSHARE_DIR . '/thumb/' . $vid . '.jpg';
            $this->upload = download($source, $desination);
        }

        $youtube_xml = $this->get_youtube_duration('http://www.youtube.com/api2_rest?method=youtube.videos.get_details&dev_id=rG48P7iz0eo&video_id=' . $this->video_id);
        preg_match('/<length_seconds>(.*)<\/length_seconds>/i', $youtube_xml, $duration);

        if (isset($duration[1]))
        {
            $youtube_duration = $duration[1];
            $youtube_video_time = sec2hms($youtube_duration);
            $this->update_youtube_duration($youtube_video_time, $youtube_duration);
        }

        if ($this->upload <= 0)
        {
            $this->upload_failed();
        }
        else
        {
            $this->upload_success('1');
        }

        return $this->err;
    }

    function metacafe()
    {
        global $config;
        //http://www.metacafe.com/watch/891715/digits_using_digits_easy_multiplication/
        //http://akstatic2.metacafe.com/thumb/891715.jpg
        $vid = $this->vid;
        $url = $this->url;
        $url = explode('/', $url);

        for ($i = 0; $i < count($url); $i ++)
        {
            if (is_numeric($url[$i]))
            {
                $jpg_id = $url[$i];
            }
        }

        $j = count($url) - 2;
        $video_id = $jpg_id . '/' . $url[$j];
        $this->video_id = $video_id;
        $videojpg = $vid . '.jpg';
        $source = 'http://www.metacafe.com/thumb/' . $jpg_id . '.jpg';

        if ($this->err == '')
        {
            for ($i = 1; $i <= 3; $i ++)
            {
                $source = 'http://www.metacafe.com/thumb/' . $jpg_id . '.jpg';
                $desination = VSHARE_DIR . '/thumb/' . $i . '_' . $videojpg;
                $this->upload = download($source, $desination);
            }
            $source = 'http://www.metacafe.com/thumb/' . $jpg_id . '.jpg';
            $desination = VSHARE_DIR . '/thumb/' . $vid . '.jpg';
            $this->upload = download($source, $desination);
        }

        if ($this->upload <= 0)
        {
            $this->upload_failed();
        }
        else
        {
            $this->upload_success('5');
        }

    }

    function upload_failed()
    {
        global $lang;
        $this->err = $lang['upload_failed'];
        $sql = "DELETE FROM `videos` WHERE
		       `video_id`=$this->vid";
        $result = mysql_query($sql) or mysql_die($sql);
    }

    function upload_success($video_type)
    {
        $sql = "UPDATE `videos` SET
		       `video_name`='$this->video_id',
			   `video_vtype`=$video_type WHERE `video_id`=$this->vid";
        $result = mysql_query($sql) or mysql_die($sql);
    }

    function url_exists($url)
    {
        global $lang;
        $err = '';
        $resurl = curl_init();
        curl_setopt($resurl, CURLOPT_URL, $url);
        curl_setopt($resurl, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($resurl, CURLOPT_HEADERFUNCTION, 'curlHeaderCallback');
        curl_setopt($resurl, CURLOPT_FAILONERROR, 1);
        curl_exec($resurl);

        $returncode = curl_getinfo($resurl, CURLINFO_HTTP_CODE);
        curl_close($resurl);

        if ($returncode != 200 && $returncode != 302 && $returncode != 304)
        {
            $err = $lang['invalid_url'];
        }
        return $err;
    }

    function get_youtube_duration($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.2) Gecko/20070219 Firefox/2.0.0.2');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $page = curl_exec($ch);
        if (! curl_errno($ch))
        {
            curl_close($ch);
        }
        else
        {
            $page = false;
        }
        return $page;
    }

    function update_youtube_duration($youtube_video_time, $youtube_duration)
    {
        $sql = "UPDATE `videos` SET
		       `video_duration`='$youtube_duration',
		       `video_length`='$youtube_video_time' WHERE
		       `video_id`=$this->vid";
        $result = mysql_query($sql) or mysql_die($sql);
    }
}