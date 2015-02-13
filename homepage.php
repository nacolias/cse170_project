<?php
session_start();
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
{
  // check their log in time
  if(time() >= $_SESSION['logout_time'])
    header("Location:http://nacolias.ucsd.edu/time-space/logout.php");
}
else
{
  header("Location:http://nacolias.ucsd.edu/time-space/login.php");
}
?>
    <?php

    	for($i = 1; $i <= 20; $i++){

    ?>
 	<div class="person">
        <div class="row">
            <div class="small-centered small-8 columns">
                <h4>Tim Holloway </h4>
            </div>
        </div>
        
        <div class="row details">
                <div class="small-centered small-8 columns">
                    <h4 class="text-left left">
                        <small>
                            Major:Computer Engineering, 6th Year
                        </small>
                    </h4>
                </div>
            </div>

        <div class="row">
            <div class="small-centered small-8 columns profilePic">
                <img src="img/guy2.jpg" />
            </div>
        </div>
        
        <div class="row">
            <div class="small-centered small-8 columns">
                <center><h4>Free Until: 6:00 PM</h4></center>
            </div>
        </div>
    
        <div class="row">
            <div class="small-centered small-8 columns buttonarea">
                <center>
                    <a href="sms:1-818-632-2449" class="small button">SMS</a>
                    <a href="mailto:dcanas@ucsd.edu" class="small right button">Email</a>
                </center>
            </div>
        </div>
    </div>


    <?php
    	}
    ?>

