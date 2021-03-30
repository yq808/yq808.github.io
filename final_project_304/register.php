<!DOCTYPE html>
<html>
<head>
	<title> The LA Explorer | Register </title>

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

		<p> Create an account to be able to add and favorite attractions. </p>

		<form action="register_confirmation.php" method="POST">
			<div class="form-row">
				<label for="email-register"> Email: <span class="required">*</span></label>
				<input type="text" id="email-register" name="email_register">
			</div>

			<div class="form-row">
				<label for="username-register"> Username: <span class="required">*</span></label>
				<input type="text" id="username-register" name="username_register">
			</div>

			<div class="form-row">
				<label for="password-register"> Password: <span class="required">*</span></label>
				<input type="password" id="password-register" name="password_register">
			</div>

			<div class="form-row button-row">
				<button type="submit" class="button red-button"> Create Account </button>
				<button type="reset" class="button white-button"> Clear </button>
			</div>
		</form>

	</div>

	</section>

	<?php require "footer.html"; ?>

</body>
</html>