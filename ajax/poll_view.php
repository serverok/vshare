<?php

require '../include/config.php';
require '../include/class.poll.php';
require '../include/functions_ajax.php';

$id = $_GET['pollid'];

if (! is_numeric($id))
{
    return_json('Hacking attempt.', 'error');
    exit(0);
}

$poll = new Poll();
$poll_info = $poll->poll_display($id);

$smarty->assign('poll_info', $poll_info);
$fetch_view_vote = $smarty->fetch('view_vote.tpl');
return_json($fetch_view_vote, 'success');
db_close();
