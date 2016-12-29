<?php
session_start();
$bleh = $_SESSION["name"];
//date_default_timezone_set('Australia/Melbourne');
//$date = date('m/d/Y', time());

$db = new PDO("mysql:dbname=eventmanagement", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
             //$query = $db->prepare('SELECT eventid,description,location,date,category,numberoftickets,enddate FROM event');
$query = $db->query("SELECT * FROM usersevents WHERE emails = '$bleh'");


while ($row = $query->fetch(PDO::FETCH_ASSOC))
{
	$id = $row['eventid'];
	print_r($row);
	print_r('<br/>');
}


$date = date('Y-m-d');
$date2 = $db->query("SELECT date FROM event");

while ($roww = $date2->fetch(PDO::FETCH_ASSOC))
{
	//print_r($roww);
	//echo gettype($roww);
	//print_r($date);
	//print_r($roww);
	foreach($roww as $btrb){
if($date>$btrb){
	$query3 = $db->exec("DELETE FROM event WHERE date = '$btrb'");
}
}
}

//$tickets = $db->query("SELECT numberoftickets FROM event");

//while ($rowww = $tickets->fetch(PDO::FETCH_ASSOC))
//{
	//print_r($roww);
	//echo gettype($roww);
	//print_r($date);
	//print_r($rowww);
	//foreach($rowww as $btrbb){
//if($btrbb == 0){
	$query4 = $db->exec("DELETE FROM event WHERE numberoftickets = 0");

/* USE THIS TO SEND EMAILS
$message = 'you have an event coming up soon!';

$queryt = $db->query("SELECT date FROM usersevents");	
while ($rowwt = $queryt->fetch(PDO::FETCH_ASSOC))
{
	//print_r($roww);
	//echo gettype($roww);
	//print_r($date);
	//print_r($rowwt);
	foreach($rowwt as $btrby){
		//print_r ($btrby);

	if($date == $btrby){
	$query5 = $db->query("SELECT emails FROM usersevents WHERE date = '$btrby'");
	while ($rowwtt = $query5->fetch(PDO::FETCH_ASSOC)){
		foreach($rowwtt as $bret){			
	mail('$bret', 'Upcoming event', $message);
}
}
}
}
}*/

//}
//}
//}



// if date == now()... send email function
 
?>