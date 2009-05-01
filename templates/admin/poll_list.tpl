<h1>View polls</h1>

{section name=i loop=$pollArray}

    <p>
        <b>Q: </b> 
        {$pollArray[i].poll_qty} 
        ( <a href="poll_edit.php?poll_id={$pollArray[i].poll_id}">
            <img src="{$img_css_url}/images/edit.gif" title="Edit" alt="Edit" />
        </a> <a href="poll_list.php?action=delete&poll_id={$pollArray[i].poll_id}" onclick="return confirm('Click OK to delete poll')">
            <img src="{$img_css_url}/images/del.gif" title="Delete" alt="Delete" />
        </a>)
    </p>
    
    <table border="1" width="300">
        {section name=j loop=$poll_info[i]}
        <tr>
            <td>{$poll_info[i][j].answer}</td>
            <td>{$poll_info[i][j].percentage}%</td>
        </tr>
        {/section}
    </table>

    <p><i>Start Date:{$pollArray[i].start_date} End Date:{$pollArray[i].end_date }</i></p>

    <hr size="1" />

{/section}
