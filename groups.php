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

$user_groups = array();
$usergroups_query_result = $dbconn->query('select gid,name from groups,enrollment where gid=groups.id and username="' . $_SESSION['username'] . '" order by name') or die("Error getting user groups");
while($row = $usergroups_query_result->fetch_assoc())
{
	$user_groups[$row['gid']] = $row['name'];
}

foreach($user_groups as $id=>$group)
{
?>
	<div class="row">
	   <div class="columns small-8 small-centered person">
	        <div class="columns small-9 left group_tag">
                <h4  data-group_id="<?php echo $id ?>"><?php echo $group ?></h4>
            </div>
            <div class="columns small-3 right">
                <i class="fa fa-minus"></i>
            </div>
            <br />
	   </div>
	</div>

<?php
}
?>

<div class="row">
    <div class="columns small-8 small-centered addGroup">
        <center><h5 class="subheader">Add More Groups</h5></center>
    </div>
</div>