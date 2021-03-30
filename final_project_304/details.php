<?php require "login_partial.php"; ?>

<?php

	if (empty($_GET['id'])) {

		$error = "Invalid page.";

	} else {

		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if ($mysqli->connect_errno) {
			echo "MySQL Connection Error: ";
			echo $mysqli->connect_error;
			exit();
		}

		$mysqli->set_charset('utf8');

		$sql = "SELECT name, categories.category as category, address, website, description, price_ranges.price_range as price, img_link, hours.hours as hours, attractions.id as id, created_by
			FROM attractions
			LEFT JOIN categories
				ON attractions.category_id = categories.id
			LEFT JOIN price_ranges
				ON attractions.price_range_id = price_ranges.id
			LEFT JOIN hours
				ON attractions.hours_id = hours.id
			WHERE attractions.id = " . $_GET['id'] . ";";

		$results = $mysqli->query($sql);

		if ( !$results ) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		$row = $results->fetch_assoc();
		
		$mysqli->close();

	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<title> The LA Explorer | Information </title>

	<?php require "head.html"; ?>

	<!-- CSS -->
	<link rel="stylesheet" href="css/details.css">

	<!-- Description -->
	<meta name="description" content="">
</head>
<body>

	<?php require "nav.html"; ?>


	<section>
		<ul class="breadcrumb">
			<li><a href="search_form.php"> Search </a></li>
			<li><a href="search_results.php"> Search Results </a></li>
			<li> Details </li>
		</ul>

		<div id="attraction-details">

			<?php if (!empty($error)): ?>

				<div class="space-fill required">
					<p><?php echo $error; ?></p>
					<p class="back"><a href="index.php"> Go to Home Page </a></p>
				</div>

			<?php else: ?>

				<h1> <?php echo $row['name']; ?> </h1>

				<div class="tags">
					<span class="tag-category">
						<?php echo $row['category']; ?>
					</span>
					<span class="tag-price">
						<?php echo $row['price']; ?>
					</span>
					<span class="tag-hours">
						<?php echo $row['hours']; ?>
					</span>
				</div>

				<div class="img-wrap">
					<img src="<?php echo $row['img_link']; ?>" alt="<?php echo $row['name']; ?>">
				</div>

				<p class="description">
					<?php echo $row ['description']; ?>
				</p>

				<p>
					<span class="emphasis"> Address</span>: <?php echo $row['address']; ?>
				</p>

				<p>
					<span class="emphasis"> Price</span>: <?php echo $row['price']; ?>
				</p>

				<p>
					<span class="emphasis"> Hours</span>: <?php echo $row['hours']; ?>
				</p>

				<p>
					Visit the <a href="<?php echo $row['website']; ?>" target="_blank" class="website-link"> official website </a> for more details.
				</p>

				<?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>

					<div class="functionality">
						<a class="button details-button" href="favorites.php?attraction_id=<?php echo $row['id']; ?>"> Favorite </a>

						<?php if (isset($_SESSION['is_admin']) || $row['created_by'] == $_SESSION['user_id']): ?>

							<a class="button details-button" href="delete.php?attraction_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete \'<?php echo $row['name']; ?>\'?');"> Delete </a>
							<a class="button details-button" href="edit_form.php?id=<?php echo $row['id']; ?>"> Edit </a>

						<?php endif; ?>

					</div>

				<?php else: ?>

					<p class="login-more"><a href="#ex1" rel="modal:open" class="website-link">Login</a> for more </p>

				<?php endif; ?>

				<div class="back">
					<a href="search_results.php"> Back to Search Results &rarr; </a>
				</div>

			<?php endif; ?>

		</div>
	</section>


	<?php require "footer.html"; ?>

</body>
</html>