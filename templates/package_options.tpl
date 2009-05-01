<form action="payment.php" method="post" id="package-options">

    <input type="hidden" name="package_id" value="{$smarty.get.package_id}" />
    <input type="hidden" name="user_id" value="{$smarty.get.user_id}" />

    <h2>Package Options</h2>
    
    <p>Provide necessary information to complete your payment:</p>

    <div>
        <label>Your Package:</label>
        <b>{$package.package_name}</b>
    </div>

    <div>
        <label>Package Price:</label>
        <b>${$package.package_price} per {$package.package_period}</b>
    </div>

    <div>
        <label>Subscription Period:</label>
        <select name="period">{$period_ops}</select><b> {$package.package_period}</b>
    </div>

    <div>
        <label>Payment Method:</label>
        <select name="method">{$payment_method_ops}</select>
    </div>
        
    <div class="submit">
        <input type="submit" name="next" value="Next >>" />
    </div>

<form>
