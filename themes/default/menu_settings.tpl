<div class="list-group">
    <h2 class="list-group-item list-group-item-info">Settings</h2>
    <a class="list-group-item{if $active eq 'profile'} active{/if}" href="{$base_url}/{$smarty.session.USERNAME}/edit/">
        <span class="glyphicon glyphicon-user"></span> Profile Settings
    </a>
    <a class="list-group-item{if $active eq 'profile_photo'} active{/if}" href="{$base_url}/user_photo_upload.php">
        <span class="glyphicon glyphicon-picture"></span> Profile Photo</a>
    <a class="list-group-item{if $active eq 'privacy'} active{/if}" href="{$base_url}/privacy/">
        <span class="glyphicon glyphicon-cog"></span> Privacy Settings
    </a>
    <a class="list-group-item{if $active eq 'password'} active{/if}" href="{$base_url}/password/">
        <span class="glyphicon glyphicon-lock"></span> Change Password
    </a>
    <a class="list-group-item{if $active eq 'delete'} active{/if}" href="{$base_url}/user_delete.php">
        <span class="glyphicon glyphicon-remove"></span> Delete Account
    </a>
</div>
