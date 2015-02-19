// Error Checking for availability input

function validateForm()
{
	var sunday = document.forms["availability_form"]["sunday"].checked;
	var monday = document.forms["availability_form"]["monday"].checked;
	var tuesday = document.forms["availability_form"]["tuesday"].checked;
	var wednesday = document.forms["availability_form"]["wednesday"].checked;
	var thursday = document.forms["availability_form"]["thursday"].checked;
	var friday = document.forms["availability_form"]["friday"].checked;
	var saturday = document.forms["availability_form"]["saturday"].checked;
	var starttime = document.forms["availability_form"]["starttime"].value;
	var endtime = document.forms["availability_form"]["endtime"].value;
	

	if (sunday == '' && monday == '' && tuesday == '' &&
		wednesday == '' && thursday == '' && friday == ''
		&& saturday == '')
	{
		alert("Please check at least one day");
		return false;
	}

	if(starttime == '' || endtime == '')
	{
		alert("Please enter a Start and End Time");
		return false;
	}

	if(starttime >= endtime)
	{
		alert("Your End Time is before your Start Time");
		return false;
	}

	alert("Submit Successful!")
	return true;
}