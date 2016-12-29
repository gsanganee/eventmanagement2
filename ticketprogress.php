<?php
session_start();
$bleh = $_SESSION["name"];
//date_default_timezone_set('Australia/Melbourne');
//$date = date('m/d/Y', time());

$db = new PDO("mysql:dbname=eventmanagement", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
             //$query = $db->prepare('SELECT eventid,description,location,date,category,numberoftickets,enddate FROM event');
$query = $db->query("SELECT * FROM event WHERE emails = '$bleh'");




while ($row = $query->fetch(PDO::FETCH_ASSOC))
{
	$id = $row['eventid'];
	print_r($row);
	print_r('<br/>');
	$queryy = $db->query("SELECT emails FROM usersevents WHERE eventid = '$id'");
	while ($roww = $queryy->fetch(PDO::FETCH_ASSOC))
{
	print_r($roww);
	print_r('<br/>');
}
}




// if date == now()... send email function
 
?>