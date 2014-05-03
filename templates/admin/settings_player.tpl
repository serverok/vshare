<div class="page-header">
    <h1>Player Settings</h1>
</div>

<form method="post" action="" class="form-horizontal" role="form">
    <fieldset>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="player_autostart">Auto Play Video:</label>
        <div class="col-sm-5">
            <select class="form-control" name="player_autostart" id="player_autostart">
                <option value="1" {if $player_autostart =='1'}selected="selected"{/if}>Yes</option>
                <option value="0" {if $player_autostart =='0'}selected="selected"{/if}>No</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="player_bufferlength">Video buffer time in seconds:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" name="player_bufferlength" id="player_bufferlength" value="{$player_bufferlength}" size="5" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="player_width">Player Width:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" name="player_width" id="player_width" value="{$player_width}" size="5" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="player_height">Player Height:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" name="player_height" id="player_height" value="{$player_height}" size="5" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="vshare_player">Video player:</label>
        <div class="col-sm-5">
            <select class="form-control" name="vshare_player" id="vshare_player">
                <option value="JW Player" {if $vshare_player == 'JW Player'}selected="selected"{/if}>JW Player</option>
                <option value="StrobeMediaPlayback" {if $vshare_player == 'StrobeMediaPlayback'}selected="selected"{/if}>StrobeMediaPlayback</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="youtube_player">Youtube video player:</label>
        <div class="col-sm-5">
            <select class="form-control" name="youtube_player" id="youtube_player">
                <option value="youtube" {if $youtube_player =='youtube'}selected="selected"{/if}>Youtube Player</option>
                <option value="vshare" {if $youtube_player =='vshare'}selected="selected"{/if}>vShare Player</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Update</button>
        </div>
    </div>

    </fieldset>

</form>