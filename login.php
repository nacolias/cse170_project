<?php/*
session_start();
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
{
  // check their log in time
  $direction = "index.php";
  if(time() >= $_SESSION['logout_time'])
  {
    $direction = "logout.php";
  }
  header("Location:http://nacolias.ucsd.edu/time-space/$direction");
  exit;
}
//require "/var/www/html/jump/filter_users.php";
require "/Applications/MAMP/htdocs/time-space/dbconn.php";
*/?>


<!doctype html>
<html lang="en">
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
              alert("LOGGED IN");
              window.location=json_data['direction'];
            }
            else
            {
              $("#errors").html("<div class='msg error'><h4>Error!</h4>You failed to authenticate! Please check your username and password!</div>");
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
                            <i class="fa fa-users fa-2x"></i>
                            <i class="fa fa-search fa-2x"></i>
                            <a href="index.php"><i class="fa fa-home fa-2x"></i></a>
                            <a href="friend_requests.php"><i class="fa fa-user-plus fa-2x"></i></a>
                            <a href="settings.php"><i class="fa fa-gear fa-2x"></i></a>
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
  <div id="errors">
  </div>
</div>



<script>
	$(document).foundation();
</script>

  </body>
</html>