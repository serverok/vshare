<h1>Video Search</h1>

<form action="" method="get">
    <div>
        <label>Video ID:</label>
        <input type="text" name="id" size="25" />
    </div>

    <div>
        <label>Video FLV Name:</label>
        <input type="text" name="video_flv_name" size="25" />
    </div>

    <div>
        <label>Video Name:</label>
        <input type="text" name="video_name" size="25" />
    </div>

    <div>
        <label>Video Title:</label>
        <input type="text" name="video_title" size="25" />
    </div>

    <div>
        <label>Video Description:</label>
        <input type="text" name="video_description" size="25" />
    </div>

    <div class="submit">
        <input type="submit" name="search" value="Search" />
    </div>
</form>

{if $video_info ne ""}

    <h1>Search Results for: {$search_string}</h1>

    <p>Total: {$total}</p>

    <table cellspacing="1" cellpadding="3"  width="100%" border="0">
    
        <tr class="tabletitle">
            <td>
                <b>ID</b>
                <a href="?search=Search&{$search_query}&sort=video_id+asc">
                    <img src="{$img_css_url}/images/up.gif" border="0" alt="" />
                </a>
                <a href="?search=Search&{$search_query}&sort=video_id+desc">
                    <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
                </a>
            </td>
            <td>
                <b>Title</b>
                <a href="?search=Search&{$search_query}&sort=video_title+asc">
                    <img src="{$img_css_url}/images/up.gif" border="0" alt="" />
                </a>
                <a href="?search=Search&{$search_query}&sort=video_title+desc">
                    <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
                </a>
            </td>
            <td>
                <b>Type</b>
                <a href="?search=Search&{$search_query}&sort=video_type+asc">
                    <img src="{$img_css_url}/images/up.gif" border="0" alt="" />
                </a>
                <a href="?search=Search&{$search_query}&sort=video_type+desc">
                    <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
                </a>
            </td>
            <td>
                <b>Duration</b>
                <a href="?search=Search&{$search_query}&sort=video_duration+asc">
                    <img src="{$img_css_url}/images/up.gif" border="0" alt="" />
                </a>
                <a href="?search=Search&{$search_query}&sort=video_duration+desc">
                    <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
                </a>
            </td>
            <td>
                <b>Featured</b>
                <a href="?search=Search&{$search_query}&sort=video_featured+asc">
                    <img src="{$img_css_url}/images/up.gif" border="0" alt="" />
                </a>
                <a href="?search=Search&{$search_query}&sort=video_featured+desc">
                    <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
                </a>
            </td>
            <td>
                <b>Date</b>
                <a href="?search=Search&{$search_query}&sort=video_add_date+asc">
                    <img src="{$img_css_url}/images/up.gif" border="0" alt="" />
                </a>
                <a href="?search=Search&{$search_query}&sort=video_add_date+desc">
                    <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
                </a>
            </td>
            <td align="center">
                <b>Action</b>
            </td>
        </tr>

        {section name=aa loop=$video_info}
        
            <tr class="{cycle values="tablerow1,tablerow2"}">
                <td>
                    {$video_info[aa].video_id}
                </td>
                <td>
                    <a href="video_details.php?a={$a}&id={$video_info[aa].video_id}&page={$page}">{$video_info[aa].video_title}</a>
                </td>
                <td align="center">
                    {$video_info[aa].video_type}
                </td>
                <td align="center">
                    {$video_info[aa].video_length}
                </td>
                <td align="center">
                    {$video_info[aa].video_featured}
                </td>
                <td align="center">
                    {$video_info[aa].video_add_date|date_format}
                </td>
                <td align="center">
                    <a href="video_edit.php?action=edit&video_id={$video_info[aa].video_id}&sort={$smarty.request.sort}">
                     <img src="{$img_css_url}/images/edit.gif" title="Edit" alt="Edit" />
                    </a>
                </td>
            </tr>

        {/section}

    </table>

{/if}