{include file="admin/settings_menu.tpl"}

<h1>Player Settings</h1>

<form method="post" action="">

    <div>
        <label for="player_autostart">Auto Play Video:</label>
        <select name="player_autostart" id="player_autostart">
            <option value="1" {if $player_autostart =='1'}selected="selected"{/if}>Yes</option>
            <option value="0" {if $player_autostart =='0'}selected="selected"{/if}>No</option>
        </select>
    </div>

    <div>
        <label for="player_bufferlength">Video buffer time in seconds:</label>
        <input type="text" name="player_bufferlength" id="player_bufferlength" value="{$player_bufferlength}" size="5" />
    </div>

    <div>
        <label for="player_width">Player Width:</label>
        <input type="text" name="player_width" id="player_width" value="{$player_width}" size="5" />
    </div>

    <div>
        <label for="player_height">Player Height:</label>
        <input type="text" name="player_height" id="player_height" value="{$player_height}" size="5" />
    </div>

    <div class="submit">
        <input type="submit" name="submit" value="Update" />
    </div>

</form>