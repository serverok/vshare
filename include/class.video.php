<?php

require_once VSHARE_DIR . '/include/language/' . LANG . '/lang_class_video.php';
require_once VSHARE_DIR . '/include/class.xss.php';

class Video
{
    public $video_id;
    public $video_title;
    public $video_description;
    public $video_keywords;
    public $video_channels;
    public $video_type;
    public $video_allow_comment;
    public $video_allow_rated;
    public $video_allow_embed;
    public $video_featured;
    public $video_active;
    public $video_duration;
    public $video_embeded_code;
    public $is_admin = 0;
    public $video_info;

    public function Video()
    {
    
    }

    public static function video_update()
    {
        global $lang;
        
        $tags_delete = 0;
        $tags_add = 0;
        $sql_extra = '';
        
        $valid = $this->validate_video_info();
        
        if ($valid != 1)
        {
            return $valid;
        }
        
        $channel_list_formatted = implode('|', $this->video_channels);
        $channel_list_formatted = '0|' . $channel_list_formatted . '|0';
        
        $this->video_info = $this->get_video_info($this->video_id);
        
        if ($this->is_admin == 0)
        {
            if ($_SESSION['UID'] != $this->video_info['video_user_id'])
            {
                $error = $lang['not_video_owner'];
                return $error;
            }
        }
        
        if ($this->video_info['video_title'] != $this->video_title)
        {
            require VSHARE_DIR . '/include/functions_seo_name.php';
            $seo_name = seo_name($this->video_title);
            $seo_name_org = $seo_name;
            $i = 1;
            
            while (check_field_exists($seo_name, 'video_seo_name', 'videos'))
            {
                $seo_name = $seo_name_org . '-' . $i;
                $i ++;
            }
            
            $sql_extra .= ",`video_seo_name`='" . mysql_clean($seo_name) . "' ";
            $this->video_info['video_seo_name'] = $seo_name;
        }
        
        $tags_add = 0;
        $tags_delete = 0;
        
        /*
        Add Tags
        1. when a private video changed to public
        2. when keywords edited
        
        Delete Tags
        1. A video changed to private from public
        2. when keyword edited
        */
        
        // conditon 1
        
        if ($this->video_info['video_type'] != $this->video_type)
        {
            if ($this->video_type == 'public')
            {
                $tags_add = 1;
            }
            else
            {
                $tags_delete = 1;
            }
        }

        // condition 2
        
        if ($this->video_info['video_keywords'] != $this->video_keywords && $this->video_type == 'public')
        {
            $tags_delete = 1;
            $tags_add = 1;
        }
        
        if ($tags_delete == 1)
        {
            $tags = new Tags($this->video_info['video_keywords'], $this->video_id, $this->video_info['video_user_id'], $channel_list_formatted);
            $tags->delete();
            unset($tags);
        }
        
        if ($tags_add == 1)
        {
            $tags = new Tags($this->video_keywords, $this->video_id, $this->video_info['video_user_id'], $channel_list_formatted);
            $tags->add();
            $video_tags = $tags->get_tags();
            $this->video_keywords = implode(' ',$video_tags);
            unset($tags);
        }
        
        if ($this->is_admin == 1)
        {
            $sql_extra .= ",`video_featured`='$this->video_featured',
                            `video_active`='$this->video_active',
                            `video_duration`='$this->video_duration',
                            `video_length`='" . sec2hms($this->video_duration) . "'";
            
            if ($this->video_info['video_vtype'] == 2 || $this->video_info['video_vtype'] == 6)
            {
                $sql_extra .= ",`video_embed_code`='$this->video_embeded_code'";
            }
        }
        
        $sql = "UPDATE `videos` SET
               `video_title`='" . mysql_clean($this->video_title) . "',
               `video_description`='" . mysql_clean($this->video_description, 1) . "',
               `video_keywords`='" . mysql_clean($this->video_keywords) . "',
               `video_channels`='$channel_list_formatted',
               `video_type`='" . mysql_clean($this->video_type) . "',
               `video_allow_comment`='" . mysql_clean($this->video_allow_comment) . "',
               `video_allow_rated`='" . mysql_clean($this->video_allow_rated) . "',
               `video_allow_embed`='" . mysql_clean($this->video_allow_embed) . "'
                $sql_extra WHERE
               `video_id`='" . (int) $this->video_id . "' AND
               `video_user_id`='" . $this->video_info['video_user_id'] . "'";
        
        mysql_query($sql) or mysql_die($sql);
        
        return 1;
    }
    
