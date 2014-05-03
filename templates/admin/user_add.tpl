<h1>Add New User</h1>

<form method="POST" action="" class="form-horizontal">

    <fieldset>

        <!-- Form Name -->
        <legend>Add User</legend>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="user_name">Username</label>
          <div class="col-md-5">
          <input id="user_name" name="user_name" type="text" placeholder="Username" class="form-control input-md" required="">
          <span class="help-block">Enter Username</span>
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="user_email">Email</label>
          <div class="col-md-5">
          <input id="user_email" name="user_email" type="text" placeholder="Email" class="form-control input-md" required="">
          <span class="help-block">Enter email address.</span>
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="user_password">Password</label>
          <div class="col-md-5">
          <input id="user_password" name="user_password" type="text" placeholder="Password" class="form-control input-md" required="">
          <span class="help-block">Enter password</span>
          </div>
        </div>


    {if $enable_package eq "yes"}

        <!-- Select Basic -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="user_package_id">Package</label>
          <div class="col-md-5">
            <select id="user_package_id" name="user_package_id" class="form-control">
                {section name=i loop=$package}
                <option value="{$package[i].package_id}">{$package[i].package_name}</option>
                {/section}
            </select>
          </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="user_package_duration">Duration</label>
          <div class="col-md-5">
            <input type="text" size="2" name="user_package_duration" id="user_package_duration" value="{$smarty.post.user_package_duration}" class="form-control">
            <select id="user_package_duration_type" name="user_package_duration_type" class="form-control">
                <option value="days">Days</option>
                <option value="months">Months</option>
                <option value="years">Years</option>
            </select>
          </div>
        </div>

    {/if}

        <!-- Button -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="submit"></label>
          <div class="col-md-4">
            <button id="submit" name="submit" class="btn btn-primary">Add User</button>
          </div>
        </div>


    </fieldset>
</form>
