<?php

	require "config/config.php";

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
			WHERE 1 = 1";

	if (!empty($_GET['attraction'])) {
		$attraction = $_GET['attraction'];
		$sql = $sql . " AND name LIKE '%$attraction%'";
	} else {
		$attraction = "";
	}

	if (!empty($_GET['category_id'])) {
		$category_id = $_GET['category_id'];
		$sql = $sql . " AND categories.id = $category_id";
	} else {
		$category_id = "";
	}

	if (!empty($_GET['hours_id'])) {
		$hours_id = $_GET['hours_id'];
		$sql = $sql . " AND hours.id = $hours_id";
	} else {
		$hours_id = "";
	}

	if (!empty($_GET['price_range_id'])) {
		$price_range_id = $_GET['price_range_id'];
		$sql = $sql . " AND price_ranges.id = $price_range_id";
	} else {
		$price_range_id = "";
	}

	$sql = $sql . ";";

	$results = $mysqli->query($sql);
	if (!$results) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}


	$results_per_page = 8;
	$num_results = $results->num_rows;

	if ($num_results == 0) {
		$last_page = 1;
	} else {
		$last_page = ceil($num_results / $results_per_page);
	}

	if (!empty($_GET['page'])) {
		$current_page = $_GET['page'];
	} else {
		$current_page = 1;
	}

	if ($current_page < 1) {
		$current_page = 1;
	} elseif ($current_page > $last_page) {
		$current_page = $last_page;
	}

	$start_index = ($current_page - 1) * $results_per_page;

	$sql = str_replace(';', '', $sql);

	$sql = $sql . " LIMIT $start_index, $results_per_page;";

	$results = $mysqli->query($sql);

	if ( !$results ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	
	$mysqli->close();
	
?>

<!DOCTYPE html>
<html>
<head>
	<title> The LA Explorer | Results </title>

	<?php require "head.html"; ?>

	<!-- CSS -->
	<link rel="stylesheet" href="css/search_results.css">

	<!-- Description -->
	<meta name="description" content="">
</head>
<body>

	<?php require "nav.html"; ?>

	<section>

		<ul class="breadcrumb">
			<li><a href="search_form.php"> Search </a></li>
			<li> Search Results </li>
		</ul>

		<div id="results-num">
			<?php if ($num_results == 0): ?>
				
				<p> No attractions matched your search. </p>

			<?php else: ?>

				<p>
					Showing 
					<?php echo $start_index + 1; ?>
					- 
					<?php echo $start_index + $results->num_rows; ?>
					of 
					<?php echo $num_results; ?> 
					result(s).
				</p>

			<?php endif; ?>
		</div>

		<ul class="pagination">
			<li class="<?php if ($current_page == 1) {echo 'disabled';} ?>">
				<a href="<?php $_GET['page'] = 1; echo $_SERVER['PHP_SELF'] . '?' . http_build_query($_GET); ?>">First</a>
			</li>
			<li class="<?php if ($current_page == 1) {echo 'disabled';} ?>">
				<a href="<?php $_GET['page'] = $current_page - 1; echo $_SERVER['PHP_SELF'] . '?' . http_build_query($_GET); ?>">Previous</a>
			</li>
			<li class="active">
				<a href=""><?php echo $current_page; ?></a>
			</li>
			<li class="<?php if ($current_page == $last_page) {echo 'disabled';} ?>">
				<a href="<?php $_GET['page'] = $current_page + 1; echo $_SERVER['PHP_SELF'] . '?' . http_build_query($_GET); ?>">Next</a>
			</li>
			<li class="<?php if ($current_page == $last_page) {echo 'disabled';} ?>">
				<a href="<?php $_GET['page'] = $last_page; echo $_SERVER['PHP_SELF'] . '?' . http_build_query($_GET); ?>">Last</a>
			</li>
		</ul>

		<div id="search-results">

			<?php while ($row = $results->fetch_assoc()): ?>

			<div class="wrap">
				<a href="details.php?id=<?php echo $row['id']; ?>" class="indiv-results">
					<div class="img-wrap">
						<img src="<?php echo $row['img_link']; ?>" alt="<?php echo $row['name']; ?>">
					</div>

					<div class="info">
						<span class="category">
							<?php echo $row['category']; ?>
						</span>
						<h4> <?php echo $row['name']; ?> </h4>
						<span>
							<?php echo $row['address']; ?>
						</span>
						<span>
							<?php echo $row['price']; ?>
						</span>
						<span>
							<?php echo $row['hours']; ?>
						</span>
					</div>			
				</a>
				
				<?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>

					<div class="buttons">
						<a href="favorites.php?attraction_id=<?php echo $row['id']; ?>"><img src="links/favorite.png" alt="favorite icon"></a>

						<?php if (isset($_SESSION['is_admin']) || $row['created_by'] == $_SESSION['user_id']): ?>

							<a href="delete.php?attraction_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete \'<?php echo $row['name']; ?>\'?');"><img src="links/delete.png" alt="delete icon"></a>
							<a href="edit_form.php?id=<?php echo $row['id']; ?>"><img src="links/edit.png" alt="edit icon"></a>

						<?php endif; ?>

					</div>

				<?php endif; ?>
				
			</div>

			<?php endwhile; ?>

		</div>

		<ul class="pagination">
			<li class="<?php if ($current_page == 1) {echo 'disabled';} ?>">
				<a href="<?php $_GET['page'] = 1; echo $_SERVER['PHP_SELF'] . '?' . http_build_query($_GET); ?>">First</a>
			</li>
			<li class="<?php if ($current_page == 1) {echo 'disabled';} ?>">
				<a href="<?php $_GET['page'] = $current_page - 1; echo $_SERVER['PHP_SELF'] . '?' . http_build_query($_GET); ?>">Previous</a>
			</li>
			<li class="active">
				<a href=""><?php echo $current_page; ?></a>
			</li>
			<li class="<?php if ($current_page == $last_page) {echo 'disabled';} ?>">
				<a href="<?php $_GET['page'] = $current_page + 1; echo $_SERVER['PHP_SELF'] . '?' . http_build_query($_GET); ?>">Next</a>
			</li>
			<li class="<?php if ($current_page == $last_page) {echo 'disabled';} ?>">
				<a href="<?php $_GET['page'] = $last_page; echo $_SERVER['PHP_SELF'] . '?' . http_build_query($_GET); ?>">Last</a>
			</li>
		</ul>

	</section>

	<?php require "footer.html"; ?>

</body>
</html>