<form action="payment.php" method="post" name="payment" id="payment">

    <input type="hidden" name="package_id" value="{$smarty.post.package_id}" />
    <input type="hidden" name="user_id" value="{$smarty.post.user_id}" />
    <input type="hidden" name="period" value="{$smarty.post.period}" />
    <input type="hidden" name="method" value="{$smarty.post.method}" />
        
    <h2>Confirm Payment</h2>
    <p>Provide necessary information to complete your payment:</p>
    
    <br />
    
    <div>
        <label>Your Package:</label>
        {$package.package_name}
    </div>
    
    <div>
        <label>Total Price:</label>
        ${$totalprice} for {$smarty.request.period} {$package.package_period}(s)
    </div>
    
    <div>
        <label>Payment Method:</label>
        {$smarty.post.method}
    </div>
    
    <div>
        <label for="user_first_name">First Name:</label>
        <input type="text" name="user_first_name" id="user_first_name" size="20" maxlenth="40" value="{$user_info.user_first_name}" />
    </div>
    
    <div>
        <label for="user_last_name">Last Name:</label>
        <input type="text" name="user_last_name" id="user_last_name" size="20" maxlenth="40" value="{$user_info.user_last_name}" />
    </div>
    
    <div>
        <label for="user_city">City:</label>
        <input type="text" name="user_city" id="user_city" size="20" maxlenth="80" value="{$user_info.user_city}" />
    </div>
    
    <div>
        <label for="user_country">Country:</label>
        <select name="user_country" id="user_country">{$country}</select>
    </div>
    
    <div class="submit">
        <input type="submit" name="submit" value="Next >>" />
    </div>
       
</form>
