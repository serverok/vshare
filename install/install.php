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

$html_title = 'VSHARE INSTALLATION';
require 'tpl/header.php';
require 'inc/folders.php';

$error = '';

echo '<h1>Installation Instruction</h1>';
echo '<ul>';

while (list($k, $v) = each($writable_folders))
{
    if ($v == 'DIR')
    {
        echo '<li>Make a directory name <b>' . $k . '</b> in your server. Chmod it to 777';
    }
    else if ($v == 'FILE')
    {
        echo '<li>Set the property of file <b>' . $k . '</b> to writable, So Chmod it to 777';
    }
}

echo '</ul>';

?>

<form name="myform1" id="foler-input-form" method="POST"
	action="./install_check_folder_permission.php"
	onsubmit="return check_folder();"><input type="hidden" name="step"
	value="1" /> Enter Directory Location below: <br />
<br />
<input type="text" name="folder" value="<?php echo str_replace('/install/install.php', '', $_SERVER['SCRIPT_FILENAME']); ?>" />
<br />
<br />
<input type="submit" name="submit" class="button" value="Start Installation" />
</form>


<?php

require 'tpl/footer.php';