    public static function get_video_info($video_id)
    {
        $sql = "SELECT * FROM `videos` WHERE
               `video_id`='" . (int) $video_id . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_numrows($result) == 1)
        {
            return mysql_fetch_assoc($result);
        }
        else
        {
            return 0;
        }
    }
    
    public static function validate_video_info()
    {
        global $lang , $num_max_channels;
        
        $error = array();
        
        $this->video_title = strip_tags($this->video_title);
        $this->video_title = trim($this->video_title);
        
        $this->video_keywords = strip_tags($this->video_keywords);
        $this->video_keywords = trim($this->video_keywords);
        
        $this->video_description = trim($this->video_description);
        
        if (get_magic_quotes_gpc())
        {
            $this->video_description = stripslashes($this->video_description);
        }
        
        if ($this->is_admin == 0)
        {
            $this->video_description = Xss::clean($this->video_description);
        }
        
        if ($this->video_type != 'private')
        {
            $this->video_type = 'public';
        }
        
        if ($this->video_allow_comment != 'no')
        {
            $this->video_allow_comment = 'yes';
        }
        
        if ($this->video_allow_rated != 'no')
        {
            $this->video_allow_rated = 'yes';
        }
        
        if ($this->video_featured != 'no')
        {
            $this->video_featured = 'yes';
        }
        
        if ($this->video_allow_embed == 1)
        {
            $this->video_allow_embed = 'enabled';
        }
        else
        {
            $this->video_allow_embed = 'disabled';
        }
        
        if ($this->video_active != 0)
        {
            $this->video_active = 1;
        }
        
        if ($this->is_admin == 1)
        {
            if (! is_numeric($this->video_duration))
            {
                $error[] = $lang['video_duration_empty'];
            }
        }
        
        if (strlen_uni($this->video_title) < 8)
        {
            $error[] = $lang['video_title_empty'];
        }
        
        if (strlen_uni($this->video_description) < 8)
        {
            $error[] = $lang['video_description_empty'];
        }
        
        if (strlen_uni($this->video_keywords) < 8)
        {
            $error[] = $lang['video_keyword_empty'];
        }
        
        $channels_valid = array();
        
        foreach ($this->video_channels as $channel)
        {
            $channel = (int) $channel;
            
            if (! in_array($channel, $channels_valid) && check_field_exists($channel, 'channel_id', 'channels'))
            {
                $channels_valid[] = $channel;
            }
        }
        
        $this->video_channels = $channels_valid;
        
        if ((count($this->video_channels) < 1) || (count($this->video_channels) > $num_max_channels))
        {
            $error[] = str_replace('[NUM_MAX_CHANNELS]', $num_max_channels, $lang['channel_not_selected']);
        }
        
        if (count($error))
        {
            $error_msg = '<ul>';
            for ($i = 0; $i < count($error); $i ++)
            {
                $error_msg .= '<li>' . $error[$i] . '</li>';
            }
            $error_msg .= '</ul>';
            
            return $error_msg;
        }
        else
        {
            return 1;
        }
    }
    
