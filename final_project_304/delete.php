<?php require "login_partial.php";

	if (empty($_SESSION['logged_in'])) {

		$error = "You do not have permission to access this page.";
		header('Location: index.php');

	} else if (empty($_GET['attraction_id'])) {

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

		$sql_existing = "SELECT * FROM attractions
						WHERE id = '$attraction_id';";

		$results_existing = $mysqli->query($sql_existing);

		if(!$results_existing) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		$row_existing = $results_existing->fetch_assoc();

		if ($results_existing->num_rows == 0) {

			$error = "The attraction has already been deleted.";

		} else if ($row_existing['created_by'] != $_SESSION['user_id'] && empty($_SESSION['is_admin'])) {

			$error = "You do not have permission to access this page.";

		} else {

			$sql_favorites = "DELETE FROM favorites
								WHERE attraction_id = $attraction_id;";

			$results_favorites = $mysqli->query($sql_favorites);

			if (!$results_favorites) {
				echo $mysqli->error;
				$mysqli->close();
				exit();
			}
			
			$sql = "DELETE FROM attractions
				WHERE id = $attraction_id;";

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
	<title> The LA Explorer | Delete </title>

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
				<p class="back"><a href="index.php"> Go to Home Page </a></p>

			</div>

		<?php else: ?>

			<div class="space-fill">
			
				<p><span class="required"><?php echo $row_existing['name']; ?></span> has been successfully deleted. </p>
				<p class="back"><a href="index.php"> Go to Home Page </a></p>

			</div>

		<?php endif; ?>

	</div>

	</section>

	<?php require "footer.html"; ?>

</body>
</html>