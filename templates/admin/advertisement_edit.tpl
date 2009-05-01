<h1>Edit Advertisement: {$advertisement_info.adv_name}</h1>

<form action="" method="post">
    <input type="hidden" name="advertisement_id" value="{$smarty.get.adv_id}" />
    <h5>Edit Code:</h5>
    <textarea name="advertisement_text" rows="15" cols="80">{$advertisement_info.adv_text}</textarea>
    <div class="margin-tb-1em">
        <input type="submit" name="submit" value="Update" />
    </div>
</form>

{insert name=advertise adv_name=$advertisement_info.adv_name}