<?php

class UploadRemote
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

        if (preg_match('/&feature=/i', $url)) {
            $yt_url = explode('&feature=', $url);
            $url = $yt_url[0];
        }

        $pattern = '/v=([^&]+)/';
        preg_match($pattern, $url, $matches);
        $video_id = $matches[1];
        $videojpg = $vid . '.jpg';
        $this->video_id = $video_id;
        $source = 'http://img.youtube.com/vi/' . $video_id . '/1.jpg';

        if ($this->err == '') {
            for ($i = 1; $i <= 3; $i ++) {
                if ($i == 1) {
                    $thumb_name = 'mqdefault.jpg';
                } else {
                    $thumb_name = $i . '.jpg';
                }
                $source = 'http://img.youtube.com/vi/' . $video_id . '/' . $thumb_name;
                $desination = VSHARE_DIR . '/thumb/' . $i . '_' . $videojpg;
                $this->upload = Http::download($source, $desination);

                if ($i == 1) {
                    $maxwidth = $config['img_max_width'];
                    $maxheight = $config['img_max_height'];
                    Image::createThumb($desination, VSHARE_DIR . '/thumb/' . $i . '_' . $videojpg, $maxwidth, $maxheight);
                }
            }
            #Create Main Image
            $source = 'http://img.youtube.com/vi/' . $video_id . '/hqdefault.jpg';
            $desination = VSHARE_DIR . '/thumb/' . $vid . '.jpg';
            $this->upload = Http::download($source, $desination);
        }

        if ($this->upload <= 0) {
            $this->upload_failed();
        } else {
            $this->upload_success('1');
        }

        return $this->err;
    }

    function revver()
    {

        global $config;

        $vid = $this->vid;
        $url = $this->url;
        $url = explode('/', $url);

        for ($i = 0; $i < count($url); $i ++) {
            if (is_numeric($url[$i])) {
                $video_id = $url[$i];
            }
        }

        $videojpg = $vid . ".jpg";
        $this->video_id = $video_id;

        if ($this->err == '') {
            for ($i = 1; $i <= 3; $i ++) {
                $source = "http://frame.revver.com/frame/120x190/" . $video_id . ".jpg";
                $desination = VSHARE_DIR . "/thumb/" . $i . "_" . $videojpg;
                $this->upload = Http::download($source, $desination);
                if ($this->debug) {
                    echo "<p>$source,$desination</p>";
                }
            }
            $source = "http://frame.revver.com/frame/120x190/" . $video_id . ".jpg";
            $desination = VSHARE_DIR . "/thumb/" . $vid . ".jpg";
            $this->upload = Http::download($source, $desination);
        }

        if ($this->upload <= 0) {
            $this->upload_failed();
        } else {
            $this->upload_success('4');
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

        for ($i = 0; $i < count($url); $i ++) {
            if (is_numeric($url[$i])) {
                $jpg_id = $url[$i];
            }
        }

        $j = count($url) - 2;
        $video_id = $jpg_id . '/' . $url[$j];
        $this->video_id = $video_id;
        $videojpg = $vid . '.jpg';
        $source = 'http://www.metacafe.com/thumb/' . $jpg_id . '.jpg';

        if ($this->err == '') {
            for ($i = 1; $i <= 3; $i ++) {
                $source = 'http://www.metacafe.com/thumb/' . $jpg_id . '.jpg';
                $desination = VSHARE_DIR . '/thumb/' . $i . '_' . $videojpg;
                $this->upload = Http::download($source, $desination);
            }
            $source = 'http://www.metacafe.com/thumb/' . $jpg_id . '.jpg';
            $desination = VSHARE_DIR . '/thumb/' . $vid . '.jpg';
            $this->upload = Http::download($source, $desination);
        }

        if ($this->upload <= 0) {
            $this->upload_failed();
        } else {
            $this->upload_success('5');
        }

    }

    function upload_failed()
    {
        global $lang;
        $this->err = $lang['upload_failed'];
        $sql = "DELETE FROM `videos` WHERE
		       `video_id`=$this->vid";
        DB::query($sql);
    }

    function upload_success($video_type)
    {
        $sql = "UPDATE `videos` SET
		       `video_name`='$this->video_id',
			   `video_vtype`=$video_type WHERE `video_id`=$this->vid";
        DB::query($sql);
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

        if ($returncode != 200 && $returncode != 302 && $returncode != 304) {
            $err = $lang['invalid_url'];
        }
        return $err;
    }
}
