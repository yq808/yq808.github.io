<?php require "login_partial.php"; ?>

<?php

	if (empty($_SESSION['logged_in']) && !isset($_SESSION['logged_in'])) {

		$error = "Please log in to see your favorites.";
		
	} else {

		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if ($mysqli->connect_errno) {
			echo "MySQL Connection Error: ";
			echo $mysqli->connect_error;
			exit();
		}

		$mysqli->set_charset('utf8');

		$user_id = $_SESSION['user_id'];

		if (!empty($_GET['attraction_id'])) {

			$attraction_id = $_GET['attraction_id'];

			$sql_existing = "SELECT * FROM favorites
							WHERE attraction_id LIKE '$attraction_id'
							AND user_id LIKE '$user_id';";

			$results_existing = $mysqli->query($sql_existing);

			if(!$results_existing) {
				echo $mysqli->error;
				$mysqli->close();
				exit();
			}

			if ($results_existing->num_rows >= 1) {

				$errorAttraction = "The attraction is already in your favorites.";

			} else {

				$sql_addfavorite = "INSERT INTO favorites (user_id, attraction_id)
									VALUES ($user_id, $attraction_id);";

				$results_addfavorite = $mysqli->query($sql_addfavorite);

				if (!$results_addfavorite) {
					echo $mysqli->error;
					$mysqli->close();
					exit();
				}

			}
		}

		$sql = "SELECT * FROM favorites
				LEFT JOIN users
					ON favorites.user_id = users.id
				LEFT JOIN attractions
					ON favorites.attraction_id = attractions.id
				LEFT JOIN categories
					ON attractions.category_id = categories.id
				LEFT JOIN price_ranges
					ON attractions.price_range_id = price_ranges.id
				LEFT JOIN hours
					ON attractions.hours_id = hours.id
				WHERE users.id = $user_id;";

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
	<title> The LA Explorer | Favorites </title>

	<?php require "head.html"; ?>

	<!-- CSS -->
	<link rel="stylesheet" href="css/favorites.css">

	<!-- Description -->
	<meta name="description" content="">
</head>
<body>

	<?php require "nav.html"; ?>

		<section>

			<?php if (!empty($error)): ?>
				
				<div class="space-fill required favorites-error">
					<p><?php echo $error; ?></p>
					<p class="back"><a class="website-link" href="#ex1" rel="modal:open"> Log In </a></p>

				</div>

			<?php else: ?>

			<h2> Favorites </h2>

			<?php if ($results->num_rows == 0): ?>

				<div class="space-fill favorites-error">
					<p> You currently do not have any attractions saved! Head over to <a class="website-link" href="search_form.php">browse</a> to explore. </p>
				</div>

			<?php else: ?>

				<?php if (!empty($errorAttraction)): ?>

					<div class="fail-popup">
						<p><?php echo $errorAttraction; ?></p>
						<a class="website-link" href="favorites.php"> Dismiss </a>
					</div>

				<?php endif; ?>

			<div id="favorites-results">

				<?php while ($row = $results->fetch_assoc()): ?>

					<div class="favorites-indiv">

						<div class="favorites-img">
							<img src="<?php echo $row['img_link']; ?>" alt="<?php echo $row['name']; ?>">
						</div>

						<div class="favorites-info">
							<span class="category">
								<?php echo $row['category']; ?>
							</span>
							<h4> <?php echo $row['name']; ?> </h4>
							<span>
								<?php echo $row['address']; ?>
							</span>
							<span>
								<?php echo $row['price_range']; ?>
							</span>
							<span>
								<?php echo $row['hours']; ?>
							</span>
							<span>
								<a href="<?php echo $row['website']; ?>">
									<?php echo $row['website']; ?>
								</a>
							</span>

						<div class="favorites-buttons">
							<span><a href="details.php?id=<?php echo $row['attraction_id']; ?>"> More Info </a></span>
							<span><a href="favorites_delete.php?attraction_id=<?php echo $row['attraction_id']; ?>&attraction=<?php echo $row['name']; ?>"> Remove </a></span>
						</div>

						</div>
					</div>

				<?php endwhile; ?>

			</div>

			<?php endif; ?>

			<?php endif; ?>

		</section>

	<?php require "footer.html"; ?>

</body>
</html>