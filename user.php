<?php

require_once 'login.php';

// error_log("Starting out")
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

$customer = array();
$data = array();

/******************************************************************************/
// Functions & Exception Handlers
/******************************************************************************/
// Note: this is redefining the standard php error handler.
set_exception_handler(function ($e) {
	$code = $e->getCode() ?: 400;
	header("Content-Type: application/json", NULL, $code);
	echo json_encode(["error" => $e->getMessage()]);
	exit;
});

/******************************************************************************/
/* Check every parameter that was passed in																		*/
/******************************************************************************/

function check_parameters($array) {
	global $customer;

	$valid = True;

	if (!isset($array["first_name"]))
		$valid = False;
	else
			$customer[0] = $array["first_name"];

	if (!isset($array["last_name"]))
				$valid = False;
	else
			$customer[1] = $array["last_name"];

	if (!isset($array["email"]))
				$valid = False;
	else
			$customer[2] = $array["email"];
	if (!isset($array["password"]))
				$valid = False;
	else
			$customer[3] = $array["password"];



	return $valid;
}

function create_user($cust) {
	global $conn;

	// TODO:
	//
	// N.B: This code does not check whether there is already an
	// account with this email address. That needs to be done.
	//
	// Neither does this code  use mysql transactions. When using a transaction you
	// can guarantee that everything in the transaction set is successful or that
	// everything remains as it was.
	//

	// First check whether the address exists.
	// I have just used the postal_code and the first line of the address.


			// Now create the customer in the customer table

			// This code does not populate the following field in the customer table
			// because in this class example we don't need them:
			// 			 - active: indicates whether the customer is an active customer.
			// We have to insert a store_id because it is a foreign key for the store
			// table in the sakila database.
			// error_log("Adding a customer");

		  $query = "INSERT INTO user (id, username, password, email, first_name, last_name)
			VALUES (NULL, '$cust[2]', '$cust[3]', '$cust[2]', '$cust[0]', '$cust[1]')";

			$result = $conn->query($query);

			if (!$result) throw new Exception("Error from database creating customer" . $conn->error);


			// return some of the fields of the customer object we have just created.
			return customer_to_json($cust[0], $cust[1], $cust[2]);

}


// Format a customer as a JSON object composed of key:value pairs
function customer_to_json($first_name, $last_name, $email){
	// error_log("Customer: first_name, last_name, email: ", $first_name, $last_name, $email);
	return array('first_name' => $first_name, 'last_name' => $last_name, 'email' => $email);
}


/******************************************************************************/
// main
/******************************************************************************/

// handle requests by verb and path
$verb = $_SERVER['REQUEST_METHOD'];
$url_pieces = explode('/', $_SERVER['PATH_INFO']);

// catch this here, we don't support many routes yet
if($url_pieces[1] != 'user') {
	throw new Exception('Unknown endpoint', 404);
}

// If we are creating a new user, check the parameters passed
if ($verb == 'POST'){
			if (!check_parameters($_POST)) {
				throw new Exception("Data missing or invalid");
			}
}

switch($verb) {
	case 'GET':
		// No code here yet
		break;
	case 'POST':
		$data = create_user($customer);
		// error_log("Created customer");
		break;
	case 'DELETE':
		// No code here yet
		break;
	default:
		throw new Exception('Method Not Supported', 405);
}



// We've finished with the database connection now, close it.

$conn->close();

// Return JSON to the calling script
header("Content-Type: application/json", NULL, 200);
$response_data = array('first_name' => $customer[0], 'last_name' => $customer[1]);
print json_encode($response_data);

?>
