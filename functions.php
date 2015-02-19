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


	$dbconn->query("update people set fname='$fname',lname='$lname',major='$major',phone_number='$phone_number',img_directory='$file' where username='" . $_SESSION['username'] . "'") or die("Failed to update user info");

	return true;


}
elseif(isset($_POST['action']) && $_POST['action'] == 'add_availability')
{
    $start_time = '';
    $end_time = '';

    $day_array = array(
                        'sunday' => false,
                        'monday' => false,
                        'tuesday' => false,
                        'wednesday' => false,
                        'thursday' => false,
                        'friday' => false,
                        'saturday' => false  
                        );

    if(isset($_POST['start_time']))
    {
        $start_time = $_POST['start_time'];
    }
    else
    {
        die("NO START TIME GIVEN");
    }

    if(isset($_POST['end_time']))
    {
        $end_time = $_POST['end_time'];
    }
    else
    {
        die("NO END TIME GIVEN");
    }

    $day_of_week = 1;
    foreach($day_array as $day => $val)
    {
        if(isset($_POST["$day"]))
        {
            if($_POST["$day"] == "true")
            {
                $dbconn->query("insert into schedules (username, day_of_week, start_time, end_time) values ('" . $_SESSION['username'] . "',$day_of_week,'$start_time','$end_time')") or die("Failed to insert schedule");
            }
        }
        $day_of_week++;
    }
    return true;
}
elseif(isset($_POST['action']) && $_POST['action'] == 'get_all_current_available')
{

    //$return_json_array = array();

    $username = '';
    if(isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];
    }
    else
    {
        die("NO USERNAME GIVEN");
    }

    $people_query = $dbconn->query("select people.*, end_time from enrollment,people,schedules where gid in (select gid from enrollment where username = '$username') and enrollment.username!='$username' and enrollment.username=people.username and schedules.username=people.username and dayofweek(NOW())=day_of_week and curtime() between start_time and end_time and is_active") or die("Failed to get all active");

    $people_html = '';
    while($row = $people_query->fetch_assoc())
    {

        $people_html .= 
        "<div class='person'>
            <div class='row'>
                <div class='small-centered small-8 columns'>
                    <h4>" . $row['fname'] . " " . $row['lname'] . "</h4>
                </div>
            </div>
            
            <div class='row details'>
                    <div class='small-centered small-8 columns'>
                        <h4 class='text-left left'>
                            <small>
                                Major:" . $row['major'] . "
                            </small>
                        </h4>
                    </div>
                </div>

            <div class='row'>
                <div class='small-centered small-8 columns profilePic'>
                    <img src='" . ($row['img_directory'] == '' ? 'img/guy2.jpg' : $row['img_directory']) . "'/>
                </div>
            </div>
            
            <div class='row'>
                <div class='small-centered small-8 column'>
                    <center><h4>Available Until: " . date('h:i A', strtotime($row['end_time'])) . "</h4></center>
                </div>
            </div>
        
            <div class='row'>
                <div class='small-centered small-8 columns buttonarea'>
                    <center>
                        <a href='sms:" . $row['phone_number'] . "' class='small button'>SMS</a>
                        <a href=mailto:'" . $row['username'] . "@ucsd.edu' class='small right button'>Email</a>
                    </center>
                </div>
            </div>
        </div>";

    }

    if($people_html == '')
    {
        echo "            
            <div class='row'>
                <div class='small-centered small-8 columns profilePic'>
                    <center>
                        <h4>Nobody Currently Available</h4>
                    </center>
                </div>
            </div>";
    }
    else
    {
       echo $people_html; 
    }

}
elseif(isset($_POST['action']) && $_POST['action'] == 'get_all_group')
{
    $username = '';
    $group_id = '';
    if(isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];
    }
    else
    {
        die("NO USERNAME GIVEN");
    }
    if(isset($_POST['gid']) && $_POST['gid'] != '')
    {
        $gid = $_POST['gid'];
    }
    else
    {
        die("NO GROUP ID GIVEN");
    }

    $people_query = $dbconn->query("select * from people,enrollment where people.username=enrollment.username and gid=$gid and people.username!='$username' and is_active") or die("Failed to get all active");

    $people_html = '';
    while($row = $people_query->fetch_assoc())
    {

        $people_html .= 
        "<div class='person'>
            <div class='row'>
                <div class='small-centered small-8 columns'>
                    <h4>" . $row['fname'] . " " . $row['lname'] . "</h4>
                </div>
            </div>
            
            <div class='row details'>
                    <div class='small-centered small-8 columns'>
                        <h4 class='text-left left'>
                            <small>
                                Major:" . $row['major'] . "
                            </small>
                        </h4>
                    </div>
                </div>

            <div class='row'>
                <div class='small-centered small-8 columns profilePic'>
                    <img src='" . ($row['img_directory'] == '' ? 'img/guy2.jpg' : $row['img_directory']) . "'/>
                </div>
            </div>
            <br />
        
            <div class='row'>
                <div class='small-centered small-8 columns buttonarea'>
                    <center>
                        <a href='sms:" . $row['phone_number'] . "' class='small button'>SMS</a>
                        <a href=mailto:'" . $row['username'] . "@ucsd.edu' class='small right button'>Email</a>
                    </center>
                </div>
            </div>
        </div>";

    }
    if($people_html == '')
    {
        echo "            
            <div class='row'>
                <div class='small-centered small-8 columns profilePic'>
                    <center>
                        <h4>Nobody else in group</h4>
                    </center>
                </div>
            </div>";
    }
    else
    {
       echo $people_html; 
    }
    
}



?>


