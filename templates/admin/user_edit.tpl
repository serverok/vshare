<form action="user_edit.php?a={$smarty.request.a}action=edit&uid={$user.user_id}&page={$smarty.request.page}&sort={$smarty.request.sort}" method="post">

    <h1>Edit User</h1>

    <div>
        <label>User ID:</label>
        {$user.user_id}
    </div>

    <div>
        <label>User Name:</label>
        {$user.user_name}
    </div>

    <div>
        <label>Email Address:</label>
        <input name="email" value="{$user.user_email}" size="43" />
    </div>

    <div>
        <label>Full Name:</label>
        <input name="fname" value="{$user.user_first_name}" />
        <input name="lname" value="{$user.user_last_name}" />
    </div>

    <div>
        <label>City:</label>
        <input name="city" value="{$user.user_city}" />
    </div>

    <div>
        <label>Country:</label>
        <select name="country"><option value="">Select Country</option>{$country_box}</select>
    </div>

    <div>
        <label>Website:</label>
        <input name="website" value="{$user.user_website}" />
    </div>

    <div>
        <label>Occupation:</label>
        <textarea name="occupation" rows="3" cols="40">{$user.user_occupation}</textarea>
    </div>

    <div>
        <label>Company Name:</label>
        <textarea name="company" rows="3" cols="40">{$user.user_company}</textarea>
    </div>

    <div>
        <label>School:</label>
        <textarea name="school" rows="3" cols="40">{$user.user_school}</textarea>
    </div>

    <div>
        <label>Interest/Hobby:</label>
        <textarea name="interest_hobby" rows="3" cols="40">{$user.user_interest_hobby}</textarea>
    </div>

    <div>
        <label>Favorite Movie:</label>
        <textarea name="fav_movie_show" rows="3" cols="40">{$user.user_fav_movie_show}</textarea>
    </div>

    <div>
        <label>Favorite Book:</label>
        <textarea name="fav_book" rows="3" cols="40">{$user.user_fav_book}</textarea>
    </div>

    <div>
        <label>Favorite Music:</label>
        <textarea name="fav_music" rows="3" cols="40">{$user.user_fav_music}</textarea>
    </div>

    <div>
        <label>About Me:</label>
        <textarea name="aboutme" rows="3" cols="40">{$user.user_about_me}</textarea>
    </div>

    <div>
        <label>Email Verified:</label>
        <select name="emailverified">{$email_ver_box}</select>
    </div>

    <div>
        <label>Account Status:</label>
        <select name="account_status">{$account_status_box}</select>
    </div>

    <div class="submit">
        <input type="submit" name="submit" value="Update" class="btn btn-primary" />
    </div>

</form>