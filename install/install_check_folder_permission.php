<?php
/******************************************************************************
 *
 *   COMPANY: BuyScripts.in
 *   PROJECT: vShare Youtube Clone
 *   VERSION: 2.7
 *   LICENSE: http://buyscripts.in/vshare-license
 *   WEBSITE: http://buyscripts.in/vshare-youtube-clone
 *
 *   This program is a commercial software and any kind of using it must agree 
 *   to vShare license.
 *
 ******************************************************************************/

$html_title = 'VSHARE INSTALLATION';
require 'tpl/header.php';
require 'inc/folders.php';

if (strlen($_POST['folder']) < 2)
{
    echo '<p>You must enter Directory Location.</p>';
    exit();
}

?>


<h1>Checking Default Directories</h1>

<?php

$error = 0;

echo '<ul id="check-default-folders">';

while (list($k, $v) = each($writable_folders))
{
    $dir = $_POST['folder'] . '/' . $k;
    
    $class = '';
    
    if (! is_writable($dir))
    {
        $status = '<font color=\'red\'><B>Error</B></font><!--  $dir  -->';
        $class = " class=\"error\"";
        $error = 1;
    }
    else
    {
        $status = '<font color=\'green\'><B>Success</B></font>';
    }
    
    echo '<li' . $class . '>Set permission for ' . $v . ' <b>' . $k . '</b> to 777  ' . $status . '</li>';
}

echo '</ul>';

if ($error == 1)
{
    echo "<form method='POST' action=''>
        <input type='submit' class='button' name='submit' value='check Again'>
        <input type='hidden' name='folder' value='{$_POST['folder']}'>
        </form>";
}
else
{
    echo "<form method='POST' action='./install_collect_info.php'>
        <input type='submit' class='button' name='submit' value='Continue Installation'>
        <input type='hidden' name='folder' value='{$_POST['folder']}'>
        </form>";
}

require './tpl/footer.php';
