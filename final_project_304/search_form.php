<?php require "login_partial.php"; ?>

<?php

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if ($mysqli->connect_errno) {
		echo "MySQL Connection Error: ";
		echo $mysqli->connect_error;
		exit();
	}

	$mysqli->set_charset('utf8');

	$sql_categories = "SELECT * FROM categories;";
	$results_categories = $mysqli->query($sql_categories);
	if (!$results_categories) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	$sql_hours = "SELECT * FROM hours;";
	$results_hours = $mysqli->query($sql_hours);
	if (!$results_hours) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	$sql_price_ranges = "SELECT * FROM price_ranges;";
	$results_price_ranges = $mysqli->query($sql_price_ranges);
	if (!$results_price_ranges) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}
	
	$mysqli->close();
	
?>

<!DOCTYPE html>
<html>
<head>
	<title> The LA Explorer | Browse </title>

	<?php require "head.html"; ?>

	<!-- CSS -->
	<link rel="stylesheet" href="css/form.css">

	<!-- Description -->
	<meta name="description" content="">
</head>
<body>

	<?php require "nav.html"; ?>

	<section>

	<ul class="breadcrumb">
		<li><a href="index.php"> Home </a></li>
		<li> Search </li>
	</ul>

	<div class="form-wrap add-edit-search">
		
	<form action="search_results.php" method="GET">
		<div class="form-row">
			<label for="attraction-id"> Attraction: </label>
			<input type="text" id="attraction-id" name="attraction">
		</div>

		<div class="form-row">
			<label for="category-id"> Category: </label>
			<span class="select-css">
			<select name="category_id" id="category-id">
				<option value="" selected> --- All --- </option>
				<?php while ($row = $results_categories->fetch_assoc()): ?>
					<option value="<?php echo $row['id']; ?>">
						<?php echo $row['category']; ?>
					</option>
				<?php endwhile; ?>
			</select>
			</span>
		</div>

		<div class="form-row">
			<label for="hours-id"> Hours: </label>
			<span class="select-css">
			<select name="hours_id" id="hours-id">
				<option value="" selected> --- All --- </option>
				<?php while ($row = $results_hours->fetch_assoc()): ?>
					<option value="<?php echo $row['id']; ?>">
						<?php echo $row['hours']; ?>
					</option>
				<?php endwhile; ?>
			</select>
			</span>
		</div>

		<div class="form-row">
			<label for="price-range-id"> Price Range: </label>
			<span class="select-css">
			<select name="price_range_id" id="price-range-id">
				<option value="" selected> --- All --- </option>
				<?php while ($row = $results_price_ranges->fetch_assoc()): ?>
					<option value="<?php echo $row['id']; ?>">
						<?php echo $row['price_range']; ?>
					</option>
				<?php endwhile; ?>
			</select>
			</span>
		</div>

		<div class="form-row button-row">
			<button type="submit" class="button red-button"> Search </button>
			<button type="reset" class="button white-button"> Clear </button>
		</div>
	</form>

	</div>

	</section>

	<?php require "footer.html"; ?>

</body>
</html>