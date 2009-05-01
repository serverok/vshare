<?php

class channels
{

    static function get_all()
    {
        global $db;
        $sql = "SELECT * FROM `channels`
                ORDER BY `channel_sort_order` ASC";
        $result = mysql_query($sql);
        if (mysql_num_rows($result) > 0)
        {
            $channels = array();
            while ($row = mysql_fetch_assoc($result))
            {
                $row['channel_name_html'] = htmlspecialchars($row['channel_name'], ENT_QUOTES, 'UTF-8');
                $row['channel_description'] = htmlspecialchars($row['channel_description'], ENT_QUOTES, 'UTF-8');
                $channels[] = $row;
            }
        }
        else
        {
            $channels = 0;
        }
        return $channels;
    }
}