<html>
<body>
<?php

error_reporting(E_ALL);
$convert_command = "REPLACE WITH YOUR CONVERT COMMAND FROM templates_c/debug.txt";
$var = exec($convert_command,$exec_result);
for($i=0;$i<count($exec_result);$i++)
{
  echo $exec_result[$i] . "<br>";
}

?>
</body>
</html>