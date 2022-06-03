<?php 

$servername = "192.168.33.4";
$username = "db";
$password = "!aAtpc2019";
$rootname = "posts_automation";

// Create connection
$conn = new mysqli($servername, $username, $password,$rootname);

$servername1 = "192.168.33.4";
$username1 = "db";
$password1 = "!aAtpc2019";
$rootname1 = "postahrmis";
$conn2 = new mysqli($servername1, $username1, $password1,$rootname1);

// Check connection
// if ($conn->connect_error) {

// echo "Not Successfully";

// }else{
// 	echo "Successfully";
// }
?>