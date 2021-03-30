<?php require "login_partial.php";

	if (empty($_SESSION['logged_in'])) {

		$error = "You do not have permission to access this page.";
		header('Location: index.php');

	} else if (empty($_POST['attraction']) || empty($_POST['category_id']) || empty($_POST['hours_id']) || empty($_POST['price_range_id']) || empty($_POST['address']) || empty($_POST['website']) || empty($_POST['description']) || $_FILES['img_link']['error'] == 4) {

		$error = "Please fill out all required fields.";

	} else if ($_FILES['img_link']['error'] > 0) {

		$error = "The attraction was not added because of Image Error #" . $_FILES['img_link']['error'];
		
	} else {
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if ($mysqli->connect_errno) {
			echo "MySQL Connection Error: ";
			echo $mysqli->connect_error;
			exit();
		}

		$mysqli->set_charset('utf8');

		$attraction = $_POST['attraction'];
		$category = $_POST['category_id'];
		$address = $_POST['address'];
		$website = $_POST['website'];
		$description = $_POST['description'];
		$price_range = $_POST['price_range_id'];
		$hours = $_POST['hours_id'];
		$created_by = $_SESSION['user_id'];

		$img_link = "uploads/" . uniqid() . "_" . $_FILES['img_link']['name'];
		$img_link = preg_replace('/\s/', '_', $img_link);
		move_uploaded_file($_FILES['img_link']['tmp_name'], $img_link);

		$sql_existing = "SELECT * FROM attractions
						WHERE name LIKE '$attraction';";

		$results_existing = $mysqli->query($sql_existing);

		if(!$results_existing) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		if ($results_existing->num_rows >= 1) {
			$error = "The attraction already exists on this website.";
		} else {
			$sql = "INSERT INTO attractions (name, category_id, address, website, description, price_range_id, img_link, hours_id, created_by) VALUES ('$attraction', $category, '$address', '$website', '$description', $price_range, '$img_link', $hours, $created_by);";

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
	<title> The LA Explorer | Add Confirmation </title>

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
		<li><a href="add_form.php"> Add </a></li>
		<li> Add Confirmation </li>
	</ul>

	<div class="form-wrap space-fill add-edit-search">

		<?php if (!empty($error)): ?>
			
			<div class="required space-fill">
				<p><?php echo $error; ?></p>
				<p class="back"><a href="index.php"> Go to Home Page </a></p>
			</div>

		<?php else: ?>

			<div class="space-fill">
				<p><span class="required"><?php echo $attraction; ?></span> has been successfully added. </p>
				<p class="back"><a href="add_form.php"> Add Another </a></p>
			</div>

		<?php endif; ?>

	</div>
	
	</section>

	<?php require "footer.html"; ?>

</body>
</html>