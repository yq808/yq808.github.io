<?php require "login_partial.php"; ?>

<!DOCTYPE html>
<html>
<head>
	<title> The LA Explorer | Home </title>

	<?php require "head.html"; ?>

	<!-- CSS -->
	<link rel="stylesheet" href="css/index.css">

	<!-- Description -->
	<meta name="description" content="">

</head>
<body>

	<?php require "nav.html"; ?>

	<section id="introduction">
		<img src="links/la1.jpg" alt="los angeles">
	</section>

	<section id="explanation">
		<h2> Los Angeles has something for everyone. </h2>
		<p> With 75 miles of sunny coastline, flourishing neighborhoods, acclaimed restaurants, and trend-setting art and fashion scenes, Los Angeles is a vibrant city with much to offer. One of the most popular ways to experience L.A. is by celebrating the city’s incredible diversity, take a scenic drive, or visit the top cultural attractions. The LA Explorer is a place for visitors and residents of Los Angeles alike to find new areas to explore everday. </p>
	</section>

	<section>
		<h2> Explore <span class="emphasis">different categories</span> to find what you most want to experience in Los Angeles. </h2>

		<div id="categories">
			<a href="search_results.php?category_id=7">
				<div class="img-overlay">
					<img src="links/market.jpg" alt="grand central market">
				</div>
				<h4> Markets </h4>
			</a>

			<a href="search_results.php?category_id=8">
				<div class="img-overlay">
					<img src="links/bradbury.jpg" alt="bradbury building">
				</div>
				<h4> Architecture </h4>
			</a>

			<a href="search_results.php?category_id=2">
				<div class="img-overlay">
					<img src="links/getty.jpg" alt="getty center">
				</div>
				<h4> Museum </h4>
			</a>
		</div>

		<div class="redirect" id="center">
			<a class="button" href="search_form.php"> Search For Your Next Destination &rarr; </a>
		</div>
	</section>

	<section class="two-column">
		<div>
			<img src="links/cityscape.jpg" alt="los angeles at night">
		</div>

		<div>
			<h2> There are hundreds of <span class="emphasis">hidden gems</span> around Los Angeles... </h2>
			<p> ...So many, in fact, that they might not appear on The LA Explorer. We encourage you to add any and all attractions around Los Angeles that you happen to stumble upon and want to share with the rest of the web! </p>
			<div class="redirect">
				<a class="button" href="add_form.php"> Share &rarr; </a>
			</div>
		</div>
	</section>

	<section class="two-column">
		<div>
			<h2> Need to <span class="emphasis">bookmark</span> a place? </h2>
			<p> No problem! Simply <a class="website-link" href="#ex1" rel="modal:open"> log in </a> to your account and you can access previous favorited places and add new locations that catch your eye. And of course, remove them when you've checked it off your list. </p>
			<div class="redirect">
				<a class="button" href="favorites.php"> Your Favorites &rarr; </a>
			</div>
		</div>

		<div>
			<img src="links/huntington.jpg" alt="huntington gardens">
		</div>
	</section>

	<?php require "footer.html"; ?>

</body>
</html>