<?php
/******************************************************************************
 *
 * COMPANY: BuyScripts.in
 * PROJECT: vShare Youtube Clone
 * VERSION: [VSHARE_VERSION]
 * LISENSE: http://buyscripts.in/vshare-license.html
 * WEBSITE: http://buyscripts.in/youtube_clone.html
 *
 * This program is a commercial software and any kind of using it must agree
 * to vShare license.
 *
 ******************************************************************************/

$version = '2.8.1';

if (file_exists('../include/config.php') && filesize('../include/config.php') > 0)
{
    $vshare_installed = 1;
    $html_title = 'VSHARE UPGRADE';
}
else
{
    $vshare_installed = 0;
    $html_title = 'VSHARE INSTALLATION';
}

require './tpl/header.php';

if ($vshare_installed == 1)
{
    require '../include/config.php';
    ?>
<span class="msg">vShare <?php
    echo $version;
    ?> Upgrade</span>

<div style="display: inline-block; width: 550px;">
<hr />
<span style="font-size: 12px;">
             vShare <?php
    echo $config['version'];
    ?> is already installed...
             <br />
<span class="re-install-msg">(If you want to re-install vshare delete
"include/config.php")</span> </span>
<p class="backup-warning">Before you continue with upgrade, you must
take backup of your database and files.</p>
<a href="./upgrade_start.php" class="button">Upgrade Now</a></div>


<?php
}
else
{
?>
<span class="msg">vShare <?php
    echo $version;
    ?> Installation</span>
<div style="display: inline-block; width: 550px;">
<hr />
<p>YouTube Clone Script allow you to run your own video sharing portal.
Visitors will be able to upload video to your web site, view existing
video, comment on video, share video with others.</p>
<a href="./install.php" class="button">install vshare</a></div>
<?php
}
?>

<div style="height: 200px;"></div>

<?php
require './tpl/footer.php';
