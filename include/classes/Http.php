<?php

class Http
{
    public static function redirect($url)
    {
        header("Location: $url");
        exit;
    }
}
