<?php
session_start();
$bleh = $_SESSION["name"];
$myText = (string)$bleh;
$description = $_POST["description"];
$location = $_POST["location"];
$date = $_POST["date"];
$category = $_POST["category"];
$numberoftickets = $_POST["numberoftickets"];
$enddate = $_POST["enddate"];
$db = new PDO("mysql:dbname=eventmanagement", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$result = $db->exec("INSERT INTO event(eventid, emails, description, location, date, category, numberoftickets, enddate) VALUES(NULL, '$myText', '$description', '$location', '$date', '$category', '$numberoftickets', '$enddate')");
//$results = $result->fetchALL(PDO::FETCH_ASSOC);
//print_r($results);

//(“INSERT INTO event(eventid, user_id, description, location, date, category, numberoftickets, enddate) VALUES(NULL, '1, 'yukuy','yuk','2012-04-01','uyk','12','2012-04-01')”);
//echo "The name you typed isregreg:";
/*$event = array();
$id = $_SESSION['user_id'];

set_exceptions_handler(function($e){
	$code = $e->getCode() ?: 400;
	header("Content-Type: application/json", NULL, $code);
	echo json_encode(["error" => $e->getMessage()]);
	exit;
});
function check_parameters($array){
	global $event;
	$event[0] = $array["description"];
	$event[1] = $array["location"];
	$event[2] = $array["date"];
	$event[3] = $array["category"];
	$event[4] = $array["numberoftickets"];
	$event[5] = $array["enddate"];	
}

			function adddata($event){
			$db = new PDO("mysql:dbname=eventmanagement","root","");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$result = $db->exec("INSERT INTO event (event_id, user_id, description, location, date, category, numberoftickets, enddate)
				VALUES (NULL, '$id','$event[0]','$event[1]','$event[2]','$event[3]','$event[4]','$event[5]')");
			}*/
?>


