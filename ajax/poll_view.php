<?php

require '../include/config.php';
require '../include/functions_ajax.php';

$id = $_GET['pollid'];

if (! is_numeric($id))
{
    return_json('Hacking attempt.', 'error');
    exit(0);
}

$poll_info = Poll::display($id);

$smarty->assign('poll_info', $poll_info);
$fetch_view_vote = $smarty->fetch('view_vote.tpl');
return_json($fetch_view_vote, 'success');
DB::close();
