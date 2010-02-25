<h1>Edit Package (id: {$package.package_id})</h1>

<form method="post" action="package_edit.php">

    <input type="hidden" name="package_id" value="{$package.package_id}">

    <div>
        <label for="package_name">Package Name:</label>
        <input name="package_name" id="package_name" value="{$package.package_name}" size="30" />
    </div>

    <div>
        <label for="package_description">Description:</label>
        <textarea name="package_description" id="package_description" rows="5" cols="30">{$package.package_description}</textarea>
    </div>

    <div>
        <label for="package_space">Space (MB):</label>
        <input name="package_space" id="package_space" value="{$package.package_space}" size="10" />
    </div>

    {if $package.package_trial ne "yes"}
        <div>
            <label for="package_price">Price (US $):</label>
            <input name="package_price" id="package_price" value="{$package.package_price}" size="8" />
        </div>
    {/if}

    <div>
        <label for="package_videos">Video Limit:</label>
        <input name="package_videos" id="package_videos" value="{$package.package_videos}" size="10" />
        (Leave blank or enter 0 for unlimited upload)
    </div>

    {if $package.package_trial ne "yes"}
        <div>
            <label for="package_period">Subscription Period</label>
            <select name="package_period" id="package_period">{$period_ops}</select>
        </div>
    {else}
        <div>
            <label for="package_trial_period">Trial Period (Day):</label>
            <input name="package_trial_period" id="package_trial_period" value="{$package.package_trial_period}" size="8" />
        </div>
    {/if}

    <div>
        <label for="allow_download">Allow Video Download:</label>
        <select name="allow_download" id="allow_download">{$download_ops}</select>
    </div>

    <div>
        <label for="package_status">Status:</label>
        <select name="package_status" id="package_status">{$status_ops}</select>
    </div>

    <div class="submit">
        <input type="submit" name="submit" value="Update" />
    </div>

</form>