<?php

class Channel
{

    static function get()
    {
        $sql = "SELECT * FROM `channels`
                ORDER BY `channel_sort_order` ASC";
        $channels = DB::fetch($sql);

        if (! $channels) {
            return false;
        }

        $channels_all = [];

        foreach ($channels as $channel) {
                $channel['channel_name_html'] = htmlspecialchars($channel['channel_name'], ENT_QUOTES, 'UTF-8');
                $channel['channel_description'] = htmlspecialchars($channel['channel_description'], ENT_QUOTES, 'UTF-8');
                $channels_all[] = $channel;
        }

        return $channels_all;
    }

    public static function getById($id)
    {
        $sql = "SELECT * FROM `channels` WHERE
               `channel_id`='" . (int) $_GET['id'] . "'";
        return DB::fetch1($sql);
    }
}