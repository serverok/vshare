<!DOCTYPE html>
<html lang="en">
<head>
<title>vShare Admin</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="{$base_url}/css/bootstrap.min.css" rel="stylesheet">
<body>

<div class="container">
    <div class="col-md-4 col-md-offset-3">
        <form  action="" method="post" class="form-signin" role="form">

            <h2 class="form-signin-heading">Login</h2>

            {if $login_error ne ''}
                <div class="alert alert-danger">{$login_error}</div>
            {/if}

            <div class="form-group">
                <input type="text" name="user_name" class="form-control" placeholder="Username" required autofocus>
            </div>

            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="form-group">
                <button class="btn btn-lg btn-default btn-lg" type="submit" name="submit">Log In</button>
            </div>

            <a href="./lost_password.php" class="btn">Lost Password?</a>
        </form>
    </div>

    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="col-md-offset-4">
        Powered by: <a href="http://buyscripts.in/youtube_clone.html" target="_blank">vShare</a>
    </div>
</div>

</body>
</html>