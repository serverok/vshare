<?php

class DB
{
    public static $link;
    public static $result;

    public static function connect($db_host, $db_user, $db_pass, $db_name)
    {
        self::$link = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if (self::$link->connect_errno) {
            die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
        }
    }

    public static function query($sql)
    {
        self::$result = self::$link->query($sql) or self::sqlDie($sql);
        return self::$result;
    }

    public static function fetch($sql)
    {
        $result = self::query($sql);

        $return_array = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $return_array[] = $row;
        }

        return $return_array;
    }

    public static function fetch1($sql)
    {
        $result = self::query($sql);

        if ($result) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }

    }

    public static function getTotal($sql)
    {
        $result = self::query($sql);
        $temp = mysqli_fetch_assoc($result);
        return $temp['total'];
    }

    public static function close()
    {
        mysqli_close(self::$link);
    }

    public static function quote($value)
    {
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }

        if (! is_numeric($value)) {
            $value = mysqli_real_escape_string(self::$link, $value);
        }

        return $value;
    }

    public static function insertGetId($sql)
    {
        $result = self::query($sql);
        return mysqli_insert_id(self::$link);
    }

    public static function sqlDie($msg)
    {
        echo "<FONT face=verdana SIZE=2 COLOR=#FF0000><B>ERROR: Unable to execute query</B></FONT><BR>";
        echo "<pre>$msg</pre>";
        echo "<FONT face=arial SIZE=2 COLOR=#0000FF><B>";
        echo mysqli_error(self::$link);
        echo "</B></FONT><BR>";
        exit(0);
    }

    public static function freeResult()
    {
        mysqli_free_result(self::$result);
    }
}
