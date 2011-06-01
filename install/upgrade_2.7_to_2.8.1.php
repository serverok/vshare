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

$html_title = 'VSHARE UPGRADE';
require '../include/config.php';
require './inc/class.sql_import.php';
require './inc/functions_upgrade.php';
require './tpl/header.php';

if ($config['version'] != '2.7')
{
    die('<p>This upgrade script can only upgrade if you are using version: 2.7</p>');
}

write_log('#### UPGRADE 2.7 to 2.8.1 STARTED ####', 'vshare_upgrade', 0, 'txt');

$sql_file = VSHARE_DIR . '/install/sql/upgrade_2.7_to_2.8.1.sql';
$sql_import = new Sql2Db($sql_file);
$sql_import->import();

write_log('#### UPGRADE 2.7 to 2.8.1 FINISHED ####', 'vshare_upgrade', 0, 'txt');

upgrade_next_step();
