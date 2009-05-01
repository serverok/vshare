<script language="JavaScript" src="{$base_url}/js/admin_poll.js" type="text/javascript"></script>

<h1>Add New Poll</h1>

<form method="post" action="poll_add.php" onsubmit="return validate_poll_form();">

    <div>
        <label>Starting date:</label>
        <select name="start_date_day">
            {$days}
            <option value="{$smarty.post.start_date_day}">{$smarty.post.start_date_day}</option>
        </select>
        <select name="start_date_month">
            {$month}
            <option value="{$smarty.post.start_date_month}">{$smarty.post.start_date_month}</option>
        </select>
        <select name="start_date_year">
            {$year}
            <option value="{$smarty.post.start_date_year}">{$smarty.post.start_date_year}</option>
        </select>
    </div>

    <div>
        <label>End date:</label>
        <select name="end_date_day">
            {$days}
            <option value="{$smarty.post.end_date_day}">{$smarty.post.end_date_day}</option>
        </select>
        <select name="end_date_month">
            {$month}
            <option value="{$smarty.post.end_date_month}">{$smarty.post.end_date_month}</option>
        </select>
        <select name="end_date_year">
            {$year}
            <option value="{$smarty.post.end_date_year}">{$smarty.post.end_date_year}</option>
        </select>
    </div>

    <div>
        <label>Question:</label>
        <textarea name="poll_question" id="poll_question" rows="2" cols="50" onblur="poll_answer_validate('poll_question','#EAEAEA','#FFB3B3')">{$smarty.post.poll_question}</textarea>
    </div>

    <div>
        <label>Number of Answers:</label>
        <input type="text" size="3" name="num_answers" id="num_answers" onblur="show_poll_answer_box()" onfocus="delete_poll_answer_box()" value="{$smarty.post.num_answers}" />
    </div>

    <div style="margin-left:140px; background-color:#8cceea; width:400px">
        <table id="poll_table_container"></table>
    </div>

    <div class="submit">
        <input type="submit" name="submit" value="Create Poll" />
    </div>

</form>