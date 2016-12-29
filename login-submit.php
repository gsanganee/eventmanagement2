<?php
			$name = $_GET["username"];
			$password = $_GET["password"];
			$data = array();


			// Note: I have set a session variable here. I haven't used it.
			// There might be a use for this later on.
			if (is_correct_user($name) && is_correct_password($password)) {
				session_start();							// Start session
				$_SESSION["name"] = $name;		// Set the name as a session variable
				header("Content-type: application/json");
				echo json_encode($data);
			} else {
				header("HTTP/1.1 404 File Not Found");
  			die("HTTP error 404 occurred: User not found ($name)");
			}

			/* query database to see if user typed the right username */
			function is_correct_user($name) {
				$db = new PDO("mysql:dbname=eventmanagement", "root", "");
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$rows = $db->query("SELECT first_name, last_name FROM user WHERE email = '$name'");
				if ($rows->rowCount() == 0) {
					return FALSE;
				}
				foreach ($rows as $row){
					global $data;
					$data = person_json($row["first_name"], $row["last_name"]);
				}
				return TRUE;
			}

			function is_correct_password($password) {
				$db = new PDO("mysql:dbname=eventmanagement", "root", "");
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$rowss = $db->query("SELECT first_name, last_name FROM user WHERE password = '$password'");
				if ($rowss->rowCount() == 0) {
					return FALSE;
				}	
				return TRUE;
			}

			// Format the JSON object as key:value pairs
			function person_json($first_name, $last_name){
				return array('first_name' => $first_name, 'last_name' => $last_name);
			}


?>
