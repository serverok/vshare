{if $inactive_user eq '1'}

<div class="text-center">
     <a class="btn btn-default btn-lg" href="{$base_url}/resend_activation_mail.php">Resend Activation E-Mail</a>
</div>

{else}

<div class="row login-box">
    <div class="col-md-6 hidden-xs">
        <div class="panel panel-default">
            <div class="panel-body">
                <h2>What is {$site_name}?</h2>
                <hr>
                <p>{$site_name} is a way to get your videos to the people who matter to you. With {$site_name} you can:</p>

                <ul class="list-unstyled">
                    <li><span class="glyphicon glyphicon-ok-circle"></span> Show off your favorite videos to the world</li>
                    <li><span class="glyphicon glyphicon-ok-circle"></span> Blog the videos you take with your digital camera or cell phone</li>
                    <li><span class="glyphicon glyphicon-ok-circle"></span> Securely and privately show videos to your friends and family around the world</li>
                    <li><span class="glyphicon glyphicon-ok-circle"></span>  Build playlists of favorites to watch at any time</li>
                    <li><span class="glyphicon glyphicon-ok-circle"></span> and much, much more!</li>
                </ul>
                <hr>
                    <p><a class="btn btn-primary btn-lg btn-block" href="{$base_url}/signup/"><strong>Sign up Now and open a new account</strong></a></p>              
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <h2>Log in to {$site_name}</h3>
                <hr>

                <form method="post" action="{$base_url}/login/" id="login-form" role="form">
                    <div class="form-group">
                        <label for="user_name">User Name</label>
                        <div class="input-group  input-group-lg">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                            <input type="text" id="user_name" name="user_name" value="{$user_name}" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group  input-group-lg">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                            <input type="password" id="password" size="22" name="user_password" class="form-control" required>
                        </div>
                    </div>

					<div class="row checkbox">
						<div class="col-md-6 col-sm-4">
							<label>
								<input type="checkbox" name="autologin"> Remember me
							</label>
						</div>
						<div class="col-md-6 col-sm-4">
							<p><a href="{$base_url}/recoverpass.php">Forgot your password?</a></p>
						</div>
					</div>
                    
                        <div class="row">
	                        <div class="form-group">
	                            <div class="col-md-4 col-sm-4">
	                                <button type="submit" name="action_login" class="btn btn-success btn-lg btn-block">Log In</button>
	                            </div>
	                        </div>
                    </div>
                </form>                             
            </div>
        </div>
    </div>
</div>

{/if}