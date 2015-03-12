<?php
$cur_directory = preg_split('/(\/|\\?)/', getcwd());
$cur_directory = $cur_directory[count($cur_directory)-1];
session_start();
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
{
  // check their log in time
  $direction = "index.php";
  if(time() >= $_SESSION['logout_time'])
  {
    $direction = "logout.php";
  }
  header("Location: http://$_SERVER[HTTP_HOST]/" . $cur_directory . "/$direction");
  exit;
}
//require "/var/www/html/jump/filter_users.php";

require "dbconn.php";
?>


<!doctype html>
<html lang="en">
  <head>

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-60450403-1', 'auto');
      ga('send', 'pageview');

    </script>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Time Slot</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script>
    <link rel="stylesheet" href="img/font-awesome-4.3.0/css/font-awesome.css">
    <link rel="stylesheet" href="css/timespace.css">

    <script src="js/jquery-2.1.3.min.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>

      $(document).ready(function(){
        $("#login").click(function(evt){
          evt.preventDefault();
          doLogin();
        });
        $("#login_form").submit(function(evt){
          evt.preventDefault();
          doLogin();
        });
      });


      function doLogin() {
        if($("#username").val() == "" || $("#password").val() == "")
          alert("Error! Please fill in both username and password!");
        else
        {
          $("#errors").html("");
          $.post("ldap_auth.php",
          {
            username:$("#username").val(),
            password:$("#password").val() 
          },
          function(data) {
            var json_data = JSON.parse(data);
            var auth_direction = data['direction'];
            if(json_data['authUser'] == true)
            {
              window.location=json_data['direction'];
            }
            else
            {
              $("#errors").html("<h4>Error!</h4>You failed to authenticate! Please check your username and password!");
            }
          });
        }
      }

    </script>




  </head>
  <body>

    <!--Nav-->
    <div class="fixed sticky"> 
            <nav class="top-bar" data-topbar role="navigation">
                <div class="row">
                    <div class="small-centered">
                        <center>
                            <h3 style="color:white;">
                                Time Space
                            </h3>
                        </center>
                    </div>
                </div>
            </nav> 
    </div>
	<!--End Nav-->


<!-- Form Boxes -->
<div class="person">
  <div class="row">
    <center><h1>Login</h4></center>
  </div>

  <form id='login_form'>
    <div class="row">
          <div class="columns small-10 small-centered ">
              <input type="text" name="username" id='username' placeholder="Username"/>
          </div>
      </div>

      <div class="row">
          <div class="columns small-10 small-centered ">
              <input type="password" name="password" id='password' placeholder="Password" />
          </div>
      </div>

      <div class="row">
          <div class="columns small-8 small-centered">
              <input type="submit" class="button expand" id='login' value="Log In"/>
              <br />
              <center><a href="#"><p>Forgot Password?</p></a></center>
          </div>
      </div>
  </form>
  <center>
    <div id="errors">
  </center>
  </div>
</div>



<script>
	$(document).foundation();
</script>

  </body>
</html>