<?php
session_start();
session_unset();
session_destroy();
$cur_directory = preg_split('/(\/|\\?)/', getcwd());
$cur_directory = $cur_directory[count($cur_directory)-1];
header("Location: http://$_SERVER[HTTP_HOST]/" . $cur_directory . "/login.php");
?>