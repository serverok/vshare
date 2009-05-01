{if $mail_send == 0}

    <div style="text-align: center">
        <h1 style="color:#ff0000;">Delete Account</h1>
        <p>Deleting account will remove all your videos, comments from this site.</p>
        <br />
        <form action="user_delete.php" method="post">
            <input type="submit" name="submit" value="Yes, Delete My Account" />
        </form>
    </div>

{else}

    <div align="center">
        A mail sent to your email address with account delete verification link.
        You need to click on the link to delete your account.
    </div>

{/if}