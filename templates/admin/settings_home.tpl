<h1>Home Page Settings</h1>

<form method="post" action="" id="settings-home">

    <div>
        <label for="user_poll">Vote a poll:</label>
        <select name="user_poll" id="user_poll">
            <option value="Once" {if $user_poll =='Once'}selected="selected"{/if}>Once</option>
            <option value="Unlimited" {if $user_poll =='Unlimited'}selected="selected"{/if}>Unlimited</option>
        </select>
    </div>

    <div>
        <label for="home_num_tags">Number of Tags on Home Page:</label>
        <input type="text" name="home_num_tags" id="home_num_tags" value="{$home_num_tags}" size="3" />
    </div>

	<div>
        <label for="num_last_users_online">Number of Last Online users:</label>
        <input type="text" name="num_last_users_online" id="num_last_users_online" value="{$num_last_users_online}" size="3" />
	</div>

    <div>
        <label for="num_new_videos">Number of New Videos:</label>
        <input type="text" name="num_new_videos" id="num_new_videos" value="{$num_new_videos}" size="3" />
    </div>

    <div>
        <label for="recently_viewed_video">Number of Recently Viewed Videos:</label>
        <input type="text" name="recently_viewed_video" id="recently_viewed_video" value="{$recently_viewed_video}" size="3" />
    </div>

    <div>
        <label for="show_stats">Show Stats:</label>
        <select name="show_stats" id="show_stats">
            <option value="1" {if $show_stats eq "1"}selected="selected"{/if}>Enable</option>
            <option value="0" {if $show_stats eq "0"}selected="selected"{/if}>Disable</option>
        </select>
    </div>

    <div class="submit">
        <input type="submit" name="submit" value="Update" class="btn btn-primary" />
    </div>

</form>