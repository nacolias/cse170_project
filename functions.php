<?php
$cur_directory = preg_split('/(\/|\\?)/', getcwd());
$cur_directory = $cur_directory[count($cur_directory)-1];

session_start();
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
{
  // check their log in time
  if(time() >= $_SESSION['logout_time'])
    header("Location: http://$_SERVER[HTTP_HOST]/" . $cur_directory . "/logout.php");
}
else
{
  header("Location: http://$_SERVER[HTTP_HOST]/" . $cur_directory . "/login.php");
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
    if(isset($_POST['img_directory']))
    {
    	$img_directory = $_POST['img_directory'];
    }

    echo "update people set fname='$fname',lname='$lname',major='$major',phone_number='$phone_number',img_directory='$img_directory' where username='" . $_SESSION['username'] . "'";
	$dbconn->query("update people set fname='$fname',lname='$lname',major='$major',phone_number='$phone_number',img_directory='$img_directory' where username='" . $_SESSION['username'] . "'") or die("Failed to update user info");

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

    $rand_img_array = array_diff(scandir('img/png/'), array('..', '.','.DS_Store'));

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

    $people_query = $dbconn->query("select people.*, end_time from enrollment,people,schedules where gid in (select gid from enrollment where username = '$username') and enrollment.username!='$username' and enrollment.username=people.username and schedules.username=people.username and dayofweek(NOW())=day_of_week and curtime() between start_time and end_time and is_active group by username") or die("Failed to get all active");

    $people_html = '';
    while($row = $people_query->fetch_assoc())
    {

        $people_html .= 
        "<div class='person' id='" . $row['username'] . "'>
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
                    <img class='profile_pics' data-username='" . $row['username'] . "' src='" . ($row['img_directory'] == '' ? 'img/png/' . $rand_img_array[array_rand($rand_img_array)] : $row['img_directory']) . "'/>
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
            <div class='row person_availability'>
            </div>
        </div>";

    }

    if($people_html == '')
    {
        $groups_counter = 0;
        $groups_query  = $dbconn->query("select * from enrollment where username='$username'");
        while ($row = $groups_query->fetch_assoc())
        {
            $groups_counter++;
        }
        if($groups_counter == 0)
        {
            echo  
                "<div class='row'>
                    <div class='small-centered small-8 columns profilePic'>
                        <center>
                            <h4>It looks like you aren't in any groups, 
                                <a href='#' id='add_more_groups'>click here to add some</a>
                            </h4>
                        </center>
                    </div>
                </div>";

        }
        else
        {
            echo 
                "<div class='row'>
                    <div class='small-centered small-8 columns profilePic'>
                        <center>
                            <h4>Nobody Currently Available</h4>
                        </center>
                    </div>
                </div>";
        }

    }
    else
    {
       echo $people_html; 
    }

}
elseif(isset($_POST['action']) && $_POST['action'] == 'get_all_group')
{

    $rand_img_array = array_diff(scandir('img/png/'), array('..', '.','.DS_Store'));
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

    $people_query = $dbconn->query("select * from people,enrollment where people.username=enrollment.username and gid=$gid and people.username!='$username' and is_active") or die("Failed to get all group");

    $people_html = '';
    while($row = $people_query->fetch_assoc())
    {

        $people_html .= 
        "<div class='person' id='" . $row['username'] . "'>
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
                    <img class='profile_pics' data-username='" . $row['username'] . "' src='" . ($row['img_directory'] == '' ? 'img/png/' . $rand_img_array[array_rand($rand_img_array)] : $row['img_directory']) . "'/>
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
            <div class='row person_availability'>
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
elseif(isset($_POST['action']) && $_POST['action'] == 'add_more_groups')
{
    $username = '';
    if(isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];
    }
    else
    {
        die("NO USERNAME GIVEN");
    }

    $groups_query = $dbconn->query("select * from groups where id not in (select gid as id from enrollment where username='" . $username . "')") or die("Failed to get all groups to add");
    while($row = $groups_query->fetch_assoc())
    {
        $add_groups[$row['id']] = $row['name'];
    }

    if(count($add_groups) > 0)
    {


        ?>
        <div class="row">
           <div class="columns small-8 small-centered">
                <center>
                    <h4>Click A Group To Add</h4>
                </center>
           </div>
        </div>

        <?php
    }
    else
    {
        ?>
        <div class="row">
           <div class="columns small-8 small-centered">
                <center>
                    <h4>You're in every group</h4>
                </center>
           </div>
        </div>
        <?php
    }


    foreach($add_groups as $id=>$group)
    {
    ?>
        <div class="row">
           <div class="columns small-8 small-centered person">
                <div class="columns small-9 left add_group_tag">
                        <h4  data-group_id="<?php echo $id;?>"><?php echo $group; ?></h4>
                </div>
                <br />
           </div>
        </div>

    <?php
    }

}
elseif(isset($_POST['action']) && $_POST['action'] == 'remove_from_group')
{
    $username = '';
    $gid = '';
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
    $add_group_query = $dbconn->query("delete from enrollment where gid=$gid and username='$username'") or die("Failed to remove from group");

    echo true;

}
elseif(isset($_POST['action']) && $_POST['action'] == 'add_a_group')
{
    $username = '';
    $gid = '';
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
    $add_group_query = $dbconn->query("insert into enrollment (gid,username) values ($gid,'$username')") or die("Failed to add group");

    echo true;
}
elseif(isset($_POST['action']) && $_POST['action'] == 'get_availability')
{
    $day_array = array(
                        'Sunday',
                        'Monday',
                        'Tuesday',
                        'Wednesday',
                        'Thursday',
                        'Friday',
                        'Saturday'
                        );
    $availability_array = array();
    $username = '';
    if(isset($_POST['username']) && $_POST['username'] != '')
    {
        $username = $_POST['username'];
    }
    else
    {
        die("NO USERNAME GIVEN");
    }


    $get_availability_query = $dbconn->query("select * from schedules where username='$username' order by day_of_week,start_time,end_time") or die("Failed to add group");
    while($row = $get_availability_query->fetch_assoc())
    {
        $availability_array[$row['day_of_week']][$row['id']] = date('h:i A', strtotime($row['start_time'])) . ' - ' . date('h:i A', strtotime($row['end_time']));
    }
    //echo print_r($availability_array);

    echo "
    <div class='columns small-12'>
        <ul class='pricing-table'>";

    foreach ($availability_array as $day_of_week => $times_array) 
    {
        echo "
            <div class='dayOfWeek'>
                <li class='title day_" . $day_array[$day_of_week - 1] . "'>" . $day_array[$day_of_week - 1] . "<i class='fa fa-caret-down right'></i></li>
                <div class='availabilityTimes'>
                    <li class='bullet-item'>";
                    foreach ($times_array as $key => $value) 
                    {
                        echo "<div data-alert='' class='alert-box radius'>$value"; 
                                    if($username == $_SESSION['username'])
                                    {
                                        echo "<a data-schedule_row_id='" . $key . "'  href='' class='close delete_availability'>×</a>";
                                    } 
                        echo "</div>";
                    }
            echo "</li>
                </div>
            </div>
        ";
    }

    echo "
        </ul>
    </div>";

}
elseif(isset($_POST['action']) && $_POST['action'] == 'delete_availability')
{
    $sched_id = '';
    if(isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];
    }
    else
    {
        die("NO USERNAME GIVEN");
    }
    if(isset($_POST['sched_id']) && $_POST['sched_id'] != '')
    {
        $sched_id = $_POST['sched_id'];
    }
    else
    {
        die("NO sched_id ID GIVEN");
    }
    $add_group_query = $dbconn->query("delete from schedules where id=$sched_id") or die("Failed to remove from schedule entry");

    echo true;

}



?>


