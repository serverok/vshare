<?php

require '../include/config.php';

$name  = time();

$cmd = "/usr/bin/mysqldump -u $db_name -p$db_pass $db_name > $name.sql";
exec($cmd);


echo "<p>Backup created: $name.sql</p>";