<?php

/* remove globals */

if (ini_get('register_globals'))
{
    if (isset($_REQUEST['GLOBALS']))
    {
        // Prevent GLOBALS override attacks
        exit('Global variable overload attack.');
    }

    // Destroy the REQUEST global
    $_REQUEST = array();

    // These globals are standard and should not be removed
    $preserve = array(
        'GLOBALS', '_REQUEST', '_GET', '_POST', '_FILES', '_COOKIE', '_SERVER', '_ENV', '_SESSION'
    );

    // This loop has the same effect as disabling register_globals
    foreach ($GLOBALS as $key => $val)
    {
        if (! in_array($key, $preserve))
        {
            global $$key;
            $$key = NULL;

            // Unset the global variable
            unset($GLOBALS[$key], $$key);
        }
    }
}
