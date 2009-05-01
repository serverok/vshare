<div class="section bg2 recover-pass-box">

    <div class="hd">
        <div class="hd-l">Forgot your password?</div>
    </div>

    <div class="recover-password">

        <form method="post" action="{$base_url}/recoverpass.php" id="recover-password">

            <div>
                <label>User Name:</label>
                <input type="text" name="username" value="{$smarty.post.username}" />
            </div>
                
            <p>--OR--</p>

            <div>
                <label>Email Address:</label>
                <input type="text" name="email" value="{$smarty.post.email}" />
            </div>

            <div class="submit">
                <input type="submit" value="Submit" name="recover" />
            </div>
            
        </form>
        
    </div>

</div>