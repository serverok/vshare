{if $inactive_user eq '1'}

<div align="center">
     <a href="{$base_url}/resend_activation_mail.php">Resend activation e-mail</a>
</div>

{else}

<div id="login_box1">

    <div class="section bg2">
    
        <div class="hd">
            <div class="hd-l">
                Information of {$site_name}
            </div>
        </div>
        
        <div class="margin-1em">
            
            <h2>What is {$site_name}?</h2>                 
            
            <p>{$site_name} is a way to get your videos to the people who matter to you. With {$site_name} you can:</p>
            
            <ul>
                <li>Show off your favorite videos to the world</li>
                <li>Blog the videos you take with your digital camera or cell phone</li>
                <li>Securely and privately show videos to your friends and family around the world</li>
                <li>... and much, much more!</li>                
            </ul>
            
            <p class="signup"><a href="{$base_url}/signup/">Sign up Now</a> and open a new account.</p>
            
            <p>To learn more about our service, please see our <a href="{$base_url}/pages/help.html">Help</a> section.</p>
        </div>
    
    </div>

</div> <!-- login_box1 -->

<div id="login_box2">
  
    <div class="section bg2">
    
        <div class="hd">
            <div class="hd-l">
                  {$site_name} Log In
            </div>
        </div>
        
        <form method="post" action="{$base_url}/login/" id="login-form">
        
            <div>
                <label for="user_name">User Name:</label>
                <input type="text" id="user_name" size="22" name="user_name" value="{$user_name}" />
            </div>
             
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" size="22" name="user_password" />
            </div>

            <div class="forget-passsword">
                <a href="{$base_url}/recoverpass.php">Forgot your password?</a>
            </div>
            
            <div class="submit">
                <input type="submit" value="Log In" name="action_login" />
                <input type="checkbox" name="autologin" />Remember
            </div>
        
        </form>
    
    </div> 
    
</div> <!--login_box2 -->

{/if}