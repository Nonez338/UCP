	function checkUserAndPass (form)
	{   
		var preg = /^\s+/;
		var txt1 = form.txt1;
		var txt2 = form.txt2;
		var span = document.getElementById("field_note");

		if ( preg.test(txt1.value) || preg.test(txt2.value) || txt1.value == "" || txt2.value == "" )
		{
			var msg  = "אנא הקלד את הססמא שלך";
		}
		
		else
		{   
			if ( txt1.value != txt2.value )
			{
				var msg = "ססמאות אינן תואמות!";
				txt1.style.border = "1px solid red";
				txt2.style.border = "1px solid red";			
			}			
			else
			{
				var msg = "ססמאות תואמות!";
				txt1.style.border = "1px solid green";
				txt2.style.border = "1px solid green";
			}
		}
		span.innerHTML = msg;
	}

function checkEmail (form)
{
	var email = form.email_address;
	var span  = document.getElementById("email_note");
	
	var valid = /^\w[\w+\-\.]*\@{1}([\w\.\-]+)(\.\w{2,3})+$/
	var empty = /^\s+/;

	if ( !empty.test(email.value) && email.value != "" )
	{
		if ( !valid.test(email.value) )
		{
			var msg = "פורמט אימייל אסור!";
			email.style.border = "1px solid red";
		}
		else
		{
			var msg = "פורמט אימייל חוקי!";
		    email.style.border = "1px solid green";
		}
	}
	else
	{
		var msg = "אנא הקלד את כתובת האימייל שלך";	
	}
    
    span.innerHTML = msg;	
}

	function checkUser (form)
	{   
		var txt1 = form.txt1;
		var span = document.getElementById("field_note");

		if ( preg.test(txt1.value) || preg.test(txt2.value) || txt1.value == "" || txt2.value == "" )
		{
			var msg  = "אנא הקלד את הססמא שלך";
		}
		
		else
		{   
			if ( txt1.value != txt2.value )
			{
				var msg = "ססמאות אינן תואמות!";
				txt1.style.border = "1px solid red";
				txt2.style.border = "1px solid red";			
			}			
			else
			{
				var msg = "ססמאות תואמות!";
				txt1.style.border = "1px solid green";
				txt2.style.border = "1px solid green";
			}
		}
		span.innerHTML = msg;
	}