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
    
    <script src="js/jquery-2.1.3.min.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>



    $(document).ready(function(){
        $.post("homepage.php",{

         },
        function(data) {
            $("#main_content").html(data);
        });

        $("#home").click(function(evt){
            evt.preventDefault();
            $.post("homepage.php",{

             },
            function(data) {
                $("#main_content").html(data);
            });
        });

        $("#groups").click(function(evt){
            evt.preventDefault();
            $.post("homepage.php",{
 
             },
            function(data) {
                $("#main_content").html(data);
            });
        });

        $("#settings").click(function(evt){
            evt.preventDefault();
            $.post("settingspage.php",{

             },
            function(data) {
                $("#main_content").html(data);
            });
        });


        $("#groups").click(function(evt){
            evt.preventDefault();
            $.post("groups.php",{

             },
            function(data) {
                $("#main_content").html(data);
            });
        });
    });


    $(document).on('click', '#availability' function(evt){
        evt.preventDefault();
        $.post("viewcurrent.php",{


         },
        function(data) {
            $("#main_content").html(data);
        });
    });


    </script>

  </head>
  <body>
    
    <!--Nav-->
    <div class="fixed sticky"> 
	    	<nav class="top-bar" data-topbar role="navigation">
		    	<div class="row">
		    		<div class="small-centered">
				    	<center>
				    		<i id="groups"class="fa fa-users fa-2x"></i>
                            <i id="home" class="fa fa-home fa-2x"></i>
                            <i id="settings"class="fa fa-gear fa-2x"></i>
						</center>
					</div>
				</div>
	    	</nav> 
	</div>
	<!--End Nav-->

    <!--Main Body-->
    <div id="main_content">

    </div>
    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>
