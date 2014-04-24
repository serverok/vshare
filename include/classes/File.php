<?php

class File
{
    public static function get_extension($file)
    {
        $file_name = basename($file);
        $pos = strrpos($file_name, '.');
        return strtolower(substr($file_name, $pos + 1, strlen($file_name) - $pos));
    }
}
