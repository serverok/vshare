<?php

class Config
{
    public static function isSet($config_name)
    {
        $sql = "SELECT * FROM `config` WHERE
               `config_name`='" . DB::quote($config_name) . "'";
        $result = DB::fetch1($sql);
        if ($result) {
            return 1;
        } else {
            return 0;
        }
    }
}
