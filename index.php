<?php
session_start();
$cur_directory = preg_split('/(\/|\\?)/', getcwd());
$cur_directory = $cur_directory[count($cur_directory)-1];

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
      //ga('set', '&uid', "<?php echo $_SESSION['username']; ?>"); // Set the user ID using signed-in user_id.
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
            var days_checked = [$("#sunday").is(':checked'), $("#monday").is(':checked'), $("#tuesday").is(':checked'), $("#wednesday").is(':checked'), $("#thursday").is(':checked'), $("#friday").is(':checked'), $("#saturday").is(':checked')];
            // woopra.track("add_availability", {
            //     sunday: $("#sunday").is(':checked'),
            //     monday: $("#monday").is(':checked'),
            //     tuesday: $("#tuesday").is(':checked'),
            //     wednesday: $("#wednesday").is(':checked'),
            //     thursday: $("#thursday").is(':checked'),
            //     friday: $("#friday").is(':checked'),
            //     saturday: $("#saturday").is(':checked'),
            //     start_time: $("#starttime").val(),
            //     end_time: $("#endtime").val(),
            // });
            ga('send', {
              'hitType': 'event',          // Required.
              'eventCategory': 'button',   // Required.
              'eventAction': 'click',      // Required.
              'eventLabel': 'add_availability'
            });

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

            $.post("functions.php",{
            action: "get_availability",
            username: "<?php echo $_SESSION['username']; ?>",

            },
            function(data) {
                $("#availabilitytable").empty().append(data);
                if(days_checked[0]){
                    $(".day_Sunday").parent().find(".availabilityTimes").slideToggle("fast");
                }
                if(days_checked[1]){
                    $(".day_Monday").parent().find(".availabilityTimes").slideToggle("fast");
                }                
                if(days_checked[2]){
                    $(".day_Tuesday").parent().find(".availabilityTimes").slideToggle("fast");
                }                
                if(days_checked[3]){
                    $(".day_Wednesday").parent().find(".availabilityTimes").slideToggle("fast");
                }                
                if(days_checked[4]){
                    $(".day_Thursday").parent().find(".availabilityTimes").slideToggle("fast");
                }                
                if(days_checked[5]){
                    $(".day_Friday").parent().find(".availabilityTimes").slideToggle("fast");
                }                
                if(days_checked[6]){
                    $(".day_Saturday").parent().find(".availabilityTimes").slideToggle("fast");
                }
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
            $("#" + username).find(".person_availability").toggle();
            $("#" + username).find(".person_availability").html(data);

        });
    });

    $(document).on('click', '.delete_availability', function(evt){
        evt.preventDefault();
        // woopra.track("removed_availability", {
        //     sched_id: $(this).data('schedule_row_id')
        // });
        ga('send', {
          'hitType': 'event',          // Required.
          'eventCategory': 'button',   // Required.
          'eventAction': 'click',      // Required.
          'eventLabel': 'delete_availability',
          'eventValue': $(this).data('schedule_row_id')
        });
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
        ga('send', {
          'hitType': 'event',          // Required.
          'eventCategory': 'button',   // Required.
          'eventAction': 'click',      // Required.
          'eventLabel': 'add_group',
          'eventValue': $(this).data('group_id')
        });
        // woopra.track("added_group", {
        //     gid : $(this).data('group_id')
        // });
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
            // woopra.track("click_view_homepage", {});
            $.post("functions.php",{
                action: 'get_all_current_available',
             },
            function(data) {
                $("#main_content").html(data);
            });
        });

        $("#settings").click(function(evt){
            evt.preventDefault();
            ga('send', 'pageview', {
              'page': '/dev-time-space/settingspage.php',
              'title': 'settingspage'
            });
            //woopra.track("click_view_settings_page", {});
            $.post("settingspage.php",{

             },
            function(data) {
                $("#main_content").empty().append(data);
            });

            $.post("functions.php",{
            action: "get_availability",
            username: "<?php echo $_SESSION['username']; ?>",

             },
            function(data) {
                $("#availabilitytable").empty().append(data);
            });

        });

        $("#groups").click(function(evt){
            evt.preventDefault();
            ga('send', 'pageview', {
              'page': '/dev-time-space/groups.php',
              'title': 'groups'
            });
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
