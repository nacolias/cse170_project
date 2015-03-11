<?php 
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

$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']); 

// make a note of the location of the upload handler script 
$uploadHandler = 'http://' . $_SERVER['HTTP_HOST'] . $directory_self . 'upload.processor.php'; 

// set a max file size for the html upload form 
$max_file_size = 10000000; // size in bytes 

// now echo the html page 
$fname = '';
$lname = '';
$major = '';
$phone_number = '';
$img_directory = '';

$userinfo_query_result = $dbconn->query('select * from people where username="' . $_SESSION['username'] . '"') or die("Error getting user info");
while($row = $userinfo_query_result->fetch_assoc())
{
    $fname = $row['fname'];
    $lname = $row['lname'];
    $major = $row['major'];
    $phone_number = $row['phone_number'];
    $img_directory = $row['img_directory'];
}



?>

<!doctype html>
<html class="no-js" lang="en">
  <head>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-60450403-1', { 'userId' : "<?php echo $_SESSION['username']; ?>"});
      ga('send', 'pageview');

    </script>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Time Space</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script>
    <link rel="stylesheet" href="img/font-awesome-4.3.0/css/font-awesome.css">
    <link rel="stylesheet" href="css/timespace.css">
    
    <script src="js/jquery-2.1.3.min.js"></script>

  <script>
  $(document).ready(function(){

    $("#submitinfo").click(function(evt){
      evt.preventDefault();
      $.post("functions.php",{
        action : 'update_info',
        fname : $("#fname").val(),
        lname : $("#lname").val(),
        major : $("#major option:selected").text(),
        phone_number : $("#phone").val(),
        img_directory : $("#img_directory").val(),
       },
      function(data) {
          alert("Success!");
          console.log(data);
          window.location.replace("index.php");
      });
      
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
                <a href="index.php">
                  <i id="home" class="fa fa-home fa-2x"></i>
                </a>
            </center>
          </div>
        </div>
        </nav> 
  </div>
	<!--End Nav-->

  <!--Initial Set up Information Form-->
  <div class="person">
    <div class="row">
      <center><h1>Profile Settings</h1></center>
    </div>

    <div>
      <div class="row">
        <div class="small-centered columns">
          <input type="text" name="firstName" id="fname" <?php if($fname != '') echo "value='$fname'"; ?> placeholder="First name"/>
        </div>
        
      </div>
     
      <div class="row">
        <div class="small-centered columns">
          <input type="text" name="lastName" <?php if($lname != '') echo "value='$lname'"; ?> id="lname" placeholder="Last name"/>
        </div>
      </div>

      <div class="row">
        <!--
        <div class="small-6 columns left">
          <select id="school_year">
            <option value="blankYear">Select Year</option>
            <option value="first">1st</option>
            <option value="second">2nd</option>
            <option value="third">3rd</option>
            <option value="fourth">4th</option>
            <option value="fifth">5th</option>
            <option value="sixth">6th</option>
          </select>
        </div>
        -->
        <div class="small-centered columns">
          <select id='major'>
            <option value="blankYear">Select Major</option>
            <?php
              $major_array = array('ANTH','BENG','BIO','CHEM','COGS','COMM','CSE','ECON','EDS','ECE','ETHN','FPM','GLBH','HIST','LANG','LING','LIT','MATH','MAE','MUS','NANO','PHIL','PHYS','POLI','PSYC','SIO','SOCI','SE','VIS');
              foreach($major_array as $tmp_major)
              {
                if($major==$tmp_major)
                {
                  echo "<option selected value='$tmp_major'>$tmp_major</option>";
                }
                else
                {
                  echo "<option value='$tmp_major'>$tmp_major</option>";
                }
              } 
            ?>
          </select>
        </div>
      </div>

      <div class="row">
        <div class="small-6 columns left">
          <input id='phone' <?php if($phone_number != '') echo "value='$phone_number'"; ?> type="text" name="phoneNumber" placeholder="Phone number(for SMS)"/>
        </div>

        <div class="small-6 columns left">
          <input id="img_directory" type="text" name="img_directory" <?php if($img_directory != '') echo "value='$img_directory'";?> placeholder="Profile Picture Image Link (http://test.com/img.jpg)">
        </div>
      </div>

      <div class="row">
        <div class="small-6 small-centered columns">
          <center>
            <input class="button" id="submitinfo" type="submit" name="submit" value="Submit">
          </center>
        </div>
      </div>

    </div>

  </div>





<script src="js/vendor/jquery.js"></script>
<script src="js/foundation.min.js"></script>
<script>
  $(document).foundation();
</script>

  </body>
</html>
