{if $user.user_id ne ""}

<div id="user-view">

    <h1>User: {$user.user_name}</h1>

        <div>
            <div class="float_l">User ID </div>
            <div>{$user.user_id}</div>
        </div>

        <div>
            <div class="float_l">User Name </div>
            <div>{$user.user_name}</div>
        </div>

        <div>
            <div class="float_l"> Email Address </div>
            <div>{$user.user_email}</div>
        </div>

        {if $user.user_first_name ne ""}
        <div>
            <div class="float_l">Full Name</div>
            <div>{$user.user_first_name} {$user.user_last_name}</div>
        </div>
        {/if}

        {if $user.user_city ne ""}
        <div>
            <div class="float_l">City</div>
            <div>{$user.user_city}</div>
        </div>
        {/if}

        {if $user.user_country ne ""}
        <div>
            <div class="float_l">Country</div>
            <div>{$user.user_country}</div>
        </div>
        {/if}

        {insert name=subscriber_info assign=pack uid=$user.user_id}
        {if $pack.pack_name ne ""}
        <div>
            <div class="float_l">Subscribed Package</div>
            <div>
                <a href="{$base_url}/admin/packages.php?a=Search&pack_id={$pack.pack_id}&page=">
                    {$pack.pack_name}
                </a>
            </div>
        </div>
        {/if}

        {if $pack.used_space ne ""}
        <div>
            <div class="float_l">Used Space</div>
            <div>{insert name=format_size size=$pack.used_space}</div>
        </div>
        {/if}

        {if $pack.used_bw ne ""}
        <div>
            <div class="float_l">Used Bandwidth</div>
            <div>{insert name=format_size size=$pack.used_bw}</div>
        </div>
        {/if}

        {if $pack.total_video ne ""}
        <div>
            <div class="float_l">Total Uploaded Video</div>
            <div>{$pack.total_video}</div>
        </div>
        {/if}

        {if $pack.expired_time|date_format ne ""}
        <div>
            <div class="float_l"> Expired Date</div>
            <div>{$pack.expired_time|date_format}</div>
        </div>
        {/if}

        <hr />
    {/if}

    {if $user.user_website ne ""}
    <div>
      <div class="float_l">Website</div>
      <div>{$user.user_website}</div>
    </div>
    {/if}

    {if $user.user_occupation ne ""}
    <div>
        <div class="float_l">Occupation</div>
        <div>{$user.user_occupation}</div>
    </div>
    {/if}

    {if $user.user_company ne ""}
    <div>
        <div class="float_l">Company Name</div>
        <div>{$user.user_company}</div>
    </div>
    {/if}

    {if $user.user_school ne ""}
    <div>
        <div class="float_l">School</div>
        <div>{$user.user_school}</div>
    </div>
    {/if}

    {if $user.user_interest_hobby ne ""}
    <div>
        <div class="float_l">Interest/Hobby</div>
        <div>{$user.user_interest_hobby}</div>
    </div>
    {/if}

    {if $user_info.user_fav_movie_show ne ""}
    <div>
        <div class="float_l">Favorite Movie</div>
        <div>{$user.user_fav_movie_show}</div>
    </div>
    {/if}

    {if $user.user_fav_book ne ""}
    <div>
        <div class="float_l">Favorite Book</div>
        <div>{$user.user_fav_book}</div>
    </div>
    {/if}

    {if $user.user_fav_music ne ""}
    <div>
        <div class="float_l"> Favorite Music</div>
        <div>{$user.user_fav_music}</div>
    </div>       
    {/if}

    {if $user.user_about_me ne ""}
    <div>
        <div class="float_l"> About Me</div>
        <div>{$user.user_about_me}</div>
    </div>
    <hr />
    {/if}

    <div>
        <div class="float_l">Video Viewed</div>
        <div>{$user.user_video_viewed}</div>
    </div>

    <div>
        <div class="float_l">Profile Viewed</div>
        <div>{$user.user_profile_viewed}</div>
    </div>

    <div>
        <div class="float_l">Watched Video</div>
        <div>{$user.user_watched_video}</div>
    </div>

    <div>
        <div class="float_l">Join Date</div>
        <div>{$user.user_join_time|date_format}</div>
    </div>

    <div >
        <div class="float_l">Last Login</div>
        <div>{$user.user_last_login_time|date_format}</div>
    </div>

    <div>
        <div class="float_l">Email Verified</div>
        <div>{$user.user_email_verified}</div>
    </div>

    <div>
      <div class="float_l">Account Status</div>
      <div>{$user.user_account_status}</div>
    </div>

    <hr />  

    <div align="center" style="background-color:#FFF5D9;border:1px solid #FED973;padding:2px">
        <a href="user_edit.php?action=edit&uid={$user.user_id}&page={$smarty.request.page}">Edit</a> &nbsp;
        <a href="user_videos.php?uid={$user.user_id}">Videos</a> &nbsp;
        <a href="user_delete.php?uid={$user.user_id}" onclick='Javascript:return confirm("Are you sure you want to delete?");'>Delete</a>&nbsp;
        <a href="mail_users.php?email={$user.user_email}&uname={$user.user_name}">Send Mail</a>&nbsp;
        <a href="user_login.php?username={$user.user_name}" target="_blank">Login</a>
    </div>

</div>