<?php

class Poll
{
    public $poll_id;

    public function poll_display($poll_id)
    {
        $sql = "SELECT * FROM `poll_question` WHERE
               `poll_id`='" . (int) $poll_id . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        $tmp = mysql_fetch_assoc($result);
        $poll_answer = $tmp['poll_answer'];
        $poll_answers = explode('|', $poll_answer);
        
        for ($i = 0; $i < count($poll_answers); $i ++)
        {
            $sql = "SELECT count(*) AS `total_poll_vote` FROM `poll_results` WHERE
			       `poll_result_vote_id`='" . (int) $poll_id . "' AND
			       `poll_result_answer`='" . mysql_clean($poll_answers[$i]) . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            $tmp_1 = mysql_fetch_assoc($result);
            $total_poll_votes[] = $tmp_1['total_poll_vote'];
        }
        
        $poll_votes_percentage = $this->poll_votes_percentage($total_poll_votes);
        
        for ($i = 0; $i < count($poll_answers); $i ++)
        {
            $poll_info[$i]['answer'] = $poll_answers[$i];
            $poll_info[$i]['percentage'] = $poll_votes_percentage[$i];
        }
        
        return $poll_info;
    }

    public function poll_votes_percentage($total_poll_votes)
    {
        $total = 0;
        
        for ($i = 0; $i < count($total_poll_votes); $i ++)
        {
            $total = $total + $total_poll_votes[$i];
        }
        
        for ($i = 0; $i < count($total_poll_votes); $i ++)
        {
            if ($total == 0)
            {
                $poll_votes_percentage[$i] = 0;
            }
            else
            {
                $poll_votes_percentage[$i] = round(($total_poll_votes[$i] * 100) / $total, 2);
            }
        
        }
        return $poll_votes_percentage;
    }

    public function poll_delete()
    {
        $sql = "DELETE FROM `poll_question` WHERE
		       `poll_id`='" . (int) $this->poll_id . "'";
        mysql_query($sql) or mysql_die($sql);
        $sql = "DELETE FROM `poll_results` WHERE
		       `poll_result_vote_id`='" . (int) $this->poll_id . "'";
        mysql_query($sql) or mysql_die($sql);
    }
}
