<?php

class Http
{
    public static function redirect($url)
    {
        if (! headers_sent()) {
            header("Location: $url");
        } else {
            echo "<script language=Javascript>document.location.href='$url';</script>";
        }
        exit(0);
    }
}
