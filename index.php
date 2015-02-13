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


<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Time Space</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script>
    <link rel="stylesheet" href="img/font-awesome-4.3.0/css/font-awesome.css">
    <link rel="stylesheet" href="css/timespace.css">

  </head>
  <body>
    
    <!--Nav-->
    <div class="fixed sticky"> 
	    	<nav class="top-bar" data-topbar role="navigation">
		    	<div class="row">
		    		<div class="small-centered">
				    	<center>
				    		<i class="fa fa-users fa-2x"></i>
                            <a href="search.html"><i class="fa fa-search fa-2x"></i></a>
                            <a href="index.php"><i class="fa fa-home fa-2x"></i></a>
                            <a href="friend_requests.php"><i class="fa fa-user-plus fa-2x"></i></a>
                            <a href="settings.php"><i class="fa fa-gear fa-2x"></i></a>
						</center>
					</div>
				</div>
	    	</nav> 
	</div>
	<!--End Nav-->

    <!--Main Body-->

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
                <center><h4>Flake Rate: 20%</h4></center>
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
                    <a href="sms://" class="small left button">SMS</a>
                    <a href="#" class="small right button">Facebook</a>
                </center>
            </div>
        </div>
    </div>

    <?php
    	}
    ?>
    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>