    public static function get_related_videos($video_id)
    {
        global $config , $servers;
        
        $video_info = Video::get_video_info($video_id);
        
        $keyword = trim($video_info['video_keywords']);
        $keyword = mysql_clean($keyword);
        #echo $keyword;
        

        $tag = new Tags($keyword, $video_id, '', '0||0');
        $tags = $tag->get_tags();
        unset($tag);
        #echo "<pre>";print_r($tags);echo "</pre>";
        

        $related_vid = array();
        
        for ($i = 0; $i < count($tags); $i ++)
        {
            $sql = "SELECT tv.vid FROM
                   `tag_video` AS tv,
                   `tags` AS t WHERE
                    tv.tag_id=t.id AND
                    t.tag='" . mysql_clean($tags[$i]) . "'
                    GROUP BY tv.vid";
            $result = mysql_query($sql) or mysql_die($sql);
            
            while ($tmp_array = mysql_fetch_assoc($result))
            {
                $tmp = $tmp_array['vid'];
                if (! in_array($tmp, $related_vid))
                {
                    $related_vid[] = $tmp;
                }
            }
            unset($tmp_array);
        }
        #echo count($related_vid);
        
        
        if (count($related_vid) < 2)
        {
            $sql = "SELECT `video_id` FROM `videos` WHERE
                   `video_user_id`='" . (int) $video_info['video_user_id'] . "' AND
                   `video_type`='public' AND
                   `video_active`=1 AND
                   `video_approve`=1
                    ORDER BY `video_id` DESC";
            $result = mysql_query($sql) or mysql_die($sql);
            
            while ($tmp_array = mysql_fetch_assoc($result))
            {
                if (! in_array($tmp_array['video_id'], $related_vid))
                {
                    $related_vid[] = $tmp_array['video_id'];
                }
            }
        }
        
        # Find Position Of Curent Video in related_vid array
        $video_this = 0;
        for ($i = 0; $i < count($related_vid); $i ++)
        {
            if ($related_vid[$i] == $video_id)
            {
                $video_this = $i;
                break;
            }
        }
        
        # Generate List of Related Videos
        
        
        $array_index_start = $video_this - ($config['rel_video_per_page'] / 2);
        
        if ($array_index_start < 0)
        {
            $array_index_start = 0;
            if (count($related_vid) > $config['rel_video_per_page'])
            {
                $array_index_end = $config['rel_video_per_page'] - 1;
            }
            else
            {
                $array_index_end = count($related_vid) - 1;
            }
        }
        
        if (! isset($array_index_end))
        {
            $array_index_end = $video_this + ($config['rel_video_per_page'] / 2);
            if ($array_index_end > count($related_vid))
            {
                $array_index_end = count($related_vid) - 1;
            }
        }
        
        #echo 'start' , $array_index_start , '<br />';
        #echo 'end', $array_index_end;
        

        #echo "<pre>"; print_r($related_vid);
        $array_index_start = intval($array_index_start);
        $array_index_end = intval($array_index_end);
        for ($i = $array_index_start; $i <= $array_index_end; $i ++)
        {
            if (isset($related_vid[$i]))
            {
                $sql = "SELECT * FROM `videos` WHERE
                       `video_active`=1 AND
                       `video_approve`=1 AND
                       `video_type`='public' AND
                       `video_id`=" . (int) $related_vid[$i];
                #echo "$i > $sql <br />";
                $result = mysql_query($sql) or mysql_die($sql);
                if (mysql_num_rows($result) == 1)
                {
                    while ($related_video = mysql_fetch_assoc($result))
                    {
                        $related_video['video_thumb_url'] = $servers[$related_video['video_thumb_server_id']];
                        $related_videos[] = $related_video;
                    }
                }
            }
        }
        
        return $related_videos;
    }
    
