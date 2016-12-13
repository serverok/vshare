<div class="col-md-3">
    {include file="menu_settings.tpl" active="delete"}
</div>
<div class="col-md-9">
{if $mail_send == 0}

        <h1 class="text-danger">
            Delete Account
        </h1>

        <p class="lead text-muted">Deleting account will remove all your videos, comments from this site.</p>

        <form action="user_delete.php" method="post">
            <button type="submit" name="submit" class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-remove"></span>  Yes, Delete My Account</button>
        </form>

{else}

        <h3>
            A mail sent to your email address with account delete verification link.
            You need to click on the link to delete your account.
        </h3>

{/if}
</div>
