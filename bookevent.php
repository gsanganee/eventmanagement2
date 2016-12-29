<?php
session_start();
$bleh = $_SESSION["name"];
//date_default_timezone_set('Australia/Melbourne');
//$date = date('m/d/Y', time());
$output = NULL;
if(isset($_POST['submit'])){

 
$db = new PDO("mysql:dbname=eventmanagement", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$search = $_POST['search'];

 
             //$query = $db->prepare('SELECT eventid,description,location,date,category,numberoftickets,enddate FROM event');
$query = $db->query("SELECT * FROM event WHERE description = '$search'");
//$query->execute();

//if (numberoftickets == 0){
//	$delete = $db->exec("DELETE * FROM event WHERE description = '$search'") ;
//}
//if end date is before current date, display "time over for this sale?" .... else while...
while ($row = $query->fetch(PDO::FETCH_ASSOC))
{
	$id = $row['eventid'];
	print_r($row);
	echo  "<td><a href='herth.php?id=$id'>Book</a></td>";
	//echo  "<td>" . " <input type='submit' id= '$id' . ' value='Book' >" .  "</td>";
	print_r('<br/>');
//$title = $row['description'];
//$greg = $row['location'];
}
}
//$fetch = $query->fetch();
 //echo $title;
 //echo $greg;
//
if(isset($_POST['submit3'])){
	$db = new PDO("mysql:dbname=eventmanagement", "root", "");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$search2 = $_POST['search2'];
$search3 = $_POST['search3'];
$query2 = $db->query("SELECT * FROM event WHERE date between '$search2' and '$search3'");
while ($row2 = $query2->fetch(PDO::FETCH_ASSOC))
{
	$id = $row2['eventid'];
	print_r($row2);
	echo  "<td><a href='herth.php?id=$id'>Book</a></td>";
	print_r('<br/>');
}
}

 
?>

<form method="POST">
<input type="TEXT" name="search" />
<input type="SUBMIT" name="submit" value="Search" />
</form>

<form method="POST">
<input type="TEXT" name="search2" />
<input type="TEXT" name="search3" />
<input type="SUBMIT" name="submit3" value="Search3" />
</form>

<?php echo $output; ?>