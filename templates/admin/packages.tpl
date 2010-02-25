<h1>Packages {if $enable_package eq "no"}(Disabled){/if}</h1>

<table cellspacing="1" cellpadding="3" width="100%">

    <tr class="tabletitle">
        <td align="center">
            <b>ID</b>
        </td>
        <td align="center">
            <b>Name</b>
        </td>
        <td align="center">
            <b>Space</b>
        </td>
        <td align="center">
            <b>Price</b>
        </td>
        <td align="center">
            <b>Video Limit</b>
        </td>
        <td align="center">
            <b>Period</b>
        </td>
        <td align="center">
            <b>Allow Download</b>
        </td>
        <td align="center">
            <b>Status</b>
        </td>
        <td align="center">
            <b>Action</b>
        </td>
    </tr>

    {section name=aa loop=$packages}

        <tr {if $packages[aa].package_trial eq "yes"} bgcolor="#FFE0E0" {else} bgcolor="{cycle values="#F8F8F8,#F2F2F2"}" {/if}>
            <td align="center">
                {$packages[aa].package_id}
            </td>
            <td>
                <a href="package_view.php?package_id={$packages[aa].package_id}">
                    {$packages[aa].package_name}
                </a>
            </td>
            <td align="right">
                {insert name=format_size size=$packages[aa].package_space}
            </td>
            <td align="right">
                {if $packages[aa].is_trial eq "yes"}No{else}${$packages[aa].package_price}{/if}
            </td>
            <td align="center">
                {if $packages[aa].package_videos eq "0" or $packages[aa].package_videos eq ""}No{else}{$packages[aa].package_videos}{/if}
            </td>
            <td align="center">
                {if $packages[aa].package_trial eq "yes"}{$packages[aa].package_trial_period} days{else}{$packages[aa].package_period}{/if}
            </td>
            <td align="center">
                {if $packages[aa].package_allow_download eq '1'} Yes {else} No {/if}
            </td>
            <td align="center">
                {$packages[aa].package_status}
            </td>
            <td align="center">
                <a href="package_edit.php?package_id={$packages[aa].package_id}">
                    <img src="{$img_css_url}/images/edit.gif" title="Edit" alt="Edit" />
                </a>
            </td>
        </tr>
    {/section}

</table>