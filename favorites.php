<?php

// Check if session already started
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
// If the user is not logged in, he isn't supposed to be on this page, so we redirect him to index.php
if (!isset($_SESSION['username'])) {
	header("location: index.php");
}
?>
<!--
 ##############################################################
 #########    Start of code partially inspired from ###########
 #########  https://github.com/bradtraversy/movieinfo  ########
 ############################################################## -->

<!-- Rendering the page -->
<!DOCTYPE html>
<html>
<head>
	<title>Movie Search</title>
	<link rel="stylesheet" type="text/css" href="https://bootswatch.com/4/solar/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark">
		<div class="container">
			<a class="navbar-brand" href="index.php">The Movies DB</a>
			<div class="collapse navbar-collapse" id="navbarColor02">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="index.php">Back to search<span class="sr-only">(current)</span></a>
					</li>
				</ul>
				<?="<p class='navUserWelcome'>Welcome <strong>{$_SESSION['username']}</strong>.</p>" ?>
				<div>
					<a href='logout.php' class='btn btn-success logout_btn'>Log out</a>
				</div>
			</div>
		</div>
	</nav>

	<div class="jumbotron container favMovies">
		<div id="favoriteMovies" class="well"></div>
	</div>

	<div class="container" id="removedFavorite"></div>
<!--
 ##############################################################
 #########     End of code partially inspired from  ###########
 #########  https://github.com/bradtraversy/movieinfo  ########
 ############################################################## -->



	<script
	src="https://code.jquery.com/jquery-3.3.1.min.js"
	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
	crossorigin="anonymous"></script>
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
	<script src="js/main.js"></script>
	<!-- Calling the getFavorites function to display the users favorite movies -->
	<script>
		getFavorites();
	</script>
</body>
</html>