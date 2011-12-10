<?php

echo "<h2>uptime</h2>";

echo exec("uptime");

echo "<h2>free -m</h2>";

exec("free -m", $result);
print_m($result);

echo "<h2>cpuinfo</h2>";

exec("cat /proc/cpuinfo", $result);
print_m($result);


function print_m($result)
{
	echo "<pre>";
	
	foreach ($result as $line)
	{
		echo $line . "\n";
	}
	
	echo "</pre>";
}
