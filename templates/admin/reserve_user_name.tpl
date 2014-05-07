<div class="page-header">
    <h1>Reserved User Names</h1>
</div>

<table class="table table-striped table-hover">

    <tr>
        <td><b>User Names</b></td>
        <td align="center"><b>ACTION</b></td>
    </tr>

    {section name=i loop=$disallow}
    <tr>
        <td>{$disallow[i].disallow_username}</td>
        <td align="center">
            <a href="?action=del&id={$disallow[i].disallow_id}" onClick='Javascript:return confirm("Are you sure you want to delete?");'>
                <span class="glyphicon glyphicon-remove-circle"></span>
            </a>
        </td>
    </tr>
    {/section}

</table>

<hr />

<form method="post" action="" class="form-inline">

    <input type="hidden" name="action" value="add" />
    <div class="form-group">
        <label class="sr-only" for="name">Reserve a User Name:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" name="name" id="name" placeholder="Reserve a User Name" required>
        </div>
    </div>

    <button type="submit" name="submit" class="btn btn-default">Reserve</button>

</form>