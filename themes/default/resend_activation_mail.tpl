{if $activation_mail_sent eq ""}

<div class="margin-2em;">

    <h2>Send activation e-mail</h2>
    
    <p>This is the email associated with your account. Once you click the "Resend Activation Mail" button, you will get mail with activation link. If you do not see activation mail in Inbox, check your spam box also.</p>
    
    <p>If you can't get email on email address used to register, just change the email address below and click "Resend Activation Mail" button.</p>

    <form action="" method="post">
    <p>E-mail address: <input type="text" name="email" value="{$user_email}" size="25" maxlength="100" /></p>
    <input type="submit" name="submit" value="Resend Activation Mail" />
    </form>
    
</div>

{else}

<center>The activation e-mail has been sent to your e-mail address.</center>

{/if}