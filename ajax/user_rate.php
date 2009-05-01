<?php

require '../include/config.php';
require '../include/functions_ajax.php';
require '../include/language/' . LANG . '/lang_user_rate.php';

$voter = isset($_POST['voter']) ? $_POST['voter'] : "";
$candidate = isset($_POST['candidate']) ? $_POST['candidate'] : "";
$rate = isset($_POST['rate']) ? $_POST['rate'] : "";

if (! is_numeric($voter) || ! is_numeric($candidate) || ! is_numeric($rate))
{
    if ($config['debug']) error_log("Hacking attempt \n", 3, VSHARE_DIR . '/templates_c/log_ajax_user_rate.txt');
    return_json('Hacking attempt', 'error');
    exit(0);
}

$sql = "SELECT count(*) AS `total` FROM `uservote` WHERE 
       `candate_id`=" . (int) $candidate . " AND 
       `voter_id`=" . (int) $voter;
$result = mysql_query($sql) or mysql_die($sql);
$user_vote = mysql_fetch_assoc($result);

if ($user_vote['total'] == 0)
{
    $sql = "INSERT INTO `uservote` SET 
           `candate_id`='" . (int) $candidate . "',
           `voter_id`='" . (int) $voter . "',
           `vote`='" . (int) $rate . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    
    if ($config['debug']) error_log("$lang[rated] \n", 3, VSHARE_DIR . '/templates_c/log_ajax_user_rate.txt');
    return_json($lang['rated'], 'success');
}
else
{
    if ($config['debug']) error_log("$lang[already_rated] \n", 3, VSHARE_DIR . '/templates_c/log_ajax_user_rate.txt');
    return_json($lang['already_rated'], 'success');

}