    function delete($video_id, $video_uid, $delete = 1)
    {
        global $conn , $config;
        $log_file_name = 'delete_' . $video_id;
        
        $sql = "SELECT * FROM `videos` WHERE
               `video_id`='" . (int) $video_id . "' AND
               `video_user_id`='" . (int) $video_uid . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        $num_result = mysql_num_rows($result);
        
        if ($num_result == 1)
        {
            $video_info = mysql_fetch_assoc($result);
            $vdoname = $video_info['video_name'];
            $video_flv_name = $video_info['video_flv_name'];
            $video_space = $video_info['video_space'];
            $vtype = $video_info['video_vtype'];
            $current_keyword = $video_info['video_keywords'];
            $server_id = $video_info['video_server_id'];
            $video_folder = $video_info['video_folder'];
            
            if ($server_id != 0 && $delete == 1)
            {
                $ftp_config = array();
                $ftp_config['video_id'] = $video_id;
                $ftp_config['debug'] = $config['debug'];
                $ftp_config['log_file_name'] = $log_file_name;
                $ftp = new Ftp();
                $ftp->delete_video($ftp_config);
                $ftp->close();
            }
            else if ($delete == 1)
            {
                
                if ($vtype == 0 && $server_id == 0)
                {
                    # DELETE FLV IF LOCAL VIDEO
                    $flv = VSHARE_DIR . '/flvideo/' . $video_folder . $video_flv_name;
                    
                    if (file_exists($flv))
                    {
                        if (is_file($flv))
                        {
                            if (! unlink($flv))
                            {
                                $err = 'File delete failed. Check file permission :' . $flv;
                                return $err;
                            }
                        }
                    }
                }
            
            }
            
            if ($video_info['video_thumb_server_id'] > 0)
            {
                unset($ftp_config);
                unset($ftp);
                $ftp_config['video_id'] = $video_id;
                $ftp_config['debug'] = $config['debug'];
                $ftp_config['log_file_name'] = $log_file_name;
                $ftp = new Ftp();
                $ftp->delete_thumb($ftp_config);
                $ftp->close();
            }
            
            require_once VSHARE_DIR . '/include/class.tags.php';
            $tags = new Tags($current_keyword, $video_id, '', '');
            $tags->delete($delete);
            unset($tags);
            
            if ($delete == 1)
            {
                $sql = "DELETE FROM `comments` WHERE
                       `comment_video_id`=$video_id";
                mysql_query($sql) or mysql_die($sql);
                $sql = "DELETE FROM `process_queue` WHERE
                       `vid`=$video_id";
                mysql_query($sql) or mysql_die($sql);
                $sql = "DELETE FROM `videos` WHERE
                       `video_id`=$video_id";
                mysql_query($sql) or mysql_die($sql);
            }
            else
            {
                $sql = "UPDATE `videos` SET
                       `video_user_id`='0',
                       `video_active`='0' WHERE
                       `video_id`='" . (int) $video_id . "'";
                mysql_query($sql) or mysql_die($sql);
            }
            
            $sql = "UPDATE `groups` SET
                   `group_image_video`='0' WHERE
                   `group_image_video`=$video_id";
            mysql_query($sql) or mysql_die($sql);
            $sql = "DELETE FROM `group_videos` WHERE
                   `group_video_video_id`=$video_id";
            mysql_query($sql) or mysql_die($sql);
            $sql = "DELETE FROM `favourite` WHERE
                   `favourite_video_id`=$video_id";
            mysql_query($sql) or mysql_die($sql);
            $sql = "DELETE FROM `inappropriate_requests` WHERE
                   `inappropriate_request_video_id`=$video_id";
            mysql_query($sql) or mysql_die($sql);
            $sql = "DELETE FROM `feature_requests` WHERE
                   `feature_request_video_id`=$video_id";
            mysql_query($sql) or mysql_die($sql);
            $sql = "UPDATE `subscriber` SET
                   `total_video`=total_video-1,
                   `used_space`=used_space-$video_space WHERE
                   `UID`=$video_uid";
            mysql_query($sql) or mysql_die($sql);
            $sql = "DELETE FROM `playlists` WHERE
                   `playlist_video_id`=$video_id";
            mysql_query($sql) or mysql_die($sql);
            $sql = "UPDATE `group_topics` SET
                   `group_topic_video_id`='0' WHERE
                   `group_topic_video_id`='" . (int) $video_id . "'";
            mysql_query($sql) or mysql_die($sql);
            $sql = "UPDATE `group_topic_posts` SET
                   `group_topic_post_video_id`='0' WHERE
                   `group_topic_post_video_id`='" . (int) $video_id . "'";
            mysql_query($sql) or mysql_die($sql);
            
            if ($delete == 1)
            {
                $ff = VSHARE_DIR . '/thumb/' . $video_id . '.jpg';
                $ff1 = VSHARE_DIR . '/thumb/1_' . $video_id . '.jpg';
                $ff2 = VSHARE_DIR . '/thumb/2_' . $video_id . '.jpg';
                $ff3 = VSHARE_DIR . '/thumb/3_' . $video_id . '.jpg';
                
                if (file_exists($ff)) @unlink($ff);
                if (file_exists($ff1)) @unlink($ff1);
                if (file_exists($ff2)) @unlink($ff2);
                if (file_exists($ff3)) @unlink($ff3);
                
                if ($vtype == 0)
                {
                    $ff4 = VSHARE_DIR . '/video/' . $vdoname;
                    if (strlen($vdoname) > 3)
                    {
                        if (file_exists($ff4)) @unlink($ff4);
                    }
                }
            }
            
            return 1;
        }
        else
        {
            return 0;
        }
    }
}