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
							<i class="fa fa-search fa-2x"></i>
							<i class="fa fa-home fa-2x"></i>
							<i class="fa fa-user-plus fa-2x"></i>
							<i class="fa fa-gear fa-2x"></i>
						</center>
					</div>
				</div>
	    	</nav> 
	</div>
    <!--Main Body-->
    <div id="main_body">
        <!--SPACER-->
        <div class="row">
            <div class="small-centered small-10 columns">
                <hr />
            </div>
        </div>
        <!--PEOPLE-->
     	<div class="person">
            <div class="row">
                <div class="small-centered small-8 columns">
                    <div class="small-4 columns">
                        <h4 class="text-left">Tim Holloway</h4>
                    </div>
                    <div class="small-4 columns">
                        <h4 class="text-right">Age:24 CSE</h4>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="small-centered small-8 columns profilePic">
                    <img src="img/guy2.jpg" />
                </div>
            </div>
            <div class="row">
                <div class="small-centered small-8 columns">
                    <p class="message">Hey! I saw that we are both in the same class and was wondering if you want to meet up sometime to study before one of the $#($ing midterms.</p>
                </div>
            </div>
            
            <div class="row">
                <div class="small-centered small-8 columns">
<!--                    <ul class="stack button-group even-2">
                            <li><a href="#" class="button expand alert">DENY</a></li>
                            <li><a href="#" class="button expand success">ACCEPT</a></li>
                        </ul> -->
                        <a href="#" class="small round button success left" style="width:45%">Accept</a>
                        <a href="#" class="small round button alert right" style="width:45%">Deny</a>

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
