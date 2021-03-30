<?php

	require "config/config.php";

	if (empty($_SESSION['logged_in'])) {

		if (isset($_POST['username']) && isset($_POST['password'])) {
			
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

			if ($mysqli->connect_errno) {
				echo $mysqli->connect_error;
				exit();
			}

			$username = $_POST['username'];
			$password = $_POST['password'];
			$password = hash(PASSWORD_HASH, $password);

			$sql_login = "SELECT * FROM users
					WHERE username LIKE '$username'
					AND password = '$password';";

			$results_login = $mysqli->query($sql_login);

			if(!$results_login) {
				echo $mysqli->error;
				$mysqli->close();
				exit();
			}

			$row_login = $results_login->fetch_assoc();

			if (empty($_POST['username']) || empty($_POST['password'])){ 
				$errorLogin = "Please enter your credentials.";
			} else if ($results_login->num_rows == 1) {
				$_SESSION['logged_in'] = true;
				$_SESSION['username'] = $_POST['username'];
				$_SESSION['user_id'] = $row_login['id'];

				if ($row_login['is_admin'] == 1) {
					$_SESSION['is_admin'] = true;
				}

				header('Location: index.php');
			} else {
				$errorLogin = "Invalid login.";
			}

			$mysqli->close();

		}
	}

	if (!empty($_GET['logout'])) {
		session_destroy();
		header('Location: index.php');
	}

?>