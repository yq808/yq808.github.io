<?php require "login_partial.php"; ?>

<!DOCTYPE html>
<html>
<head>
	<title> The LA Explorer | Project Summary </title>

	<?php require "head.html"; ?>

	<!-- CSS -->

	<!-- Description -->
	<meta name="description" content="">

	<style>
		img {
			width: 50%;
		}
	</style>

</head>
<body>

	<?php require "nav.html"; ?>

	<section>
	
	<h2> Project Summary </h2>

	<div>
		<h4> Topic & Purpose </h4>
		<p>  The website I created is a LA travel website. Users are able to use the website to find new places to explore in Los Angeles. </p>
	</div>

	<div>
		<h4> Instructions </h4>
		<p> The Home page provides a basic introduction to the website and its functions. On the Browse page, users can search for attractions and filter their search based on what they're looking for. Results are displayed on the Search Results page, and users can click into each one to get more details. The Favorites and Add Form pages are only accessible after users create an account and sign in. On the Search Results and Details pages, the button to favorite will only appear if users are logged in. Similarly, users are only able to edit and delete attractions that they have added to the database so the buttons for editing and deleting will only appear on attractions they add (username <em>user</em> password <em>userpass</em>). There is full CRUD functionality at the admin level (username <em>ttrojan</em> and password <em>usc</em>). Attractions that users have favorited will show up on the Favorites page, and can be removed. </p>
	</div>

	<div>
		<h4> Database </h4>
		<p> I couldn't really find a database that encompassed travel destinations in Los Angeles, so I input them myself. I searched on Google for LA tourism guides, and used the places mentioned to do more research and find the necessary information. The data for the 'users' and 'favorites' tables come from user input on the website. Below is my database diagram: </p>
		<img src="links/diagram.png" alt="database diagram">
	</div>

	<div>
		<h4> Extras </h4>
		<ol>
			<li><em>Sessions</em> — I used sessions to save if users were logged in and if so, their user_id and if they were an admin or not. This was used to control what was displayed to users depending on different permission levels. </li>
			<li><em>Different User Permission Levels</em> — General users are able to search for attractions, registered and logged in users are able to favorite and add attractions as well as edit and delete attractions they add, and admins have full CRUD functionality over all data. Logging in with username <em>ttrojan</em> and password <em>usc</em> will grant admin access. </li>
			<li><em>File Upload</em> — On the edit and add forms, I used file upload so users can upload images from their computer to use on the website when adding or editing an attraction. The files are stored in the folder 'uploads'. </li>
			<li><em>Many-to-Many Table Relationship</em> — The table 'favorites' joins the 'users' and 'attractions' tables. This allows a user to favorite multiple attractions and for an attraction to be favorited by multiple users. On the Favorites page, only attractions that belong to the user are selected and displayed. </li>
		</ol>
	</div>

	<div>
		<h4> Miscellaneous </h4>
		<p> I did not use any frameworks for the website. </p>
	</div>

	</section>

	<?php require "footer.html"; ?>

</body>
</html>