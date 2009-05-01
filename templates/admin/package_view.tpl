<h1>Packages {if $enable_package eq "no"}(Disabled){/if}</h1>

<table width="60%" cellpadding="3" cellspacing="3">

    <tr class="tablerow1">
        <td width="40%">
            <b>Package Name</b>
        </td>
        <td>
            <b>{$package.package_name}</b>
        </td>
    </tr>

    <tr class="tablerow1">
        <td width="40%">
            <b>Description</b>
        </td>
        <td>
            {$package.package_description}
        </td>
    </tr>

    <tr class="tablerow1">
        <td width="40%">
            <b>Space</b>
        </td>
        <td>
            {insert name=format_size size=$package.package_space}
        </td>
    </tr>

    <tr class="tablerow1">
        <td width="40%">
            <b>Price</b>
        </td>
        <td>
            ${$package.package_price}
        </td>
    </tr>

    <tr class="tablerow1">
        <td width="40%">
            <b>Video Limit</b> (Optional)
        </td>
        <td>
            {if $package.package_videos eq "0" or $package.package_videos eq ""}
                (None)
            {else}
                {$package.package_videos}
            {/if}
        </td>
    </tr>

    <tr class="tablerow1">
        <td width="40%">
            <b>Subscription Period</b>
        </td>
        <td>
            {if $package.package_trial eq "yes"}
                {$package.package_trial_period} days
            {else}
                {$package.package_period}
            {/if}
        </td>
    </tr>

    <tr class="tablerow1">
        <td width="40%">
            <b>Status</b>
        </td>
        <td>
            {$package.package_status}
        </td>
    </tr>

    <tr class="tabletitle">
        <td colspan="2" align="right">
            <a href="package_edit.php?package_id={$package.package_id}">
                Edit Package
            </a>
        </td>
    </tr>

</table>