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
session_start();

$html_title = 'VSHARE INSTALLATION';

$error = '';

if (isset($_POST['connect_info']))
{

    $site_url = $_POST['site_url'];

    if (strlen($site_url) < 12) {
        $error .= '<li>Site url invalid.</li>';
    }

    $ffmpeg_path = $_POST['ffmpeg_path'];

    if (! file_exists($ffmpeg_path)) {
        $error .= '<li>ffmpeg not found : ' . $ffmpeg_path . '</li>';
    }

    $mplayer_path = $_POST['mplayer_path'];

    if (! file_exists($mplayer_path)) {
        $error .= '<li>mplayer not found : ' . $mplayer_path . '</li>';
    }

    $mencoder_path = $_POST['mencoder_path'];

    if (! file_exists($mencoder_path)) {
        $error .= '<li>mencoder not found : ' . $mencoder_path . '</li>';
    }

    $flvtool_path = $_POST['flvtool_path'];

    if (! file_exists($flvtool_path)) {
        $error .= '<li>flvtool2 not found : ' . $flvtool_path . '</li>';
    }

    $qtfaststart_path = $_POST['qtfaststart_path'];

    if (! file_exists($qtfaststart_path)) {
        $error .= '<li>Qt-faststart not found : ' . $qtfaststart_path . '</li>';
    }

    $db_server = $_POST['db_server'];
    $db_name = $_POST['db_name'];
    $db_user = $_POST['db_user'];
    $db_pass = $_POST['db_pass'];
    $folder = $_POST['folder'];

    if (! is_dir($folder)) {
        $error .= '<li>folder not found : ' . $folder . '</li>';
    }

    $link = @mysqli_connect($db_server, $db_user, $db_pass, $db_name);

    if (! $link) {
        $error .= '<li>Failed to connect to database server.</li>';
    } else {
        $_SESSION['VSHARE_INSTALL']['DB_NAME'] = $db_name;
        $_SESSION['VSHARE_INSTALL']['DB_USER'] = $db_user;
        $_SESSION['VSHARE_INSTALL']['DB_PASSWORD'] = $db_pass;
        $_SESSION['VSHARE_INSTALL']['DB_HOST'] = $db_server;
    }

    if ($error == '')
    {
        $fp = fopen('../include/config.php', 'w');
        fputs($fp, '<?php');

        $vshare_config = <<<EOT

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

session_start();

\$db_host     = '$db_server';
\$db_name     = '$db_name';
\$db_user     = '$db_user';
\$db_pass     = '$db_pass';

\$language = 'en';

\$config = array();
\$config['ffmpeg']          =  '$_POST[ffmpeg_path]';
\$config['mplayer']          =  '$_POST[mplayer_path]';
\$config['mencoder']          =  '$_POST[mencoder_path]';
\$config['flvtool']          =  '$_POST[flvtool_path]';
\$config['qt-faststart']   =  '$_POST[qtfaststart_path]';
\$config['basedir']        =  '$_POST[folder]';
\$config['baseurl']        =  '$_POST[site_url]';

include(\$config['basedir'] . '/include/vshare.php');


EOT;

        fputs($fp, $vshare_config);
        fclose($fp);

        require './tpl/header.php';

        ?>

<p class="config-created">Configuration file created
(include/config.php)</p>

<form method="post" action="install_create_tables.php"><input
	type="submit" class="button" name=submit value="Continue Installation">
<input type="hidden" name="db_host" value="<?php
        echo $db_server;
        ?>"> <input
	type="hidden" name="db_name" value="<?php
        echo $db_name;
        ?>"> <input
	type="hidden" name="db_user" value="<?php
        echo $db_user;
        ?>"> <input
	type="hidden" name="db_pass" value="<?php
        echo $db_pass;
        ?>"> <input
	type="hidden" name="action" value="create_tables"></form>

<?php

        require 'tpl/footer.php';
        exit(0);
    }
}
else
{

    $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $site_url = str_replace('/install/install_collect_info.php', '', $url);

    $ffmpeg_path = '';

    if (file_exists('/usr/bin/ffmpeg'))
    {
        $ffmpeg_path = '/usr/bin/ffmpeg';
    }
    else if (file_exists('/usr/local/bin/ffmpeg'))
    {
        $ffmpeg_path = '/usr/local/bin/ffmpeg';
    }

    $mplayer_path = '';

    if (file_exists('/usr/bin/mplayer'))
    {
        $mplayer_path = '/usr/bin/mplayer';
    }
    else if (file_exists('/usr/local/bin/mplayer'))
    {
        $mplayer_path = '/usr/local/bin/mplayer';
    }

    $mencoder_path = '';

    if (file_exists('/usr/bin/mencoder'))
    {
        $mencoder_path = '/usr/bin/mencoder';
    }
    else if (file_exists('/usr/local/bin/mencoder'))
    {
        $mencoder_path = '/usr/local/bin/mencoder';
    }

    $flvtool_path = '';

    if (file_exists('/usr/bin/flvtool2'))
    {
        $flvtool_path = '/usr/bin/flvtool2';
    }
    else if (file_exists('/usr/local/bin/flvtool2'))
    {
        $flvtool_path = '/usr/local/bin/flvtool2';
    }

    if (file_exists('/usr/bin/qt-faststart'))
    {
        $qtfaststart_path = '/usr/bin/qt-faststart';
    }
    else if (file_exists('/usr/local/bin/qt-faststart'))
    {
        $qtfaststart_path = '/usr/local/bin/qt-faststart';
    }

    $db_name = $db_user = $db_pass = '';
    $db_server = 'localhost';
}
require 'tpl/header.php';

