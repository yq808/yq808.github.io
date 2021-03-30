<?php require "login_partial.php"; ?>

<?php

	if (empty($_POST['username_register']) || empty($_POST['password_register']) || empty($_POST['email_register'])) {

		$error = "Please fill out all required fields.";
		
	} else {

		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if ($mysqli->connect_errno) {
			echo "MySQL Connection Error: ";
			echo $mysqli->connect_error;
			exit();
		}

		$mysqli->set_charset('utf8');

		$email = $_POST['email_register'];
		$username = $_POST['username_register'];
		$password = $_POST['password_register'];
		$password = hash(PASSWORD_HASH, $password);

		$sql_registered = "SELECT *
							FROM users
							WHERE email LIKE '$email'
							OR username LIKE '$username';";

		$results_registered = $mysqli->query($sql_registered);

		if(!$results_registered) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		if ($results_registered->num_rows >= 1) {
			$error = "This username or email already exists.";
		} else {
			$sql = "INSERT INTO users (username, password, email)
					VALUES ('$username', '$password', '$email');";

			$results = $mysqli->query($sql);

			if (!$results) {
				echo $mysqli->error;
				$mysqli->close();
				exit();
			}
		}

		$mysqli->close();
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title> The LA Explorer | Register Confirmation </title>

	<?php require "head.html"; ?>

	<!-- CSS -->
	<link rel="stylesheet" href="css/form.css">

	<!-- Description -->
	<meta name="description" content="">

</head>
<body>

	<?php require "nav.html"; ?>

	<section>

	<div class="form-wrap add-edit-search">

		<?php if (!empty($error)): ?>

			<div class="space-fill required">
				<p><?php echo $error; ?></p>
				<p class="back"><a href="register.php"> Back to Register </a></p>
			</div>

		<?php else: ?>
			
			<div class="space-fill">
				<p> Your account <span class="required"><?php echo $username ?></span> has been created. </p>
				<p><a href="#ex1" rel="modal:open" class="website-link"> Log In </a></p>
			</div>

		<?php endif; ?>

	</div>

	</section>

	<?php require "footer.html"; ?>

</body>
</html>