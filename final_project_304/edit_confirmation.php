<?php require "login_partial.php";

	if (empty($_SESSION['logged_in'])) {

		$error = "You do not have permission to access this page.";
		header('Location: index.php');

	} else if (empty($_POST['id'])) {

		$error = "Invalid page.";
		header('Location: index.php');

	} else {

		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if ($mysqli->connect_errno) {
			echo "MySQL Connection Error: ";
			echo $mysqli->connect_error;
			exit();
		}

		$mysqli->set_charset('utf8');

		$id = $_POST['id'];

		$sql_existing = "SELECT * FROM attractions
						WHERE id = '$id';";

		$results_existing = $mysqli->query($sql_existing);

		if(!$results_existing) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		$row_existing = $results_existing->fetch_assoc();

		if ($row_existing['created_by'] != $_SESSION['user_id'] && empty($_SESSION['is_admin'])) {

			$error = "You do not have permission to access this page.";
			
		} else if (empty($_POST['attraction']) || empty($_POST['category_id']) || empty($_POST['hours_id']) || empty($_POST['price_range_id']) || empty($_POST['address']) || empty($_POST['website']) || empty($_POST['description'])) {

			$error = "Please fill out all required fields.";

		} else if ($_FILES['img_link']['error'] > 0 && $_FILES['img_link']['error'] != 4) {

			$error = "The attraction was not added because of Image Error #" . $_FILES['img_link']['error'];

		} else {

			$attraction = $_POST['attraction'];
			$category = $_POST['category_id'];
			$address = $_POST['address'];
			$website = $_POST['website'];
			$description = $_POST['description'];
			$price_range = $_POST['price_range_id'];
			$hours = $_POST['hours_id'];

			if ($_FILES['img_link']['error'] != 4) {
				$img_link = "uploads/" . uniqid() . "_" . $_FILES['img_link']['name'];
				$img_link = preg_replace('/\s/', '_', $img_link);
				move_uploaded_file($_FILES['img_link']['tmp_name'], $img_link);
			} else {
				$img_link = $row_existing['img_link'];
			}

			$sql = "UPDATE attractions
					SET name = '$attraction',
					category_id = $category,
					address = '$address',
					website = '$website',
					description = '$description',
					price_range_id = '$price_range',
					img_link = '$img_link',
					hours_id = '$hours'
					WHERE id = $id;";

			$results = $mysqli->query($sql);

			if ( !$results ) {
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
	<title> The LA Explorer | Edit Confirmation </title>

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
		<li><a href="edit_form.php<?php if (!empty($id)): ?>?id=<?php echo $id; ?><?php endif; ?>"> Edit </a></li>
		<li> Edit Confirmation </li>
	</ul>

	<div class="form-wrap add-edit-search">

		<?php if (!empty($error)): ?>

			<div class="space-fill required">
				<p><?php echo $error; ?></p>
				<p class="back"><a href="edit_form.php<?php if (!empty($id)): ?>?id=<?php echo $id; ?><?php endif; ?>"> Back to Edit Page </a></p>
			</div>

		<?php else: ?>
			
			<div class="space-fill">
				<p><span class="required"><?php echo $attraction; ?></span> has been successfully edited. </p>
				<p class="back"><a href="details.php?id=<?php echo $id; ?>"> Back to Details Page </a></p>
			</div>

		<?php endif; ?>

	</div>

	</section>

	<?php require "footer.html"; ?>

</body>
</html>