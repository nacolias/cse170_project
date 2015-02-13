<?php
session_start();
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
{
  // check their log in time
  if(time() >= $_SESSION['logout_time'])
    header("Location:http://$_SERVER[HTTP_HOST]/time-space/logout.php");
}
else
{
  header("Location:http://$_SERVER[HTTP_HOST]/time-space/login.php");
}

require_once("dbconn.php");

if(isset($_POST['action']) && $_POST['action'] == 'update_info')
{
    $fname = '';
    $lname = '';
    $major = '';
    $phone_number = '';
    $img_directory = '';

    if(isset($_POST['fname']))
    {
    	$fname = $_POST['fname'];
    }
    if(isset($_POST['lname']))
    {
   		$lname = $_POST['lname'];
    }
    if(isset($_POST['major']))
    {
    	$major = $_POST['major'];
    }
    if(isset($_POST['phone_number']))
    {
    	$phone_number = $_POST['phone_number'];
    }
    if(isset($_POST['file']))
    {
    	$file = $_POST['file'];
    }


	$dbconn->query("update people set fname='$fname',lname='$lname',major='$major',phone_number='$phone_number',img_directory='$file' where username='" . $_SESSION['username'] . "'") or die("Failed to update");

	echo "1";


}
