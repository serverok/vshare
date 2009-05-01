<?php

require '../include/config.php';
require '../include/functions_ajax.php';
require '../include/language/' . LANG . '/lang_user_rate.php';

$candidate_id = isset($_POST['candidate']) ? $_POST['candidate'] : 0;

if (! is_numeric($candidate_id))
{
    return_json('Hacking attempt', 'error');
    exit(0);
}

$sql = "SELECT count(*) AS `tot`,sum(vote) FROM `uservote` WHERE 
       `candate_id`=" . (int) $candidate_id . " 
        GROUP BY `candate_id`";
$result = mysql_query($sql) or mysql_die($sql);
$vote_info = mysql_fetch_assoc($result);
$list = '';
$rate = $vote_info['sum(vote)'];
$rating = $vote_info['tot'];

if ($rate != 0)
{
    $rate = $rate / $rating;
    $num_full_star = floor($rate);
    for ($i = 0; $i < $num_full_star; $i ++)
    {
        $list .= '<img src="' . VSHARE_URL . '/templates/images/star.gif" alt="" />&nbsp;';
    }
    
    if ($rate == $num_full_star)
    {
        $num_falf_star = 0;
    }
    else
    {
        $num_falf_star = 1;
        $list .= '<img src="' . VSHARE_URL . '/templates/images/half_star.gif" alt="" />';
    }
    
    $num_blank_star = 5 - $num_full_star - $num_falf_star;
    
    for ($i = 0; $i < $num_blank_star; $i ++)
    {
        $list .= '<img src="' . VSHARE_URL . '/templates/images/blank_star.gif" alt="" />';
    }

}
else
{
    $rate = 0;
}

if ($rate > 0)
{
    return_json($list, 'success');
}
else
{
    if ($config['debug']) error_log(__FILE__ . " $err \n", 3, VSHARE_DIR . '/templates_c/ajax_log.txt');
    return_json($lang['not_yet_rated'], 'error');
}