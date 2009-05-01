<?php

require '../include/config.php';
require '../include/class.poll.php';
require '../include/functions_ajax.php';
require '../include/language/' . LANG . '/lang_vote_add.php';

$answer = $_POST['value'];
$id = $_POST['poll_id'];

if (! is_numeric($id))
{
    $err = $lang['id_invalid'];
}
else if (! isset($_SESSION['UID']))
{
    $err = $lang['guest'];
}

if (! empty($err))
{
    return_json($err, 'error');
    exit(0);
}

$today = date('Y-m-d');
$user_ip = User::get_ip();

if ($config['user_poll'] == "Once")
{
    $sql = "SELECT COUNT(*) AS `total` FROM `poll_results` WHERE 
           `poll_result_vote_id`='" . (int) $id . "' AND 
           `poll_result_voter_id`='" . (int) $_SESSION['UID'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $tmp = mysql_fetch_assoc($result);
    if ($tmp['total'] > 0)
    {
        return_json($lang['already_voted'], 'error');
        exit();
    }
}

$sql = "INSERT INTO `poll_results` SET 
       `poll_result_vote_id`='" . (int) $id . "',
       `poll_result_voter_id`='" . (int) $_SESSION['UID'] . "',
       `poll_result_answer`='" . mysql_clean($answer) . "',
       `poll_result_client_ip`='" . mysql_clean($user_ip) . "',
       `poll_result_date`='" . mysql_clean($today) . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_affected_rows() > 0)
{
    $poll = new Poll();
    $poll_info = $poll->poll_display($id);
    
    $smarty->assign('poll_info', $poll_info);
    $fetch_view_vote = $smarty->fetch('view_vote.tpl');
    return_json($fetch_view_vote, 'success');
}

db_close();
