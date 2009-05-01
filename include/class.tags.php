<?php

class Tags
{
    var $tags;
    var $vid;
    var $uid;
    var $channels;
    var $now;

    function Tags($keywords, $vid, $uid, $chid)
    {
        $this->vid = $vid;
        $this->uid = $uid;
        $keywords = $this->clean_tags($keywords);
        $keywords = ereg_replace("[,]+", " ", $keywords);
        $keywords = ereg_replace("[ ]+", " ", $keywords);
        $keywords = trim($keywords);
        $kw_arr = explode(' ', $keywords);
        $keywords_unique = array_unique($kw_arr);
        $new_kw_arr = array();
        
        foreach ($keywords_unique as $kw)
        {
            if (mb_strlen($kw, 'UTF-8') > 1 && mb_strlen($kw, 'UTF-8') < 20)
            {
                $kw = mysql_clean(trim($kw));
                $kw = str_replace(' ', '-', $kw);
                $new_kw_arr[] = $kw;
            }
        }
        
        $this->tags = $new_kw_arr;
        $this->channels = $chid;
        $this->now = time();
    }

    function delete($adjust_tag_count = 1)
    {
        $sql = "DELETE FROM `tag_video` WHERE
               `vid`='" . (int) $this->vid . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if ($adjust_tag_count == 1)
        {
            for ($i = 0; $i < count($this->tags); $i ++)
            {
                $sql = "SELECT * FROM `tags` WHERE
                       `tag`='" . $this->tags[$i] . "'";
                $result = mysql_query($sql);
                $tag_info = mysql_fetch_assoc($result);
                
                if ($tag_info['tag_count'] > 0)
                {
                    $sql = "UPDATE tags SET `tag_count`=`tag_count`-1 WHERE
                           `tag`='" . $this->tags[$i] . "'";
                    $result = mysql_query($sql) or mysql_die($sql);
                }
            }
        }
    }

    function add()
    {
        
        foreach ($this->tags as $tag)
        {
            
            $sql = "SELECT * FROM `tags` WHERE
                   `tag`='" . mysql_clean($tag) . "'";
            $result = mysql_query($sql);
            
            if (mysql_num_rows($result) > 0)
            {
                $tag_info = mysql_fetch_assoc($result);
                $sql = "UPDATE `tags` SET
                       `tag_count`=`tag_count`+1,
                       `used_on`=$this->now WHERE
                       `tag`='$tag'";
                $tmp = mysql_query($sql) or mysql_die($sql);
                $sql = "INSERT INTO `tag_video` SET
                       `tag_id`=$tag_info[id],
                       `vid`=$this->vid,
                       `chid`='$this->channels'";
                $tmp = mysql_query($sql) or mysql_die($sql);
            }
            else
            {
                $sql = "INSERT INTO `tags` SET
                       `tag`='$tag',
                       `tag_count`=1,
                       `used_on`=$this->now";
                $tmp = mysql_query($sql) or mysql_die($sql);
                $tags_id = mysql_insert_id();
                $sql = "INSERT INTO `tag_video` SET
                       `tag_id`=$tags_id,
                       `vid`=$this->vid,
                       `chid`='$this->channels'";
                $tmp = mysql_query($sql) or mysql_die($sql);
            }
        }
    }

    function settime($time)
    {
        $this->now = $time;
    }

    function clean_tags($tags)
    {
        $bad = array(
            "_",
//            "-",
            "^",
            ")",
            "(",
            "%",
            "!",
            "@",
            "*",
            "../",
            "./",
            "<!--",
            "-->",
            "<",
            ">",
            '"',
            '&',
            '$',
            '#',
            '{',
            '}',
            '[',
            ']',
            '=',
            ';',
            '?',
            "%20",
            "%22",
            "%3c", // <
            "%253c", // <
            "%3e", // >
            "%0e", // >
            "%28", // (
            "%29", // )
            "%2528", // (
            "%26", // &
            "%24", // $
            "%3f", // ?
            "%3b", // ;
            "%3d" // =
        );
        
        return stripslashes(str_replace($bad, '', $tags));
    }

    function common_word($tag)
    {
        $common_words = array(
            'i',
            'me',
            'my',
            'myself',
            'we',
            'our',
            'ours',
            'ourselves',
            'you',
            'your',
            'yours',
            'yourself',
            'yourselves',
            'he',
            'him',
            'his',
            'himself',
            'she',
            'her',
            'hers',
            'herself',
            'it',
            'its',
            'itself',
            'they',
            'them',
            'their',
            'theirs',
            'themselves',
            'what',
            'which',
            'who',
            'whom',
            'this',
            'that',
            'these',
            'those',
            'am',
            'is',
            'are',
            'was',
            'were',
            'be',
            'been',
            'being',
            'have',
            'has',
            'had',
            'having',
            'do',
            'does',
            'did',
            'doing',
            'a',
            'an',
            'the',
            'and',
            'but',
            'if',
            'or',
            'because',
            'as',
            'until',
            'while',
            'of',
            'at',
            'by',
            'for',
            'with',
            'about',
            'against',
            'between',
            'into',
            'through',
            'during',
            'before',
            'after',
            'above',
            'below',
            'to',
            'from',
            'up',
            'down',
            'in',
            'out',
            'on',
            'off',
            'over',
            'under',
            'again',
            'further',
            'then',
            'once',
            'here',
            'there',
            'when',
            'where',
            'why',
            'how',
            'all',
            'any',
            'both',
            'each',
            'few',
            'more',
            'most',
            'other',
            'some',
            'such',
            'no',
            'nor',
            'not',
            'only',
            'own',
            'same',
            'so',
            'than',
            'too',
            'very'
        );
        foreach ($common_words as $common_word)
        {
            if (preg_match("/\b$common_word\b/i", $tag))
            {
                $tag = preg_replace("/\b$common_word\b/i", '', $tag);
            }
        }
        return $tag;
    }

    function get_tags()
    {
        return $this->tags;
    }
}