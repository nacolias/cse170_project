<?php
session_start();
session_unset();
session_destroy();

header("Location:http://nacolias.ucsd.edu/time-space/login.php");
?>