<?php

define('VSHARE_VERSION_NEW', '2.7');

if (function_exists('set_time_limit'))
{
    @set_time_limit(0);
}

function upgrade_next_step($version_new=0,$next_step=0)
{
    global $config;
    
    if ($version_new != 0)
    {
        echo '<p class="upgrade-finished">vShare upgraded from version ' . $config['version'] . " to $version_new</p>";
    }
    
    if ($next_step == 0)
    {
        $redirect_url = VSHARE_URL . '/install/upgrade_start.php';
    }
    else
    {
        $redirect_url = $next_step;
    }
    
    echo <<<EOT
    <form action="$redirect_url" method="post">
    <input type="submit" name="submit" class="button" value="Continue with upgrade >>" />
    </form>
EOT;
    require './tpl/footer.php';
    
    exit;
}
