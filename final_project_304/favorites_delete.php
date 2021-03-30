<?php require "login_partial.php"; ?>

<?php

	if (empty($_SESSION['logged_in'])) {

		$error = "Please log in to edit your favorites.";
		
	} else if (empty($_GET['attraction_id']) || empty($_GET['attraction']) || empty($_SESSION['user_id'])) {

		$error = "Invalid page.";

	} else {

		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if ($mysqli->connect_errno) {
			echo "MySQL Connection Error: ";
			echo $mysqli->connect_error;
			exit();
		}

		$mysqli->set_charset('utf8');

		$attraction_id = $_GET['attraction_id'];
		$user_id = $_SESSION['user_id'];

		$sql = "DELETE FROM favorites
				WHERE user_id = $user_id
				AND attraction_id = $attraction_id;";

		$results = $mysqli->query($sql);

		if (!$results) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		$mysqli->close();

	}

?>

<!DOCTYPE html>
<html>
<head>
	<title> The LA Explorer | Delete Confirmation </title>

	<?php require "head.html"; ?>

	<!-- CSS -->
	<link rel="stylesheet" href="css/favorites.css">

	<!-- Description -->
	<meta name="description" content="">
</head>
<body>

	<?php require "nav.html"; ?>

	<div class="form-wrap">

		<?php if (!empty($error)): ?>

			<div class="space-fill required">
				<p><?php echo $error; ?></p>
				<p class="back"><a href="favorites.php"> Back to Favorites </a></p>
			</div>

		<?php else: ?>

			<div class="space-fill">
				<p><span class="required"><?php echo $_GET['attraction']; ?></span> has been successfully removed from your favorites. </p>
				<p class="back"><a href="favorites.php"> Back to Favorites </a></p>
			</div>

		<?php endif; ?>

	</div>

	<?php require "footer.html"; ?>

</body>
</html>