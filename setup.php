<?php 

$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']); 

// make a note of the location of the upload handler script 
$uploadHandler = 'http://' . $_SERVER['HTTP_HOST'] . $directory_self . 'upload.processor.php'; 

// set a max file size for the html upload form 
$max_file_size = 10000000; // size in bytes 

// now echo the html page 
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
                <ul class="title-area">
                  <li class="name">
                    <center><h1>Timespace</h1></center>
                </ul>
            </nav> 
    </div>
	<!--End Nav-->

  <!--Initial Set up Information Form-->
  <div class="person">
    <div class="row">
      <center><h1>Profile Settings</h1></center>
    </div>

    <form id="Upload" action="<?php echo $uploadHandler ?>" enctype="multipart/form-data" method="post">
      <div class="row">
        <div class="small-6 columns left">
          <input type="text" name="firstName" placeholder="First name"/>
        </div>
        <div class="small-6 columns right">
          <input type="text" name="lastName" placeholder="Last name"/>
        </div>
      </div>

      <div class="row">
        <div class="small-6 columns left">
          <select>
            <option value="blankYear">Select Year</option>
            <option value="first">1st</option>
            <option value="second">2nd</option>
            <option value="third">3rd</option>
            <option value="fourth">4th</option>
            <option value="fifth">5th</option>
            <option value="sixth">6th</option>
          </select>
        </div>

        <div class="small-6 columns right">
          <select>
            <option value="blankYear">Select Major</option>
            <option value="anthropology">ANTH</option>
            <option value="bioengineering">BENG</option>
            <option value="biology">BIO</option>
            <option value="chemistry">CHEM</option>
            <option value="cognitive">COGS</option>
            <option value="communication">COMM</option>
            <option value="computerscience">CSE</option>
            <option value="economics">ECON</option>
            <option value="education">EDS</option>
            <option value="electrical">ECE</option>
            <option value="ethnic">ETHN</option>
            <option value="familymed">FPM</option>
            <option value="globalhealth">GLBH</option>
            <option value="history">HIST</option>
            <option value="language">LANG</option>
            <option value="linguistics">LING</option>
            <option value="literature">LIT</option>
            <option value="math">MATH</option>
            <option value="mae">MAE</option>
            <option value="music">MUS</option>
            <option value="nano">NANO</option>
            <option value="philosophy">PHIL</option>
            <option value="physics">PHYS</option>
            <option value="poli">POLI</option>
            <option value="pysch">PSYC</option>
            <option value="sio">SIO</option>
            <option value="sociology">SOCI</option>
            <option value="structural">SE</option>
            <option value="vis">VIS</option>
          </select>
        </div>
      </div>

      <div class="row">
        <div class="small-6 columns left">
          <input type="text" name="phoneNumber" placeholder="Phone number(for SMS)"/>
        </div>

        <div class="small-6 columns left">
          <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size ?>">
          <input id="file" type="file" name="file">
          <input id="submit" type="submit" name="submit" value="Upload me!">
        </div>

      </div>

    </form>

  </div>





<script src="js/vendor/jquery.js"></script>
<script src="js/foundation.min.js"></script>
<script>
  $(document).foundation();
</script>

  </body>
</html>
