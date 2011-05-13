{if $err ne ""}
    <div class="vshare-error">{$err}</div>
{/if}

{if $msg ne ""}
    <div class="vshare-success"><div>{$msg} <button class="vshare-success-button" onclick="$(this).parent().parent().hide();"></button></div> </div>
{/if}