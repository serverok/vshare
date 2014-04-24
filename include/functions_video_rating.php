<?php

require VSHARE_DIR . '/include/language/' . LANG . '/lang_video_rating.php';

function insert_video_rating($video)
{
    global $config , $lang;
    $video_id = $video['id'];
    $units = 5;
    $sql = "SELECT `video_rated_by`, `video_rate`, `video_voter_id`, `video_allow_rated` FROM `videos` WHERE
           `video_id`='" . (int) $video_id . "'";
    $video_info = DB::fetch1($sql);

    if ($video_info['video_rated_by'] < 1) {
        $count = 0;
    } else {
        $count = $video_info['video_rated_by'];
    }

    $current_rating = $video_info['video_rate'];

    $tense = ($count <= 1) ? $lang['vote'] : $lang['votes'];

    if ($config['video_rating'] == 'Once') {
        $voters_id = $video_info['video_voter_id'];
        $voter_list = explode('|', $voters_id);

        if (in_array($_SESSION['UID'], $voter_list)) {
            $is_voted = 1;
        } else {
            $is_voted = 0;
        }
    } else {
        $is_voted = 0;
    }

    $rating_unitwidth = 20;

    $rating_width = @number_format($current_rating / $count, 2) * $rating_unitwidth;
    $rating1 = @number_format($current_rating / $count, 1);
    $rating2 = @number_format($current_rating / $count, 2);

    $rater = '<div>';
    $rater .= '<div>';
    $rater .= '<ul id="unit_ul' . $video_id . '" class="unit-rating" style="width:' . $rating_unitwidth * $units . 'px;">';
    $rater .= '<li class="current-rating" style="width:' . $rating_width . 'px;">Currently ' . $rating2 . '/' . $units . '</li>';

    for ($ncount = 1; $ncount <= $units; $ncount ++) {
        if ($is_voted == 0 && $video_info['video_allow_rated'] == 'yes') {
            $rater .= "<li><a href=\"javascript:video_rate($video_id,$ncount);\" title=\"$ncount out of $units\" class=\"r" . $ncount . "-unit rater\" rel=\"nofollow\">" . $ncount . "</a></li>";
        }
    }

    $ncount = 0;

    $rater .= '</ul><p';

    if ($is_voted == 1) {
        $rater .= ' class="voted"';
    }

    $rater .= '>' . $lang['rating'] . ' <strong> ' . $rating1 . '</strong>/' . $units . ' (' . $count . ' ' . $tense . ' ' . $lang['cast'] . ')';
    $rater .= '</p></div></div>';

    return $rater;
}
