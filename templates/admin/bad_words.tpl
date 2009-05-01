<h1>Bad Words</h1>

<table cellspacing="1" cellpadding="3" width="100%">

	<tr class="tabletitle">
		<td>
			<b>ID</b>
		</td>
		<td>
			<b>BAD WORDS</b>
		</td>
		<td align="center">
			<b>ACTION</b>
		</td>
	</tr>

	{section name=i loop=$badwords}
	<tr class="{cycle values="tablerow1,tablerow2"}">
		<td>
			{$badwords[i].word_id}
		</td>
		<td>
			{$badwords[i].word}
		</td>
		<td align="center">
			<a href="bad_words.php?action=del&id={$badwords[i].word_id}" onClick='Javascript:return confirm("Are you sure you want to delete?");'>
                <img src="{$img_css_url}/images/del.gif" border="0" title="Delete" alt="Delete" />
            </a>
		</td>
	</tr>
	{/section}

</table>

<hr />

<form method="post" action="">

    <input type="hidden" name="action" value="add" />

    <div>
        <label for="word">Add a Bad Word:</label>
        <input type="text" size="30" name="word" id="word" />
    </div>

    <div class="submit">
        <input type="submit" name="submit" id="submit" value="Submit" />
    </div>
    
</form>