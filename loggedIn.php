<?php
session_start();
?>

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
			<a class="navbar-brand" href="loggedIn.php">The Movies DB</a>
			<div class="collapse navbar-collapse" id="navbarColor02">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="favorites.php">Favorites<span class="sr-only">(current)</span></a>
					</li>
					</ul> <?php echo "
				<p class='navUserWelcome'>Welcome <strong>{$_SESSION['username']}</strong>.</p>"
				?>
				<div>
					<a href='logout.php' class='btn btn-success logout_btn'>Log out</a>
				</div>
			</div>
		</div>
	</nav>

	<div class="container">
		<div class="jumbotron">
			<h3 class="text-center">Search your movie or tv show here</h3>
			<form id="searchForm">
				<input type="text" class="form-control" id="searchText" placeholder="Search Movies...">
			</form>
		</div>
	</div>

	<div class="container">
		<div id="movies" class="row"></div>
	</div>



	<script
	src="https://code.jquery.com/jquery-3.3.1.min.js"
	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
	crossorigin="anonymous"></script>
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
	<script src="js/main.js"></script>
</body>
</html>

