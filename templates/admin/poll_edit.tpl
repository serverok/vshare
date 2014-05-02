<script src="{$base_url}/js/admin_poll.js"></script>

<h1>Edit Poll</h1>

<form method="post" action="poll_edit.php" onSubmit="return validate_poll_edit_form();">

    <input type="hidden" name="poll_id" value="{$poll_id}" />

    <div>
        <label>Starting date :</label>

        <select name="start_date_day">
			{$days_start}
			<option value="{$smarty.post.start_date_day}">{$smarty.post.start_date_day}</option>
		</select>
		<select name="start_date_month">
			{$month_start}
			<option value="{$smarty.post.start_date_month}">{$smarty.post.start_date_month}</option>
		</select>
		<select name="start_date_year">
			{$year_start}
			<option value="{$smarty.post.start_date_year}">{$smarty.post.start_date_year}</option>
        </select>
    </div>

    <div>
        <label>End date :</label>
        <select name="end_date_day">
            {$days_end}
            <option value="{$smarty.post.end_date_day}">{$smarty.post.end_date_day}</option>
        </select>
        <select name="end_date_month">
            {$month_end}
            <option value="{$smarty.post.end_date_month}">{$smarty.post.end_date_month}</option>
        </select>
        <select name="end_date_year">
            {$year_end}
            <option value="{$smarty.post.end_date_year}">{$smarty.post.end_date_year}</option>
        </select>
    </div>

    <div>
        <label>Question :</label>
        <textarea name="poll_question" id="poll_question" rows="2" cols="50">{$poll_qty}</textarea>
    </div>

    <div>
        <label>Answers :</label>
        {assign var='j' value=0}
        {assign var='k' value=0}
        Add <input type="text" id='ans' value="1" style="width:30px;" maxlength="3" /> answer(s)
        <input type="radio" name="edit_poll" id="poll_end" value="end" />At End
        <input type="radio" name="edit_poll" id="poll_begining" value="beginning" />At Beginning
        <input type="radio" checked="checked" name="edit_poll" id="poll_after" value="after" />After
    </div>

    <div class="indent">
        <select style="width: 90px;font-size: 12px;" id="poll_select">
            {section name=i loop=$list}
				<option value={$j++}>{$list[i]}</option>
            {/section}
        </select>

        <input type="button" value="Go" onclick="add_poll_ans();" />
    </div>

    <div class="indent">

        <div id="begining_text"></div>

        {section name=i loop=$list}
            <input type="text" name="edit_poll_answers[]" size="20" id="txtPollAnsQty" value="{$list[i]}" />
            <div id="{$k++}"></div>
        {/section}

        <div id="ending_text"></div>

        <p>If you change poll answer, current vote for the answer will be lost.</p>

    </div>

    <div class="submit">
        <input type="submit" name="submit" value="Update" class="btn btn-primary" />
    </div>

</form>