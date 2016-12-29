<?php
session_start();
$bleh = $_SESSION["name"];
$myText = (string)$bleh;
$id = $_GET['id'];
$db = new PDO("mysql:dbname=eventmanagement", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query = $db->exec("INSERT INTO usersevents (eventid, emails, description, location, date, category, numberoftickets, enddate) 
									 SELECT eventid, '$myText', description, location, date, category, numberoftickets, enddate 
										FROM event 
										WHERE eventid = '$id'");
$update = $db->exec("UPDATE event SET numberoftickets = numberoftickets - 1 WHERE eventid = '$id'");

?>
