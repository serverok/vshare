<div style="font-weight:bold;color:#006600;margin-bottom:0.5em">
    Current Poll Result
</div>

<table width="100%">
    {section name=i loop=$poll_info}
        <tr>
            <td>
                <p class="poll-result">{$poll_info[i].answer}</p>
            </td>
            <td>
                <p class="poll-result">{$poll_info[i].percentage}%</p>
            </td>
        </tr>
    {/section}
</table>