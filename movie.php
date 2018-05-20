<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>MovieInfo</title>
	<link rel="stylesheet" type="text/css" href="//bootswatch.com/4/solar/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark">
		<div class="container">
			<a class="navbar-brand" href="index.php">The Movies DB</a>
			<div class="collapse navbar-collapse" id="navbarColor02">
				<?php 
				if (isset($_SESSION['username'])) {
					echo '
					<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
					<a class="nav-link" href="index.php">Back to search<span class="sr-only">(current)</span></a>
					</li>
					</ul>';
				} else {
					echo '
					<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
					<a class="nav-link" href="register.php">Register <span class="sr-only">(current)</span></a>
					</li>
					</ul>';
				}
				?>
				<?php 
				if (isset($_SESSION['username'])) {
					echo "<p class='navUserWelcome'>Welcome <strong>{$_SESSION['username']}</strong>.</p>

					<div>
					<a href='logout.php' class='btn btn-success logout_btn'>Log out</a>
					</div>
					";
				} else {
					echo '
					<form method="POST" class="form-inline my-2 my-lg-0" action="index.php">
					<div class="form-group login-form">
					<input type="text" class="form-control" name="username" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
					</div>
					<div class="form-group login-form">
					<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
					</div>
					<button class="btn btn btn-primary my-2 my-sm-0" name="login_btn" type="submit">Login</button>
					</form>';
				}
				?>
			</div>
		</div>
	</nav>

	<div class="container">
		<div id="movie" class="well"></div>
	</div>

	<script
	src="//code.jquery.com/jquery-3.3.1.min.js"
	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
	crossorigin="anonymous"></script>
	<script src="//unpkg.com/axios/dist/axios.min.js"></script>
	<script src="js/main.js"></script>
	<script>
		getMovie();
	</script>
</body>
</html>

