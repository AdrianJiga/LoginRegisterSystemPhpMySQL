<?php

//parameters needed to connect to a database
$dbHost = "localhost";
$dbUser = "root";
$dbPass = ""; //no password
$dbName = "phptutorial"; //database name

//connection to database
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

if (!$conn) {
  die("Database connection failed!");
}

 ?>
