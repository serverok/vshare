<div class="section" id="user-profile-edit">

    <div class="hd">
		<div class="hd-l">Edit Profile</div>
		<div class="hd-r"><a href="{$base_url}/{$user_info.user_name}">View Profile</a></div>
    </div>

    <form method="post" action="" enctype="multipart/form-data">
    
        <h2>Account Information: </h2>
    
        <div>
            <label>Email:</label>
            <input maxlength="60" size="30" value="{$user_info.user_email}" name="user_email" />
        </div>
        
        <div>
            <label>Current Password:</label>
            <input type="password" maxlength="20" name="user_password" autocomplete="off" /> 
            <span>(Only required for changing password)</span>
        </div>
        
        <div>
            <label>New Password:</label>
            <input type="password" maxlength="20" name="password_new" autocomplete="off" /> 
            <span>(Only required for changing password)</span>
        </div>
        
        <div>
            <label>Confirm Password:</label>
            <input type="password" maxlength="20" name="password_confirm" autocomplete="off" /> 
            <span>(Only required for changing password)</span>
        </div>
    
        <h2>Personal Information:</h2>
    
        <div>
            <label>First Name:</label>
            <input type="text" maxlength="30" size="30" name="user_first_name" value="{$user_info.user_first_name}" />
        </div>
        
        <div>
            <label>Last Name:</label>
            <input type="text" maxlength="30" size="30" name="user_last_name" value="{$user_info.user_last_name}" />
        </div>
            
        <div>
            <label>Birthday:</label>
            <select name="month"><option>mm</option>{$months}</select>
            <select name="day"><option>dd</option>{$days}</select>
            <select name="year"><option>yyyy</option>{$years}</select>
        </div>
            
        <div>
            <label>Gender:</label>
            <select name="user_gender">
                <option value="">- - -</option>
                <option value="Female" {if $user_info.user_gender eq "Female"}selected{/if}>Female</option>
                <option value="Male" {if $user_info.user_gender eq "Male"}selected{/if}>Male</option>
            </select>
        </div>
            
        <div>
            <label>Relationship Status:</label>
            <select name="user_relation">
                <option value="">- - -</option>
                <option value="Single" {if $user_info.user_relation eq "Single"}selected{/if}>Single</option>
                <option value="Taken" {if $user_info.user_relation eq "Taken"}selected{/if}>Taken</option>
                <option value="Open" {if $user_info.user_relation eq "Open"}selected{/if}>Open</option>
            </select>
        </div>
         
        <div>
            <label>About Me:</label>
            <textarea name="user_about_me" rows="5" cols="45">{$user_info.user_about_me}</textarea>
        </div>
        
        <div>
            <label>Personal Website:</label>
            <input type="text" maxlength="255" size="40" name="user_website" value="{$user_info.user_website}" />
        </div>
            
        <h2>Location Information:</h2>
                
        <div>
            <label>Hometown:</label>
            <input type="text" maxlength="120" size="30" name="user_town" value="{$user_info.user_town}" />
        </div>
        
        <div>
            <label>City:</label>
            <input type="text" maxlength="120" size="30" name="user_city" value="{$user_info.user_city}" />
        </div>
            
        <div>
            <label>Zip:</label>
            <input type="text" maxlength="10" size="10" name="user_zip" value="{$user_info.user_zip}" />
        </div>
        
        <div>
            <label>Country:</label>
            <select name="user_country">
                <option value="">Select Country</option>{$country}
            </select>
        </div>
            
        <h2>Random Information:</h2>

        <p>Separate items with a comma.</p>
        
        <div>
            <label>Occupations:</label>
            <input type="text" maxlength="500" size="40" name="user_occupation" value="{$user_info.user_occupation}" />
        </div>
        
        <div>
            <label>Companies:</label>
            <input type="text" maxlength="500" size="40" name="user_company" value="{$user_info.user_company}" />
        </div>
        
        <div>
            <label>Schools:</label>
            <input type="text" maxlength="500" size="40" name="user_school" value="{$user_info.user_school}" />
        </div>
        
        <div>
            <label>Interests &amp; Hobbies:</label>
            <textarea name="user_interest_hobby" rows="5" cols="45">{$user_info.user_interest_hobby}</textarea>
        </div>
        
        <div>
            <label>Favorite Movies &amp; Shows:</label>
            <textarea name="user_fav_movie_show" rows="5" cols="45">{$user_info.user_fav_movie_show}</textarea>
        </div>
        
        <div>
            <label>Favorite Music:</label>
            <textarea name="user_fav_music" rows="5" cols="45">{$user_info.user_fav_music}</textarea>
        </div>
        
        <div>
            <label>Favorite Books:</label>
            <textarea name="user_fav_book" rows=5 cols=45>{$user_info.user_fav_book}</textarea>
        </div>
        
        <div>
            <label>Friends:</label>
            <textarea name="user_friends_name" rows="5" cols="45">{$user_info.user_friends_name}</textarea>
        </div>
        
        <div>
            <label>Profile Style</label>
            <select name="user_style">
                <option value="">- -Select- -</option>
                {$css_options}
            </select>
        </div>

        <div class="submit">
            <input type="submit" value="Update Profile" name="submit" />
        </div>
    
    </form>
    
</div>
