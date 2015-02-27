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
    <script src='validate.js'></script>

    <script>



    $(document).on('click', '#availability', function(evt){
        evt.preventDefault();
        $.post("functions.php",{
            action: "get_availability",
            username: "<?php echo $_SESSION['username']; ?>",

         },
        function(data) {
            $("#availabilitytable").html(data);
        });
    });

    $(document).on('click', '.dayOfWeek', function(evt){
        evt.preventDefault();
        var buttoncolor = $(this).css("background-color");
        $(this).find(".availabilityTimes").slideToggle("fast");
        
        if($(this).find(".fa").hasClass("fa-caret-down")){
            $(this).find(".fa").removeClass("fa-caret-down").addClass("fa-caret-left");
        }else{
            $(this).find(".fa").removeClass("fa-caret-left").addClass("fa-caret-down");
        }
        /*if(buttoncolor == "rgb(246, 246, 246)"){
            $(this).css("background-color", "white");
        }else{
            $(this).css("background-color", "#F6F6F6");
        }*/
    });

    $(document).on('click', '#submittime', function(evt){
        evt.preventDefault();
        if(validateForm())
        {
            $.post("functions.php",{
                action: 'add_availability',
                sunday: $("#sunday").is(':checked'),
                monday: $("#monday").is(':checked'),
                tuesday: $("#tuesday").is(':checked'),
                wednesday: $("#wednesday").is(':checked'),
                thursday: $("#thursday").is(':checked'),
                friday: $("#friday").is(':checked'),
                saturday: $("#saturday").is(':checked'),
                start_time: $("#starttime").val(),
                end_time: $("#endtime").val(),
             },
            function(data) {
                $("#availabilitytable").html(data);
            });

            $.post("settingspage.php",{

             },
            function(data) {
                $("#main_content").html(data);
            });
        }
    });

    $(document).on('click', '#add_more_groups', function(evt){
        evt.preventDefault();
        $.post("functions.php",{
            action : 'add_more_groups',
         },
        function(data) {
            $("#main_content").html(data);
        });
    });

    $(document).on('click', '.group_tag a', function(evt){
        evt.preventDefault();
        $(this).parent().parent().hide("slow");
        $.post("functions.php",{
            action : 'remove_from_group',
            gid : $(this).data('group_id'),

        },
        function(data) {
            
        });
    });

    $(document).on('click', '.profile_pics', function(evt){
        evt.preventDefault();
        var username = $(this).data('username');
        $.post("functions.php",{
            action : 'get_availability',
            username : $(this).data('username'),
         },
        function(data) {
            $("#" + username).find(".person_availability").html(data);
        });
    });

    $(document).on('click', '.delete_availability', function(evt){
        evt.preventDefault();
        $(this).parent().hide("slow");
        $.post("functions.php",{
            action : 'delete_availability',
            sched_id: $(this).data('schedule_row_id'),
         },
        function(data) {
            
        });
    });

    $(document).on('click', '.group_tag h4', function(evt){
        evt.preventDefault();
        $.post("functions.php",{
            action : 'get_all_group',
            gid : $(this).data('group_id'),

         },
        function(data) {
            $("#main_content").html(data);
        });
    });

    $(document).on('click', '.add_group_tag h4', function(evt){
        evt.preventDefault();
        $(this).parent().parent().hide("slow");
        $.post("functions.php",{
            action : 'add_a_group',
            gid : $(this).data('group_id'),

         },
        function(data) {
            if(data)
            {
                alert("Added Group!");
            }
        });
    });


    $(document).ready(function(){
        $.post("functions.php",{
            action: 'get_all_current_available',
         },
        function(data) {
            $("#main_content").html(data);
        });

        $("#home").click(function(evt){
            evt.preventDefault();
            $.post("functions.php",{
                action: 'get_all_current_available',
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
