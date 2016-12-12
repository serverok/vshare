<div class="col-md-3">
    {include file="menu_settings.tpl" active="password"}
</div>
<div class="col-md-9">
    <div class="page-header">
        <h1>Change Password</h1>
    </div>

    <form class="form-horizontal" method="post" action="">
        <div class="form-group">
            <label class="control-label col-md-3">Current Password:</label>
            <div class="col-md-4">
                <input type="password" maxlength="20" name="user_password" autocomplete="off" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">New Password:</label>
            <div class="col-md-4">
                <input type="password" maxlength="20" name="password_new" autocomplete="off" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Re-type new Password:</label>
            <div class="col-md-4">
                <input type="password" maxlength="20" name="password_confirm" autocomplete="off" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-2 col-md-offset-3">
                <input type="submit" name="submit" value="Change Password" class="btn btn-default btn-lg">
            </div>
        </div>
    </form>
</div>
<br>