// Error Checking for availability input

function validateForm()
{
	var sunday = document.forms["availability_form"]["sunday"].value;
	var monday = document.forms["availability_form"]["monday"].value;
	var tuesday = document.forms["availability_form"]["tuesday"].value;
	var wednesday = document.forms["availability_form"]["wednesday"].value;
	var thursday = document.forms["availability_form"]["thursday"].value;
	var friday = document.forms["availability_form"]["friday"].value;
	var saturday = document.forms["availability_form"]["saturday"].value;
	var starttime = document.forms["availability_form"]["starttime"].value;
	var endtime = document.forms["availability_form"]["endtime"].value;

	if (sunday == null && monday == null && tuesday == null &&
		wednesday == null && thursday == null && friday == null
		&& saturday == null)
	{
		alert("Please check at least one day");
		return false;
	}

	if(starttime == null || endtime == null)
	{
		alert("Please enter a Start and End Time");
		return false;
	}

	if(starttime >= endtime)
	{
		alert("Your End Time is before your Start Time");
		return false;
	}
}