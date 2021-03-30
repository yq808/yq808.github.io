<?php require "login_partial.php";

	if (empty($_SESSION['logged_in'])) {

		$error = "You do not have permission to access this page.";
		header('Location: index.php');
		
	} else if (empty($_GET['id'])) {

		$error = "Invalid page.";

	} else {
		
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

		$id = $_GET['id'];

		$sql_attraction = "SELECT * FROM attractions
							WHERE id = $id;";

		$results_attraction = $mysqli->query($sql_attraction);
		if (!$results_attraction) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		$row_attraction = $results_attraction->fetch_assoc();

		if ($row_attraction['created_by'] != $_SESSION['user_id'] && empty($_SESSION['is_admin'])) {
			$error = "You do not have permission to access this page.";
		}
		
		$mysqli->close();
		
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<title> The LA Explorer | Edit </title>

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
		<li><a href="search_form.php"> Search </a></li>
		<li><a href="search_results.php"> Search Results </a></li>
		<li><a href="details.php?id=<?php echo $id; ?>"> Details </a></li>
		<li> Edit </li>
	</ul>

	<div class="form-wrap add-edit-search">

	<?php if (!empty($error)): ?>

		<div class="space-fill required">
			<p><?php echo $error; ?></p>
			<p class="back"><a href="index.php"> Go to Home Page </a></p>
		</div>

	<?php else: ?>

	<form action="edit_confirmation.php" method="POST" enctype="multipart/form-data">

		<input type="hidden" name="id" value="<?php echo $row_attraction['id']; ?>">

		<div class="form-row">
			<label for="attraction-id"> Attraction: <span class="required">*</span></label>
			<input type="text" id="attraction-id" name="attraction" value="<?php echo $row_attraction['name']; ?>">
		</div>

		<div class="form-row">
			<label for="category-id"> Category: <span class="required">*</span></label>
			<span class="select-css">
			<select name="category_id" id="category-id">
				<option value="" disabled> --- All --- </option>
				
				<?php while ($row = $results_categories->fetch_assoc()): ?>

					<?php if ($row['id'] == $row_attraction['category_id']): ?>
						
						<option value="<?php echo $row['id']; ?>" selected>
							<?php echo $row['category']; ?>
						</option>
					
					<?php else: ?>

						<option value="<?php echo $row['id']; ?>">
							<?php echo $row['category']; ?>
						</option>

					<?php endif; ?>

				<?php endwhile; ?>
			</select>
			</span>
		</div>

		<div class="form-row">
			<label for="address"> Address: <span class="required">*</span></label>
			<input type="text" id="address" name="address" value="<?php echo $row_attraction['address']; ?>">
		</div>

		<div class="form-row">
			<label for="website"> Website: <span class="required">*</span></label>
			<input type="text" id="website" name="website" value="<?php echo $row_attraction['website']; ?>">
		</div>

		<div class="form-row">
			<label for="description"> Description: <span class="required">*</span></label>
			<textarea id="description" name="description"><?php echo $row_attraction['description']; ?></textarea>
		</div>

		<div class="form-row">
			<label for="hours-id"> Hours: <span class="required">*</span></label>
			<span class="select-css">
			<select name="hours_id" id="hours-id">
				<option value="" disabled> --- All --- </option>
				
				<?php while ($row = $results_hours->fetch_assoc()): ?>

					<?php if ($row['id'] == $row_attraction['hours_id']): ?>

						<option value="<?php echo $row['id']; ?>" selected>
							<?php echo $row['hours']; ?>
						</option>

					<?php else: ?>
					
						<option value="<?php echo $row['id']; ?>">
							<?php echo $row['hours']; ?>
						</option>

					<?php endif; ?>
				
				<?php endwhile; ?>
			
			</select>
			</span>
		</div>

		<div class="form-row">
			<label for="price-range-id"> Price Range: <span class="required">*</span></label>
			<span class="select-css">
			<select name="price_range_id" id="price-range-id">
				<option value="" disabled> --- All --- </option>
			
				<?php while ($row = $results_price_ranges->fetch_assoc()): ?>

					<?php if ($row['id'] == $row_attraction['price_range_id']): ?>
					
						<option value="<?php echo $row['id']; ?>" selected>
							<?php echo $row['price_range']; ?>
						</option>

					<?php else: ?>

						<option value="<?php echo $row['id']; ?>">
							<?php echo $row['price_range']; ?>
						</option>

					<?php endif; ?>	
				
				<?php endwhile; ?>
			
			</select>
			</span>
		</div>

		<div class="form-row">
			<label for="img-link"> Image <span class="required">*</span></label>
			<div id="current-image">
				<span> Current image: </span>
				<img src="<?php echo $row_attraction['img_link']; ?>" alt="<?php echo $row_attraction['name']; ?>">
			</div>
			<input type="file" id="img-link" name="img_link">
		</div>

		<div class="form-row button-row">
			<button type="submit" class="button red-button"> Edit </button>
			<button type="reset" class="button white-button"> Clear </button>
		</div>
	</form>

	<?php endif; ?>

	</div>

	</section>

	<?php require "footer.html"; ?>

</body>
</html>