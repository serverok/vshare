<?php

session_start();

if (!isset($_SESSION['counter']))
{
    $_SESSION['counter'] = 1;
}
else
{
    $_SESSION['counter'] = $_SESSION['counter'] + 1;
}

?>
<html>
<head>
<title>Session Testing</title>
</head>
<body>
<p>If you see the number increase on every refresh, session is working on your server.</p>

<h1><?php echo $_SESSION['counter']; ?></h1>
</body>
</html>