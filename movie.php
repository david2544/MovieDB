<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>MovieInfo</title>
	<link rel="stylesheet" type="text/css" href="https://bootswatch.com/4/solar/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark">
		<div class="container">
			<a class="navbar-brand" href="index.php">The Movies DB</a>
			<div class="collapse navbar-collapse" id="navbarColor02">
						<?php 
						if (isset($_SESSION['username'])) {
							echo "
							<ul class='navbar-nav mr-auto'>
								<li class='nav-item active'>
									<a class='nav-link' href='favorites.php'>Favorites<span class='sr-only'>(current)</span></a>
								</li>
							</ul>
							<div class='navUserLogged'> Logged in as {$_SESSION['username']} </div>";
						} else {
							echo '
							<ul class="navbar-nav mr-auto">
								<li class="nav-item active">
									<a class="nav-link" href="register.php">Register <span class="sr-only">(current)</span></a>
								</li>
							</ul>';
						}
						?>
			</div>
		</div>
	</nav>

	<div class="container">
		<div id="movie" class="well"></div>
	</div>

	<script
	src="https://code.jquery.com/jquery-3.3.1.min.js"
	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
	crossorigin="anonymous"></script>
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
	<script src="js/main.js"></script>
	<script>
		getMovie();
	</script>
</body>
</html>

