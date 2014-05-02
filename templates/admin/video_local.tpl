{literal}

	<script type="text/javascript">

		function check_all(status)
		{
			var elms = document.frm.elements.length;
			
			for ( var i = 0;i < elms;i++ )
			{
				document.frm.elements[i].checked = status;
			}
		}
		function validate()
		{
			var j = 0;
			var elms = document.frm.elements.length;
			
			for ( var i = 0;i < elms;i++ )
			{
				if ( document.frm.elements[i].checked == true )
				{
					j = 1;
				}
			}
			
			if ( j == 0 )
			{
				alert('Please select atleast one file to move.');
				return false;
			}
			else if ( document.frm.server.value == '')
			{
				alert('Please select server.');
				return false;
			}
			else if ( j == 1 )
			{
				document.frm.submit();
			}    
		}
	</script>
{/literal}

<h1>Local Videos ({$total})</h1>

{if $total gt 0}
	<form method="post" name="frm" id="frm" action="video_local_move.php">
	
		<table cellspacing="1" cellpadding="3" width="100%" border="0">
			<tr class="tabletitle">
				<td>&nbsp;</td>
				<td width="10%">
					<b>ID</b>
					<a href="video_local.php?sort=video_id+asc&page={$page}">
						<span class="glyphicon glyphicon-arrow-up"></span>
					</a>
					<a href="video_local.php?sort=video_id+desc&page={$page}">
						<span class="glyphicon glyphicon-arrow-down"></span>
					</a>
				</td>

				<td>
					<b>Title</b>
					<a href="video_local.php?sort=video_title+asc&page={$page}">
						<span class="glyphicon glyphicon-arrow-up"></span>
					</a>
					<a href="video_local.php?sort=video_title+desc&page={$page}">
						<span class="glyphicon glyphicon-arrow-down"></span>
					</a>
				</td>
				<td width="10%">
					<b>Type</b>
					<a href="video_local.php?sort=video_type+asc&page={$page}">
						<span class="glyphicon glyphicon-arrow-up"></span>
					</a>
					<a href="video_local.php?sort=video_type+desc&page={$page}">
						<span class="glyphicon glyphicon-arrow-down"></span>
					</a>
				</td>
				<td width="15%">
					<b>Duration</b>
					<a href="video_local.php?sort=video_duration+asc&page={$page}">
						<span class="glyphicon glyphicon-arrow-up"></span>
					</a>
					<a href="video_local.php?sort=video_duration+desc&page={$page}">
						<span class="glyphicon glyphicon-arrow-down"></span>
					</a>
				</td>
				<td width="10%">
					<b>Date</b>
					<a href="video_local.php?sort=video_add_date+asc&page={$page}">
						<span class="glyphicon glyphicon-arrow-up"></span>
					</a>
					<a href="video_local.php?sort=video_add_date+desc&page={$page}">
						<span class="glyphicon glyphicon-arrow-down"></span>
					</a>
				</td>
			</tr>

			{section name=aa loop=$videos}
			
				<tr class="{cycle values="tablerow1,tablerow2"}">
					<td><input type="checkbox" id="local_videos" name="local_videos[]" value="{$videos[aa].video_id}" /></td>
					<td>{$videos[aa].video_id}</td>
					<td><a href="video_details.php?a={$a}&id={$videos[aa].video_id}&page={$page}">{$videos[aa].video_title}</a></td>
					<td align="center">{$videos[aa].video_type}</td>
					<td align="center">{$videos[aa].video_length}</td>
					<td align="center">{$videos[aa].video_add_date|date_format}</td>
				</tr>

			{/section}
				
		</table>
		
        <div class="margin-tb-1em">
			<a href="Javascript:void(0);" onclick="check_all(true);">Check All</a> / 
            <a href="Javascript:void(0);" onclick="check_all(false);">Uncheck All</a>
        </div>
        
        <div>
            <select name="server">
                <option value=''> - - Select Server - - - -</option>
                {section name=i loop=$servers}
                    <option value="{$servers[i].id}">
                        {$servers[i].url}
                        {if $servers[i].server_type eq 0}
                            (VIDEO SERVER)
                        {elseif $servers[i].server_type eq 2}
                            (SECDOWNLOAD)
                        {/if}
                    </option>
                {/section}
            </select>
            <input type="submit" name="submit" value="Move" onclick="return validate();" />
        </div>   
        
        <div class="margin-tb-1em">
            {$links}
        </div>
	
	</form>
{else}
	<center>There is no video found.</center>
{/if}
