<?php

class Http
{
    public static function redirect($url)
    {
        if (! headers_sent()) {
            header("Location: $link");
        } else {
            echo "<script language=Javascript>document.location.href='$link';</script>";
        }
        exit(0);
    }
}
