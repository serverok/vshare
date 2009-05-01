$(function()
{ 
	$("#select_all").click(function() 
	{
		var checked_status = this.checked;
		$("input[name='mid[]']").each(function(){
			this.checked = checked_status; 
		});
	}); 
});


function validate_frm()
{
	var j = 1;var x = 1;
	var length = document.mail.elements.length;
	
	for(var i=0;i<length;i++)
	{
		if (document.mail.elements[i].name == 'mid[]')
		{
			x = x + 1;
			
			if (document.mail.elements[i].checked != true)
			{
				j = j + 1;
			}
		}
	}
	
	if (j == x)
	{
		alert('Please select any one');
		return false;
	} 
	else 
	{
		return true;
	} 
}