if ($error != '')
{
    echo '<div class="error"><ul>' . $error . '</ul></div>';
}

?>

<h1>Database &amp; Website Settings</h1>

<P>vShare only run if your server support all <a
	href="http://buyscripts.in/requirements.html" target="_blank">requirements</A>.
If you don't know path to ffmpeg, mencoder, flvtool2, etc... installed
on your server, ask your server provider.</p>

<form name="myform2" method="POST" action="">

<table width="96%" border="0" cellspacing="2" cellpadding="2"
	align="center">

	<tr>
		<td width="30%">Site URL</td>
		<td width="70%"><input type="text" name="site_url" size="33"
			value="<?php
echo $site_url;
?>"> (i.e. <i>http://yoursite.com/vshare</i>)</td>
	</tr>

	<tr>
		<td width="30%">Site Path</td>
		<td width="70%"><input type="text" name="folder" size="33"
			value="<?php
echo $_POST['folder'];
?>"> (i.e. <i>/home/username/public_html</i>)</td>
	</tr>

	<tr>
		<td width="30%">FFMpeg binary</td>
		<td width="70%"><input type="text" name="ffmpeg_path" size="33"
			value="<?php
echo $ffmpeg_path;
?>"> (i.e. <i>/usr/bin/ffmpeg</i>)</td>
	</tr>

	<tr>
		<td width="30%">Mencoder binary</td>
		<td width="70%"><input type="text" name="mencoder_path" size="33"
			value="<?php
echo $mencoder_path;
?>"> (i.e. <i>/usr/bin/mencoder</i>)</td>
	</tr>

	<tr>
		<td width="30%">Mplayer binary</td>
		<td width="70%"><input type="text" name="mplayer_path" size="33"
			value="<?php
echo $mplayer_path;
?>"> (i.e. <i>/usr/bin/mplayer</i>)</td>
	</tr>

	<tr>
		<td width="30%">FLVTool binary</td>
		<td width="70%"><input type="text" name="flvtool_path" size="33"
			value="<?php
echo $flvtool_path;
?>"> (i.e. <i>/usr/bin/flvtool2</i>)</td>
	</tr>

    <tr>
        <td width="30%">Qt-faststart binary</td>
        <td width="70%"><input type="text" name="qtfaststart_path" size="33"
            value="<?php
echo $qtfaststart_path;
?>"> (i.e. <i>/usr/bin/qt-faststart</i>)</td>
    </tr>

	<tr>
		<td width="30%">MySQL database server</td>
		<td width="70%"><input type="text" name="db_server" size="33"
			value="<?php
echo $db_server;
?>"> usually <i>localhost</i></td>
	</tr>

	<tr>
		<td width="30%">Database name</td>
		<td width="70%"><input type="text" name="db_name" size="33"
			value="<?php
echo $db_name;
?>"></td>
	</tr>

	<tr>
		<td width="30%">Database user name</td>
		<td width="70%"><input type="text" name="db_user" size="33"
			value="<?php
echo $db_user;
?>"></td>
	</tr>

	<tr>
		<td width="30%">Database password</td>
		<td width="70%"><input type="text" name="db_pass" size="33"
			value="<?php
echo $db_pass;
?>"></td>
	</tr>

	<tr>
		<td width="30%">&nbsp;</td>
		<td width="70%"><i>(NB : Don't use any ending slash in you path)</i><br>
		&nbsp;<BR>
		<input type="submit" class="button" name="connect_info"
			value="Continue Installation"><br>
		<br>
		</td>
	</tr>

</table>
</form>

<?php

require 'tpl/footer.php';

