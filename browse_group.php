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

<div class="person">
        <div class="row">
            <div class="small-centered small-8 columns">
                <h4>Nick Colias</h4>
            </div>
        </div>
        
        <div class="row details">
                <div class="small-centered small-8 columns">
                    <h4 class="text-left left">
                        <small>
                            Major:Computer Engineering
                        </small>
                    </h4>
                </div>
            </div>

        <div class="row">
            <div class="small-centered small-8 columns profilePic">
                <img src="img/nick.jpg" />
            </div>
        </div>
        
        <div class="row">
            <div class="small-centered small-8 columns">
                <center><h4>Free Until: 12:10 PM - 3:00 PM</h4></center>
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

    <div class="person">
        <div class="row">
            <div class="small-centered small-8 columns">
                <h4>Sunbrye Ly</h4>
            </div>
        </div>
        
        <div class="row details">
                <div class="small-centered small-8 columns">
                    <h4 class="text-left left">
                        <small>
                            Major:Computer Science
                        </small>
                    </h4>
                </div>
            </div>

        <div class="row">
            <div class="small-centered small-8 columns profilePic">
                <img src="img/sunbrye.jpg" />
            </div>
        </div>
        
        <div class="row">
            <div class="small-centered small-8 columns">
                <center><h4>Free Until: 1:00 PM - 4:00 PM</h4></center>
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

    <div class="row">
            <div class="small-centered small-8 columns buttonarea">
                <center>
                    <a href="sms:1-818-632-2449" class="small button">SMS</a>
                    <a href="mailto:dcanas@ucsd.edu" class="small right button">Email</a>
                </center>
            </div>
        </div>
    </div>

    <div class="person">
        <div class="row">
            <div class="small-centered small-8 columns">
                <h4>Chris Johnson</h4>
            </div>
        </div>
        
        <div class="row details">
                <div class="small-centered small-8 columns">
                    <h4 class="text-left left">
                        <small>
                            Major:Cognitive Science 
                        </small>
                    </h4>
                </div>
            </div>

        <div class="row">
            <div class="small-centered small-8 columns profilePic">
                <img src="img/guy5.jpg" />
            </div>
        </div>
        
        <div class="row">
            <div class="small-centered small-8 columns">
                <center><h4>Free Until: 2:00 PM</h4></center>
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