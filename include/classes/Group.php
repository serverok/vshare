<?php

class Group
{
    static function getGroupById($group_id)
    {
        $sql = "SELECT * FROM `groups` WHERE
               `group_id`='" . (int) $group_id . "'";
        $result = mysql_query($sql) or mysql_die();

        if (mysql_num_rows($result))
        {
            return mysql_fetch_assoc($result);
        }
        else
        {
            return 0;
        }

    }

}